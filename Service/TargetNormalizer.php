<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Notificator\Service;

use MKebza\Notificator\Exception\InvalidTargetException;
use MKebza\Notificator\NotifiableInterface;

class TargetNormalizer implements TargetNormalizerInterface
{
    public function normalize($targets): array
    {
        if ($targets instanceof NotifiableInterface) {
            $targets = [$targets];
        }

        if (!is_array($targets)) {
            throw new InvalidTargetException(sprintf(
                'You need to provide object or array of object implementing %s interface', NotifiableInterface::class));
        }

        foreach ($targets as $target) {
            if (!$target instanceof NotifiableInterface) {
                throw new InvalidTargetException(sprintf(
                    'Object %s needs to implement %s', (is_object($target) ? get_class($target) : gettype($target)),
                    NotifiableInterface::class));
            }
        }

        return $targets;
    }
}
