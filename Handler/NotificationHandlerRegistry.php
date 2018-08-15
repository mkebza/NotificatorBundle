<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Notificator\Handler;

use MKebza\Notificator\Exception\NotificationHandlerNotFoundException;

class NotificationHandlerRegistry implements NotificationHandlerRegistryInterface
{
    /**
     * @var NotificationHandlerInterface[]
     */
    private $handlers;

    public function add(string $name, NotificationHandlerInterface $handler)
    {
        $this->handlers[$name] = $handler;
    }

    public function get(string $name): NotificationHandlerInterface
    {
        if (!$this->has($name)) {
            throw new NotificationHandlerNotFoundException(sprintf("Can't find notification handler %s", $name));
        }

        return $this->handlers[$name];
    }

    public function has(string $name): bool
    {
        return isset($this->handlers[$name]);
    }
}
