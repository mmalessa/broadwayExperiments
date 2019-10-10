<?php

declare(strict_types=1);

namespace App\UI\Command\Socking;

use App\Application\Socking\Event\SockingStarted;
use Broadway\CommandHandling\CommandBus;
use Broadway\EventDispatcher\EventDispatcher;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SockingTest extends Command
{
    protected static $defaultName = 'socking:test';
    private $commandBus, $eventDispatcher;

    public function __construct(CommandBus $commandBus, EventDispatcher $eventDispatcher)
    {
        $this->commandBus = $commandBus;
        $this->eventDispatcher = $eventDispatcher;
        parent::__construct(null);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Socking Test");
//        $this->eventDispatcher->dispatch('socking', (new SockingStarted())->serialize());
    }

}
