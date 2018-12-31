<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MKebza\Notificator\Scheduled\KeyRegistry;

interface ScheduledKeyRegistryInterface
{
    public function add(string $key): void;

    public function has(string $key): bool;
}
