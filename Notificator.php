<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Notificator;

use MKebza\Notificator\Event\PostNotificationHandleEvent;
use MKebza\Notificator\Event\PreNotificationHandleEvent;
use MKebza\Notificator\Handler\NotificationHandlerRegistryInterface;
use MKebza\Notificator\Service\NotificationRegistryInterface;
use MKebza\Notificator\Service\TargetNormalizerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Notificator implements NotificatorInterface
{
    /**
     * @var TargetNormalizerInterface
     */
    protected $targetNormalizer;

    /**
     * @var NotificationHandlerRegistryInterface
     */
    protected $handlerRegistry;

    /**
     * @var NotificationRegistryInterface
     */
    protected $notificationRegistry;

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * Notificator constructor.
     *
     * @param TargetNormalizerInterface            $targetNormalizer
     * @param NotificationHandlerRegistryInterface $handlerRegistry
     * @param NotificationRegistryInterface        $notificationRegistry
     * @param EventDispatcherInterface             $dispatcher
     */
    public function __construct(
        TargetNormalizerInterface $targetNormalizer,
        NotificationHandlerRegistryInterface $handlerRegistry,
        NotificationRegistryInterface $notificationRegistry,
        EventDispatcherInterface $dispatcher
    ) {
        $this->targetNormalizer = $targetNormalizer;
        $this->handlerRegistry = $handlerRegistry;
        $this->notificationRegistry = $notificationRegistry;
        $this->dispatcher = $dispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function send($targets, string $notificationClass, array $options = []): void
    {
        $targets = $this->targetNormalizer->normalize($targets);
        $notificationHandler = $this->notificationRegistry->get($notificationClass);

        foreach ($targets as $target) {
            foreach ($notificationHandler->getChannels($target) as $channelName) {
                $subscribed = $target->getNotificationChannels();
                if (!isset($subscribed[$channelName])) {
                    continue;
                }

                $notification = new Notification($subscribed[$channelName], $channelName);

                $this->dispatcher->dispatch(PreNotificationHandleEvent::class, new PreNotificationHandleEvent(
                    $notification, $notificationHandler, $options, $target
                ));

                $notificationHandler->{$channelName}($notification, $options);
                $this->handlerRegistry->get($channelName)->handle($notification);

                $this->dispatcher->dispatch(PostNotificationHandleEvent::class, new PostNotificationHandleEvent(
                    $notification, $notificationHandler, $options, $target
                ));
            }
        }
    }
}
