<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MKebza\Notificator\Tests\Handler;

use MKebza\Notificator\Exception\NotificationHandlerNotFoundException;
use MKebza\Notificator\Handler\NotificationHandlerInterface;
use MKebza\Notificator\Handler\NotificationHandlerRegistry;
use PHPUnit\Framework\TestCase;

class NotificationHandlerRegistryTest extends TestCase
{
    public function testHas()
    {
        $registry = new NotificationHandlerRegistry();
        $handlerMock = $this->createMock(NotificationHandlerInterface::class);

        $this->assertFalse($registry->has('foo'));
        $registry->add('foo', $handlerMock);
        $this->assertTrue($registry->has('foo'));
    }

    public function testAddAndGet()
    {
        $registry = new NotificationHandlerRegistry();

        $handlerMock = $this->createMock(NotificationHandlerInterface::class);

        // Chech that there is no handler test
        $this->expectException(NotificationHandlerNotFoundException::class);
        $registry->get('test');

        $registry->add('test', $handlerMock);
        $this->assertSame($handlerMock, $registry->get('test'));
    }
}
