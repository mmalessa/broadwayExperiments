<?php

namespace App\Domain\Budget;

use Broadway\Serializer\Serializable;

class AmountWasSubstractedFromBudget implements Serializable
{
    private $budgetId;
    private $amount;

    public function __construct(string $budgetId, int $amount)
    {
        $this->budgetId = $budgetId;
        $this->amount = $amount;
    }

    public function getBudgetId(): string
    {
        return $this->budgetId;
    }

    public function getAmount(): int
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
