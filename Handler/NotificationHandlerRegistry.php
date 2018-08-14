<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Notificator\Handler;

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
        return $this->handlers[$name];
    }
}
