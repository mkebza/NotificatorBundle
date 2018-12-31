<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MKebza\Notificator\Scheduled;

use MKebza\Notificator\ScheduledNotificationInterface;

interface ScheduledGroupInterface
{
    /**
     * @return ScheduledNotificationTarget[]
     */
    public function getPossibleTargets(): iterable;

    /**
     * @return ScheduledNotificationInterface[]
     */
    public function getPossibleNotifications(): array;
}
