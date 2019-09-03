<?php

namespace App\ReadModel\BudgetBalance;

use App\Domain\Budget\Event\AmountWasAddedToBudget;
use App\Domain\Budget\Event\AmountWasSubtractedFromBudget;
use App\Domain\Budget\Event\BudgetWasCreated;
use Assert\Assertion;
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
        $readModel = new BudgetBalance($event->getBudgetId());
        $readModel->initBudget();
        $this->readModelRepository->save($readModel);
    }

    protected function applyAmountWasAddedToBudget(AmountWasAddedToBudget $event)
    {
        $readModel = $this->readModelRepository->find($event->getBudgetId());
        Assertion::notNull($readModel);
        $readModel->addToBudget($event->getAmount());
        $this->readModelRepository->save($readModel);
    }

    protected function applyAmountWasSubtractedFromBudget(AmountWasSubtractedFromBudget $event)
    {
        $readModel = $this->readModelRepository->find($event->getBudgetId());
        Assertion::notNull($readModel);
        $readModel->subtractFromBudget($event->getAmount());
        $this->readModelRepository->save($readModel);
    }

}
