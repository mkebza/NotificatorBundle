<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Notificator\Scheduled;

use MKebza\Notificator\NotifiableInterface;

class ScheduledNotificationTarget
{
    /**
     * @var string
     */
    private $id;

    /** @var NotifiableInterface */
    private $target;
    /**
     * @var array
     */
    private $options;

    /**
     * ScheduledNotificationTarget constructor.
     *
     * @param string              $id
     * @param NotifiableInterface $target
     * @param array               $options
     */
    public function __construct(string $id, NotifiableInterface $target, array $options = [])
    {
        $this->id = $id;
        $this->target = $target;
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return NotifiableInterface
     */
    public function getTarget(): NotifiableInterface
    {
        return $this->target;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}
