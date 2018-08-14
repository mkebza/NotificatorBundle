<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Notificator\Service;

use MKebza\Notificator\NotifiableInterface;

interface TargetNormalizerInterface
{
    /**
     * @param $targets
     *
     * @return NotifiableInterface[]
     */
    public function normalize($targets): array;
}
