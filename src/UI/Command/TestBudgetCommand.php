<?php

namespace App\UI\Command;

use App\Domain\Budget\BudgetRepository;
use App\Domain\Budget\Command\AddAmountToBudget;
use App\Domain\Budget\Command\CreateBudget;
use App\Domain\Budget\Command\SubstractAmountFromBudget;
use Broadway\CommandHandling\CommandBus;
use Broadway\ReadModel\Repository;
use Broadway\UuidGenerator\Rfc4122\Version4Generator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TestBudgetCommand extends Command
{
    protected static $defaultName = 'app:test:budget';
    private $commandBus;
    private $budgetRepository;
    private $readmodelRepositoryBudgetBalance;

    public function __construct(
        CommandBus $commandBus,
        BudgetRepository $budgetRepository,
        Repository $readmodelRepositoryBudgetBalance
    ) {
        $this->commandBus = $commandBus;
        $this->budgetRepository = $budgetRepository;
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

        $this->commandBus->dispatch(new CreateBudget($budgetId));
        $this->commandBus->dispatch(new AddAmountToBudget($budgetId, 1000));
        $this->commandBus->dispatch(new SubstractAmountFromBudget($budgetId, 20));
        $this->commandBus->dispatch(new AddAmountToBudget($budgetId, 1000));
        $this->commandBus->dispatch(new SubstractAmountFromBudget($budgetId, 80));

        dump($this->budgetRepository->load($budgetId));
//        dump($this->readmodelRepositoryBudgetBalance);
    }
}
