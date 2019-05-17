<?php

namespace App\Domain\Budget;

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

    public function addAmount(int $amount)
    {
        $this->apply(new AmountWasAddedToBudget($this->budgetId, $amount));
    }

    protected function applyAmountWasAddedToBudget(AmountWasAddedToBudget $event)
    {
        $this->amount += $event->getAmount();
    }

    public function substractAmount(int $amount)
    {
        $this->apply(new AmountWasSubstractedFromBudget($this->budgetId, $amount));
    }

    protected function applyAmountWasSubstractedFromBudget(AmountWasSubstractedFromBudget $event)
    {
        $this->amount -= $event->getAmount();
    }
}
