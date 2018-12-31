<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Notificator\Scheduled;

use MKebza\Notificator\Event\ScheduledGroupBeginEvent;
use MKebza\Notificator\Event\ScheduledNotificationSentEvent;
use MKebza\Notificator\Event\ScheduledNotificationSkippedEvent;
use MKebza\Notificator\Event\ScheduledNotificationTargetBeginEvent;
use MKebza\Notificator\NotificatorInterface;
use MKebza\Notificator\Scheduled\KeyRegistry\ScheduledKeyRegistryInterface;
use MKebza\Notificator\ScheduledNotificationInterface;
use MKebza\Notificator\Service\NotificationRegistryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ScheduledNotificator
{
    /**
     * @var NotificationRegistryInterface
     */
    private $notificationRegistry;

    /**
     * @var NotificatorInterface
     */
    private $notificator;

    /**
     * @var ScheduledKeyRegistryInterface
     */
    private $keyRegistry;

    /**
     * @var ScheduledGroupRegistry
     */
    private $scheduledGroupRegistry;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * ScheduledNotificator constructor.
     *
     * @param NotificationRegistryInterface $notificationRegistry
     * @param NotificatorInterface          $notificator
     * @param ScheduledKeyRegistryInterface $keyRegistry
     * @param ScheduledGroupRegistry        $scheduledGroupRegistry
     * @param EventDispatcherInterface      $dispatcher
     */
    public function __construct(
        NotificationRegistryInterface $notificationRegistry,
        NotificatorInterface $notificator,
        ScheduledKeyRegistryInterface $keyRegistry,
        ScheduledGroupRegistry $scheduledGroupRegistry,
        EventDispatcherInterface $dispatcher
    ) {
        $this->notificationRegistry = $notificationRegistry;
        $this->notificator = $notificator;
        $this->keyRegistry = $keyRegistry;
        $this->scheduledGroupRegistry = $scheduledGroupRegistry;
        $this->dispatcher = $dispatcher;
    }

    public function process(string $groupName = null): void
    {
        $groups = null === $groupName ? $this->scheduledGroupRegistry->all() : [$this->scheduledGroupRegistry->get($groupName)];
        foreach ($groups as $group) {
            $this->dispatcher->dispatch(ScheduledGroupBeginEvent::class, new ScheduledGroupBeginEvent($group));

            foreach ($group->getPossibleTargets() as $possibleTarget) {
                $this->dispatcher->dispatch(ScheduledNotificationTargetBeginEvent::class, new ScheduledNotificationTargetBeginEvent($group, $possibleTarget));

                foreach ($group->getPossibleNotifications() as $notificationClass) {
                    $notification = $this->notificationRegistry->get($notificationClass);
                    if (!$notification instanceof ScheduledNotificationInterface) {
                        throw new \LogicException(sprintf("Trying to use notification '%s' as scheduled but notification doesn't implement %s",
                            $notificationClass, ScheduledNotificationInterface::class
                        ));
                    }

                    $notificationKey = $notification->getPlannedKey($possibleTarget);
                    if ($this->keyRegistry->has($notificationKey)) {
                        $this->dispatcher->dispatch(
                            ScheduledNotificationSkippedEvent::class,
                            new ScheduledNotificationSkippedEvent(
                                $group, $possibleTarget, $notification, ScheduledNotificationSkippedEvent::KEY_EXISTS
                            )
                        );

                        continue;
                    }

                    if (!$notification->isPlanned($possibleTarget)) {
                        $this->dispatcher->dispatch(
                            ScheduledNotificationSkippedEvent::class,
                            new ScheduledNotificationSkippedEvent(
                                $group, $possibleTarget, $notification, ScheduledNotificationSkippedEvent::NOT_PLANNED
                            )
                        );

                        continue;
                    }

                    $this->notificator->send(
                        $possibleTarget->getTarget(),
                        $notificationClass,
                        $possibleTarget->getOptions()
                    );

                    $this->keyRegistry->add($notificationKey);

                    $this->dispatcher->dispatch(
                        ScheduledNotificationSentEvent::class,
                        new ScheduledNotificationSentEvent($group, $possibleTarget, $notification)
                    );
                }
            }
        }
    }
}
