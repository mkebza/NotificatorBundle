<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Notificator\Tests\Service;

use MKebza\Notificator\Exception\InvalidTargetException;
use MKebza\Notificator\Notifiable;
use MKebza\Notificator\NotifiableInterface;
use MKebza\Notificator\Service\TargetNormalizer;
use PHPUnit\Framework\TestCase;

class TargetNormalizerTest extends TestCase
{
    public function testNormalizeSingle()
    {
        $normalizer = new TargetNormalizer();

        $normalized = $normalizer->normalize(new Notifiable(['email' => 'foo@bar.com']));
        $this->assertContainsOnlyInstancesOf(NotifiableInterface::class, $normalized);
    }

    public function testNormalizeSingleInvalid()
    {
        $normalizer = new TargetNormalizer();

        $this->expectException(InvalidTargetException::class);
        $normalizer->normalize('invalid data');
    }

    public function testNormalize()
    {
        $normalizer = new TargetNormalizer();

        $normalized = $normalizer->normalize([
            new Notifiable(['email' => 'foo@bar.com']),
            new Notifiable(['email' => 'foo2@bar.com']),
        ]);

        $this->assertContainsOnlyInstancesOf(NotifiableInterface::class, $normalized);
    }

    public function testNormalizeInvalid()
    {
        $normalizer = new TargetNormalizer();

        $this->expectException(InvalidTargetException::class);
        $normalizer->normalize([
            new Notifiable(['email' => 'foo@bar.com']),
            'test',
        ]);
    }
}
