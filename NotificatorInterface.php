<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Notificator;

interface NotificatorInterface
{
    /**
     * Sends notification.
     *
     * @param $targets single object or array of NotifiableInterface
     * @param string $notification Notifications class name
     * @param array  $options      options for notification
     */
    public function send($targets, string $notification, array $options = []): void;
}
