<?php

namespace App\Domain\Event\Budget;

use App\Domain\Event\AggregateChanged;

class BudgetWasCreated extends AggregateChanged
{
    private $budgetId;
    private $balance;

    private function __construct()
    {
    }

    public static function create(string $budgetId, int $balance)
    {
        $self = new self();
        $self->budgetId = $budgetId;
        $self->balance = $balance;
        return $self;
    }

    public function getBudgetId()
    {
        return $this->budgetId;
    }

    public function getBalance()
    {
        return $this->balance;
    }

}
