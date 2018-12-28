<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Notificator\Event;

use MKebza\Notificator\NotifiableInterface;
use MKebza\Notificator\Notification;
use MKebza\Notificator\NotificationInterface;
use Symfony\Component\EventDispatcher\Event;

final class PostNotificationHandleEvent extends Event
{
    /**
     * @var Notification
     */
    private $notification;

    /**
     * @var NotificationInterface
     */
    private $notificationHandler;

    /**
     * @var array
     */
    private $options;

    /**
     * @var NotifiableInterface
     */
    private $target;

    /**
     * PostNotificationHandleEvent constructor.
     * @param Notification $notification
     * @param NotificationInterface $notificationHandler
     * @param array $options
     * @param NotifiableInterface $target
     */
    public function __construct(
        Notification $notification,
        NotificationInterface $notificationHandler,
        array $options,
        NotifiableInterface $target
    ) {
        $this->notification = $notification;
        $this->notificationHandler = $notificationHandler;
        $this->options = $options;
        $this->target = $target;
    }


    /**
     * @return NotifiableInterface
     */
    public function getTarget(): NotifiableInterface
    {
        return $this->target;
    }
    

    /**
     * @return Notification
     */
    public function getNotification(): Notification
    {
        return $this->notification;
    }

    /**
     * @return NotificationInterface
     */
    public function getNotificationHandler(): NotificationInterface
    {
        return $this->notificationHandler;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}
