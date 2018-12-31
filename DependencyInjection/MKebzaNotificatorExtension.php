<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Notificator\DependencyInjection;

use MKebza\Notificator\Handler\NotificationHandlerRegistry;
use MKebza\Notificator\Scheduled\ScheduledGroupInterface;
use MKebza\Notificator\Scheduled\ScheduledNotificator;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class MKebzaNotificatorExtension extends Extension
{
    /**
     * Loads a specific configuration.
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.yaml');

        $config = $this->processConfiguration(new Configuration(), $configs);
        $this->registerHandlers($config['handlers'], $container);

        $container
            ->getDefinition(ScheduledNotificator::class)
            ->setArgument('$keyRegistry', new Reference($config['scheduled_key_registry']));

        $container
            ->registerForAutoconfiguration(ScheduledGroupInterface::class)
            ->addTag('mkebza_notificator.scheduled_group');
    }

    protected function registerHandlers(array $handlers, ContainerBuilder $container): void
    {
        $registry = $container->getDefinition(NotificationHandlerRegistry::class);
        foreach ($handlers as $name => $handlerConfiguration) {
            $registry->addMethodCall('add', [$name, new Reference($handlerConfiguration['service']), $handlerConfiguration['options']]);

            $handler = $container->getDefinition($handlerConfiguration['service']);
            $handler->addMethodCall('configure', [$handlerConfiguration['options']]);
        }
    }
}
