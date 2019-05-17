<?php

namespace App\UI\Command;

use App\Domain\Constant\BudgetTestId;
use App\Domain\Model\Budget\Budget;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TestCommand extends Command
{
    protected static $defaultName = 'app:test';

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
//        $budget = Budget::create(BudgetTestId::get());
//        $budget->addAmount(10);
//        $budget->subAmount(1);
//        $budget->addAmount(100);
//        $budget->addAmount(123);
//        $budget->subAmount(12);
//
//        dump($budget);
    }
}
