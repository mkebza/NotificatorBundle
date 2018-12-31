<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Notificator\Scheduled\KeyRegistry;

use Doctrine\ORM\EntityManagerInterface;
use MKebza\Notificator\Entity\ScheduledNotificationSend;

class DoctrineScheduledKeyRegistry implements ScheduledKeyRegistryInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * DoctrineScheduledKeyRegistry constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function add(string $key): void
    {
        $record = new ScheduledNotificationSend($key);
        $this->em->persist($record);
        $this->em->flush();
    }

    public function has(string $key): bool
    {
        return null !== $this->em->getRepository(ScheduledNotificationSend::class)->findOneBy(['code' => $key]);
    }
}
