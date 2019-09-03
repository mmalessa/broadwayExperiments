<?php

namespace App\Application\Budget\Command;

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
