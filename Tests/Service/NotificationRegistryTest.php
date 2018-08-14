<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MKebza\Notificator\Tests\Service;

use MKebza\Notificator\Service\NotificationRegistry;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ServiceLocator;

class NotificationRegistryTest extends TestCase
{
    public function testGet()
    {
        $locator = $this->createMock(ServiceLocator::class);

        $registry = new NotificationRegistry($locator);
        $registry->get('TestNotification');
    }
}
