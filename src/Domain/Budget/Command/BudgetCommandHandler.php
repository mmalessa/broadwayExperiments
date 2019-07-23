<?php
namespace App\Domain\Budget\Command;

use App\Domain\Budget\Budget;
use Broadway\CommandHandling\SimpleCommandHandler;

class BudgetCommandHandler extends SimpleCommandHandler
{
    private $repository;

    public function __construct($budgetSnapshotRepository)
    {
        $this->repository = $budgetSnapshotRepository;
    }

    public function handleCreateBudget(CreateBudget $command)
    {
        $budget = Budget::create($command->getBudgetId());
        $this->repository->save($budget);
    }

    public function handleAddAmountToBudget(AddAmountToBudget $command)
    {
        $budget = $this->repository->load($command->getBudgetId());
        $budget->addAmount($command->getAmount());
        $this->repository->save($budget);
    }

    public function handleSubstractAmountFromBudget(SubstractAmountFromBudget $command)
    {
        $budget = $this->repository->load($command->getBudgetId());
        $budget->substractAmount($command->getAmount());
        $this->repository->save($budget);
    }
}
