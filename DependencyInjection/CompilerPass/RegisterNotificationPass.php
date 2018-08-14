<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Notificator\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RegisterNotificationPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $locator = $container->getDefinition('mkebza_notificator.notification_locator');

        $services = [];
        foreach ($container->findTaggedServiceIds('mkebza_notificator.notification') as $id => $tags) {
            $services[$id] = new Reference($id);
        }

        $locator->setArgument(0, $services);
    }
}
