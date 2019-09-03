<?php

namespace App\Domain\Budget\Event;

use Broadway\Serializer\Serializable;

class AmountWasSubtractedFromBudget implements Serializable
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

    public function serialize(): array
    {
        return [
            'budgetId' => $this->budgetId,
            'amount' => $this->amount,
        ];
    }

    public static function deserialize(array $data)
    {
        return new self($data['budgetId'], $data['amount']);
    }
}
