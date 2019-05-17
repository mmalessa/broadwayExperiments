<?php

namespace App\UI\Command;

use App\Domain\Budget\BudgetRepository;
use App\Domain\Budget\Command\AddAmountToBudget;
use App\Domain\Budget\Command\CreateBudget;
use App\Domain\Budget\Command\SubstractAmountFromBudget;
use Broadway\CommandHandling\CommandBus;
use Broadway\UuidGenerator\Rfc4122\Version4Generator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    protected static $defaultName = 'app:test';
    private $commandBus;
    private $budgetRepository;

    public function __construct(
        CommandBus $commandBus,
        BudgetRepository $budgetRepository
    ) {
        $this->commandBus = $commandBus;
        $this->budgetRepository = $budgetRepository;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Test command');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $budgetId = (new Version4Generator)->generate();
        $this->commandBus->dispatch(new CreateBudget($budgetId));
        $this->commandBus->dispatch(new AddAmountToBudget($budgetId, 1000));
        $this->commandBus->dispatch(new SubstractAmountFromBudget($budgetId, 5));

        dump($this->budgetRepository->load($budgetId));
    }
}
