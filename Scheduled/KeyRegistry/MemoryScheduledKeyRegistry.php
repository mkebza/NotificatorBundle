<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Notificator\Scheduled\KeyRegistry;

class MemoryScheduledKeyRegistry implements ScheduledKeyRegistryInterface
{
    private $keys = [];

    public function add(string $key): void
    {
        $this->keys[] = $key;
    }

    public function has(string $key): bool
    {
        return in_array($key, $this->keys, true);
    }
}
