<?php

namespace App\ReadModel;

use App\Domain\Budget\Event\AmountWasAddedToBudget;
use App\Domain\Budget\Event\AmountWasSubstractedFromBudget;
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

    protected function applyAmountWasSubstractedFromBudget(AmountWasSubstractedFromBudget $event)
    {
        $readModel = $this->getReadModel($event->getBudgetId());
        $readModel->substractFromBudget($event->getAmount());
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
