<?php

namespace App\Domain\Budget\Command;

class AddAmountToBudget
{
    private $budgetId;
    private $amount;

    public function __construct(string $budgetId, float $amount)
    {
        $this->budgetId = $budgetId;
        $this->amount = $amount;
    }

    public function getBudgetId(): string
    {
        return $this->budgetId;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

}
