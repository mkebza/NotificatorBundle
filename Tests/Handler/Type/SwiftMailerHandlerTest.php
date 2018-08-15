<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MKebza\Notificator\Tests\Handler\Type;

use MKebza\Notificator\Exception\InvalidNotificationContentException;
use MKebza\Notificator\Handler\Type\SwiftMailerHandler;
use MKebza\Notificator\Notification;
use PHPUnit\Framework\TestCase;

class SwiftMailerHandlerTest extends TestCase
{
    public function testHandle()
    {
        $mailerMock = $this->createMock(\Swift_Mailer::class);
        $mailerMock
            ->expects($this->once())
            ->method('send')
            ->with($this->isInstanceOf(\Swift_Message::class));

        $handler = new SwiftMailerHandler($mailerMock);

        $messageMock = $this->createMock(\Swift_Message::class);

        $notification = new Notification('foo@bar.com', 'email');
        $notification->setContent($messageMock);

        $handler->handle($notification);
    }

    public function testHandleMessageDefaultValues()
    {
        $mailerMock = $this->createMock(\Swift_Mailer::class);
        $mailerMock
            ->expects($this->once())
            ->method('send')
            ->with($this->isInstanceOf(\Swift_Message::class));

        $handler = new SwiftMailerHandler($mailerMock);
        $handler->configure(['from_name' => 'Foo', 'from_email' => 'bar@foo.com']);

        $messageMock = $this->createMock(\Swift_Message::class);
        $messageMock
            ->expects($this->once())
            ->method('setTo')
            ->with('foo@bar.com');
        $messageMock
            ->expects($this->once())
            ->method('setFrom')
            ->with(['bar@foo.com' => 'Foo']);

        $notification = new Notification('foo@bar.com', 'email');
        $notification->setContent($messageMock);

        $handler->handle($notification);
    }

    public function testHandleEmptyContentError()
    {
        $mailerMock = $this->createMock(\Swift_Mailer::class);

        $handler = new SwiftMailerHandler($mailerMock);
        $handler->configure(['from_name' => 'Foo', 'from_email' => 'foo@bar.com']);

        $notification = new Notification('foo@bar.com', 'email');

        $this->expectException(InvalidNotificationContentException::class);
        $handler->handle($notification);
    }
}
