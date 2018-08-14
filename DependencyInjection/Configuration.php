<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Notificator\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('mkebza_notificator');

        $rootNode
            ->children()
                ->arrayNode('handlers')
                    ->useAttributeAsKey('name')
                    ->arrayPrototype()
                        ->beforeNormalization()
                            ->ifString()
                            ->then(function ($v) { return ['service' => $v]; })
                        ->end()
                        ->children()
                            ->scalarNode('service')->end()
                            ->variableNode('options')->defaultValue([])->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
