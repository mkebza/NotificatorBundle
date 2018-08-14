<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Notificator;

use MKebza\Notificator\DependencyInjection\CompilerPass\RegisterNotificationPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MKebzaNotificatorBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container
            ->registerForAutoconfiguration(NotificationInterface::class)
            ->addTag('mkebza_notificator.notification');

        $container->addCompilerPass(new RegisterNotificationPass());
    }
}
