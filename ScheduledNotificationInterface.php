<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Notificator;

use MKebza\Notificator\Scheduled\ScheduledNotificationTarget;

interface ScheduledNotificationInterface
{
    public function isPlanned(ScheduledNotificationTarget $target): bool;

    public function getPlannedKey(ScheduledNotificationTarget $target): string;
}
