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
use Symfony\Component\EventDispatcher\Event;

class ScheduledGroupBeginEvent extends Event
{
    /**
     * @var ScheduledGroupInterface
     */
    private $group;

    /**
     * ScheduledGroupBeginEvent constructor.
     *
     * @param ScheduledGroupInterface $group
     */
    public function __construct(ScheduledGroupInterface $group)
    {
        $this->group = $group;
    }

    /**
     * @return ScheduledGroupInterface
     */
    public function getGroup(): ScheduledGroupInterface
    {
        return $this->group;
    }
}
