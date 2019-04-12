<?php

namespace App\Domain\Event\Budget;

use App\Domain\Event\AggregateChanged;

class MoneyPaidIn extends AggregateChanged
{
    private $budgetId;
    private $amount;

    private function __construct()
    {
    }

    public static function create(string $budgetId, int $amount)
    {
        $self = new self();
        $self->budgetId = $budgetId;
        $self->amount = $amount;
        return $self;
    }

    public function getBudgetId()
    {
        return $this->budgetId;
    }

    public function getAmount()
    {
        return $this->amount;
    }
}
