<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Notificator\Command;

use MKebza\Notificator\Event\ScheduledGroupBeginEvent;
use MKebza\Notificator\Event\ScheduledNotificationSentEvent;
use MKebza\Notificator\Event\ScheduledNotificationSkippedEvent;
use MKebza\Notificator\Event\ScheduledNotificationTargetBeginEvent;
use MKebza\Notificator\Scheduled\ScheduledNotificator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ProcessScheduledNotificationsComand extends Command
{
    /**
     * @var ScheduledNotificator
     */
    private $notificator;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @var SymfonyStyle
     */
    private $io;

    private $sentNotificationCount = 0;

    /**
     * ProcessScheduledNotificationsComand constructor.
     *
     * @param ScheduledNotificator $notificator
     */
    public function __construct(ScheduledNotificator $notificator, EventDispatcherInterface $dispatcher)
    {
        parent::__construct();

        $this->notificator = $notificator;
        $this->dispatcher = $dispatcher;
    }

    // Event handlers
    public function onGroupBegin(ScheduledGroupBeginEvent $event): void
    {
        $this->io->writeln(sprintf('<info>%s</info> - Processing:', get_class($event->getGroup())));
    }

    public function onTargetBegin(ScheduledNotificationTargetBeginEvent $event): void
    {
        $target = $event->getTarget()->getTarget();
        $this->io->writeln(sprintf(
            "\t<info>%s</info> - Processing",
            method_exists($target, '__toString')
                ? (string) $target
                : sprintf('%s:%s', get_class($target), $event->getTarget()->getId())
        ));
    }

    public function onNotificationSkipped(ScheduledNotificationSkippedEvent $event): void
    {
        $this->io->writeln(sprintf(
            "\t\tx %s - %s - Skipped",
            get_class($event->getNotification()),
            $event->getReason()
        ));
    }

    public function onNotificationSent(ScheduledNotificationSentEvent $event): void
    {
        $this->io->writeln(sprintf(
            "\t\t<fg=green;options=bold>✓ %s - Sent</>",
            get_class($event->getNotification())
        ));

        ++$this->sentNotificationCount;
    }

    protected function configure()
    {
        $this
            ->setName('notificator:send-scheduled')
            ->setDescription('Sends all notifications')
            ->addArgument('group', InputArgument::OPTIONAL, 'Which group to process', null);
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->io = new SymfonyStyle($input, $output);

        $this->dispatcher->addListener(ScheduledGroupBeginEvent::class, [$this, 'onGroupBegin']);
        $this->dispatcher->addListener(ScheduledNotificationTargetBeginEvent::class, [$this, 'onTargetBegin']);
        $this->dispatcher->addListener(ScheduledNotificationSkippedEvent::class, [$this, 'onNotificationSkipped']);
        $this->dispatcher->addListener(ScheduledNotificationSentEvent::class, [$this, 'onNotificationSent']);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io->title('Processing scheduled notifications');
        $this->notificator->process($input->getArgument('group'));

        $this->io->success(sprintf('Finished, total sent %s notifications', $this->sentNotificationCount));

        return 0;
    }
}
