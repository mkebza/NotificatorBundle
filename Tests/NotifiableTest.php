<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Notificator\Tests;

use MKebza\Notificator\Notifiable;
use PHPUnit\Framework\TestCase;

class NotifiableTest extends TestCase
{
    public function testGetNotificationChannels()
    {
        $data = [
            'email' => ['email' => 'foo@example.com'],
        ];
        $target = new Notifiable($data);
        $this->assertSame($data, $target->getNotificationChannels());
    }
}
