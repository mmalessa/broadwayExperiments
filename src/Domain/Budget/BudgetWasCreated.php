<?php

namespace App\Domain\Budget;

use Broadway\Serializer\Serializable;

class BudgetWasCreated implements Serializable
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

    public function serialize(): array
    {
        return [
            'budgetId' => $this->budgetId,
        ];
    }

    public static function deserialize(array $data)
    {
        return new self($data['budgetId']);
    }
}
