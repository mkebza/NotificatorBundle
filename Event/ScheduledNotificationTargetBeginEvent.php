<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Notificator\Event;

use MKebza\Notificator\Scheduled\ScheduledGroupInterface;
use MKebza\Notificator\Scheduled\ScheduledNotificationTarget;
use Symfony\Component\EventDispatcher\Event;

class ScheduledNotificationTargetBeginEvent extends Event
{
    /**
     * @var ScheduledGroupInterface
     */
    private $group;

    /**
     * @var ScheduledNotificationTarget
     */
    private $target;

    /**
     * ScheduledNotificationTargetBeginEvent constructor.
     *
     * @param ScheduledGroupInterface     $group
     * @param ScheduledNotificationTarget $target
     */
    public function __construct(ScheduledGroupInterface $group, ScheduledNotificationTarget $target)
    {
        $this->group = $group;
        $this->target = $target;
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
}
