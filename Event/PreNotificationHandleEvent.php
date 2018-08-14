<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Notificator\Event;

use MKebza\Notificator\Notification;
use MKebza\Notificator\NotificationInterface;
use Symfony\Component\EventDispatcher\Event;

final class PreNotificationHandleEvent extends Event
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
     * PreNotificationHandleEvent constructor.
     *
     * @param Notification          $notification
     * @param NotificationInterface $notificationHandler
     * @param array                 $options
     */
    public function __construct(Notification $notification, NotificationInterface $notificationHandler, array $options)
    {
        $this->notification = $notification;
        $this->notificationHandler = $notificationHandler;
        $this->options = $options;
    }

    /**
     * @return Notification
     */
    public function getNotification(): Notification
    {
        return $this->notification;
    }

    /**
     * @param Notification $notification
     */
    public function setNotification(Notification $notification): void
    {
        $this->notification = $notification;
    }

    /**
     * @return NotificationInterface
     */
    public function getNotificationHandler(): NotificationInterface
    {
        return $this->notificationHandler;
    }

    /**
     * @param NotificationInterface $notificationHandler
     */
    public function setNotificationHandler(NotificationInterface $notificationHandler): void
    {
        $this->notificationHandler = $notificationHandler;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options): void
    {
        $this->options = $options;
    }
}
