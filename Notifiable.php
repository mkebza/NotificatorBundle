<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Notificator;

final class Notifiable implements NotifiableInterface
{
    /**
     * @var array
     */
    private $channels;

    /**
     * Notifiable constructor.
     *
     * @param array $channels
     */
    public function __construct(array $channels)
    {
        $this->channels = $channels;
    }

    /**
     * {@inheritdoc}
     */
    public function getNotificationChannels(): array
    {
        return $this->channels;
    }
}
