<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Notificator\Event;

use MKebza\Notificator\NotificationInterface;
use MKebza\Notificator\Scheduled\ScheduledGroupInterface;
use MKebza\Notificator\Scheduled\ScheduledNotificationTarget;
use Symfony\Component\EventDispatcher\Event;

class ScheduledNotificationSkippedEvent extends Event
{
    const NOT_PLANNED = 'not_planned';
    const KEY_EXISTS = 'key_exists';
    /**
     * @var ScheduledGroupInterface
     */
    private $group;

    /**
     * @var ScheduledNotificationTarget
     */
    private $target;

    /**
     * @var NotificationInterface
     */
    private $notification;

    /**
     * @var string
     */
    private $reason;

    /**
     * ScheduledNotificationSkippedEvent constructor.
     *
     * @param ScheduledGroupInterface     $group
     * @param ScheduledNotificationTarget $target
     * @param NotificationInterface       $notification
     * @param string                      $reason
     */
    public function __construct(
        ScheduledGroupInterface $group,
        ScheduledNotificationTarget $target,
        NotificationInterface $notification,
        string $reason
    ) {
        $this->group = $group;
        $this->target = $target;
        $this->notification = $notification;
        $this->reason = $reason;
    }

    /**
     * @return ScheduledGroupInterface
     */
    public function getGroup(): ScheduledGroupInterface
    {
        return $this->group;
    }

    /**
     * @return ScheduledNotificationTarget
     */
    public function getTarget(): ScheduledNotificationTarget
    {
        return $this->target;
    }

    /**
     * @return NotificationInterface
     */
    public function getNotification(): NotificationInterface
    {
        return $this->notification;
    }

    /**
     * @return string
     */
    public function getReason(): string
    {
        return $this->reason;
    }
}
