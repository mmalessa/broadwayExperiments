<?php

namespace App\Domain\Budget;

use App\Domain\Budget\Event\AmountWasAddedToBudget;
use App\Domain\Budget\Event\AmountWasSubtractedFromBudget;
use App\Domain\Budget\Event\BudgetWasCreated;
use Broadway\EventSourcing\EventSourcedAggregateRoot;

class Budget extends EventSourcedAggregateRoot
{
    private $budgetId;
    private $amount;

    public function getAggregateRootId(): string
    {
        return $this->budgetId;
    }

    public static function create(string $budgetId)
    {
        $budget = new self();
        $budget->apply(new BudgetWasCreated($budgetId));
        return $budget;
    }

    protected function applyBudgetWasCreated(BudgetWasCreated $event)
    {
        $this->budgetId = $event->getBudgetId();
        $this->amount = 0;
    }

    public function addAmount(float $amount)
    {
        $this->apply(new AmountWasAddedToBudget($this->budgetId, $amount));
    }

    protected function applyAmountWasAddedToBudget(AmountWasAddedToBudget $event)
    {
        $this->amount += $event->getAmount();
    }

    public function subtractAmount(float $amount)
    {
        $this->apply(new AmountWasSubtractedFromBudget($this->budgetId, $amount));
    }

    protected function applyAmountWasSubtractedFromBudget(AmountWasSubtractedFromBudget $event)
    {
        $this->amount -= $event->getAmount();
    }


}
