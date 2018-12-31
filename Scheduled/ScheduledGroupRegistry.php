<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Notificator\Scheduled;

use MKebza\Notificator\Exception\ScheduledGroupNotFoundException;

class ScheduledGroupRegistry
{
    private $groups = [];

    /**
     * ScheduledGroupRegistry constructor.
     *
     * @param $groups
     */
    public function __construct(iterable $groups)
    {
        foreach ($groups as $group) {
            $this->add($group);
        }
    }

    public function add(ScheduledGroupInterface $group)
    {
        $this->groups[get_class($group)] = $group;
    }

    /**
     * @return ScheduledGroupInterface[]
     */
    public function all(): array
    {
        return $this->groups;
    }

    public function has(string $group): bool
    {
        return array_key_exists($group, $this->groups);
    }

    public function get(string $group): ScheduledGroupInterface
    {
        if (!$this->has($group)) {
            throw new ScheduledGroupNotFoundException(sprintf("Requested scheduled group '%s' doesn't exists", $group));
        }

        return $this->groups[$group];
    }
}
