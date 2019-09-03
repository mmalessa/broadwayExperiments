<?php

namespace App\UI\Command\Budget;

use App\Domain\Budget\BudgetSnapshotRepository;
use App\Application\Budget\Command\AddAmountToBudget;
use App\Application\Budget\Command\CreateBudget;
use App\Application\Budget\Command\SubtractAmountFromBudget;
use Broadway\CommandHandling\CommandBus;
use Broadway\ReadModel\Repository;
use Broadway\UuidGenerator\Rfc4122\Version4Generator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestBudgetCommand extends Command
{
    protected static $defaultName = 'app:test:budget';
    private $commandBus;
    private $budgetSnapshotRepository;
    private $readmodelRepositoryBudgetBalance;

    public function __construct(
        CommandBus $commandBus,
        BudgetSnapshotRepository $budgetSnapshotRepository,
        Repository $readmodelRepositoryBudgetBalance
    ) {
        $this->commandBus = $commandBus;
        $this->budgetSnapshotRepository = $budgetSnapshotRepository;
        $this->readmodelRepositoryBudgetBalance = $readmodelRepositoryBudgetBalance;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Test command');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $budgetId = (new Version4Generator)->generate();
//        $budgetId = '0850becd-cc89-4053-85a9-bd5c7720b3b8';

        $this->commandBus->dispatch(new CreateBudget($budgetId));
        $this->commandBus->dispatch(new AddAmountToBudget($budgetId, 1.03));
        $this->commandBus->dispatch(new SubtractAmountFromBudget($budgetId, 20.12));
        $this->commandBus->dispatch(new AddAmountToBudget($budgetId, 1000.23));
        $this->commandBus->dispatch(new SubtractAmountFromBudget($budgetId, 80.11));
        $this->commandBus->dispatch(new SubtractAmountFromBudget($budgetId, 80.98));
        $this->commandBus->dispatch(new AddAmountToBudget($budgetId, 100.22));
        $this->commandBus->dispatch(new AddAmountToBudget($budgetId, 223.34));
        dump($this->budgetSnapshotRepository->load($budgetId));
//        dump($this->readmodelRepositoryBudgetBalance);
    }
}

