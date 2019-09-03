<?php

namespace App\ReadModel\BudgetBalance;

use App\Domain\Budget\Event\AmountWasAddedToBudget;
use App\Domain\Budget\Event\AmountWasSubtractedFromBudget;
use App\Domain\Budget\Event\BudgetWasCreated;
use Broadway\ReadModel\Projector;
use Broadway\ReadModel\Repository;

class BudgetBalanceProjector extends Projector
{
    private $readModelRepository;

    public function __construct(Repository $readModelRepository)
    {
        $this->readModelRepository = $readModelRepository;
    }

    protected function applyBudgetWasCreated(BudgetWasCreated $event)
    {
        $readModel = $this->getReadModel($event->getBudgetId());
        $readModel->initBudget();
        $this->readModelRepository->save($readModel);
    }

    protected function applyAmountWasAddedToBudget(AmountWasAddedToBudget $event)
    {
        $readModel = $this->getReadModel($event->getBudgetId());
        $readModel->addToBudget($event->getAmount());
        $this->readModelRepository->save($readModel);
    }

    protected function applyAmountWasSubtractedFromBudget(AmountWasSubtractedFromBudget $event)
    {
        $readModel = $this->getReadModel($event->getBudgetId());
        $readModel->subtractFromBudget($event->getAmount());
        $this->readModelRepository->save($readModel);
    }


    private function getReadModel(string $budgetId)
    {
        $readModel = $this->readModelRepository->find($budgetId);
        if (null === $readModel) {
            $readModel = new BudgetBalance($budgetId);
        }
        return $readModel;
    }
}
