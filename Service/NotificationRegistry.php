<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Notificator\Service;

use MKebza\Notificator\Exception\NotificationNotFoundException;
use MKebza\Notificator\NotificationInterface;
use Symfony\Component\DependencyInjection\ServiceLocator;

class NotificationRegistry implements NotificationRegistryInterface
{
    /**
     * @var ServiceLocator
     */
    private $locator;

    /**
     * NotificationRepository constructor.
     *
     * @param ServiceLocator $locator
     */
    public function __construct(ServiceLocator $locator)
    {
        $this->locator = $locator;
    }

    public function get(string $name): NotificationInterface
    {
        if (!$this->locator->has($name)) {
            throw new NotificationNotFoundException(sprintf(
                'Notification %s not found. Did you forget to add tag mkebza_notificator.notification?', $name));
        }

        return $this->locator->get($name);
    }
}
