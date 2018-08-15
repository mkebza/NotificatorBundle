<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MKebza\Notificator\Tests\Event;

use MKebza\Notificator\Event\PreNotificationHandleEvent;
use MKebza\Notificator\Notification;
use MKebza\Notificator\NotificationInterface;
use PHPUnit\Framework\TestCase;

class PreNotificationHandleEventTest extends TestCase
{
    public function testGetters()
    {
        $notificationObject = new Notification('foo', 'bar');
        $notificationMock = $this->createMock(NotificationInterface::class);

        $event = new PreNotificationHandleEvent($notificationObject, $notificationMock, ['foo' => 'bar']);
        $this->assertSame($notificationObject, $event->getNotification());
        $this->assertSame($notificationMock, $event->getNotificationHandler());
        $this->assertSame(['foo' => 'bar'], $event->getOptions());
    }
}
