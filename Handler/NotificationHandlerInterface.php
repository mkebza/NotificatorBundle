<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Notificator\Handler;

use MKebza\Notificator\Notification;

interface NotificationHandlerInterface
{
    public function configure(array $options): void;

    public function handle(Notification $notification): void;
}
