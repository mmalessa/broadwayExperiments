<?php

namespace App\Domain\Budget\Command;

class CreateBudget
{
    private $budgetId;

    public function __construct(string $budgetId)
    {
        $this->budgetId = $budgetId;
    }

    public function getBudgetId(): string
    {
        return $this->budgetId;
    }
}
