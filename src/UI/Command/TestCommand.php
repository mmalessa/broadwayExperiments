<?php

namespace App\UI\Command;

use App\Domain\Budget\Budget;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    protected static $defaultName = 'app:test';

    protected function configure()
    {
        $this
            ->setDescription('Test command')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $budget = Budget::create('ABCD');
        $budget->addAmount(10);
        $budget->substractAmount(1);
        $budget->addAmount(100);
        $budget->addAmount(123);
        $budget->substractAmount(12);
        dump($budget);

        
    }
}
