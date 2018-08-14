<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Notificator;

final class Notification
{
    /**
     * @var null|mixed
     */
    private $content;

    /**
     * @var mixed
     */
    private $target;

    /**
     * @var string
     */
    private $channel;

    /**
     * Notification constructor.
     *
     * @param array  $target
     * @param string $channel
     */
    public function __construct($target, string $channel)
    {
        $this->target = $target;
        $this->channel = $channel;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     *
     * @return Notification
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @return string
     */
    public function getChannel(): string
    {
        return $this->channel;
    }
}
