<?php

namespace App\ReadModel;

use Broadway\ReadModel\SerializableReadModel;

class BudgetBalance implements SerializableReadModel
{
    private $budgetId;
    private $amount;


    public function __construct(string $budgetId)
    {
        $this->budgetId = $budgetId;
    }

    public function getId(): string
    {
        return $this->budgetId;
    }

    public function initBudget()
    {
        $this->amount = 0;
    }

    public function addToBudget(int $amount)
    {
        $this->amount += $amount;
    }

    public function substractFromBudget(int $amount)
    {
        $this->amount -= $amount;
    }

    public function serialize(): array
    {
        return [
            'budgetId' => $this->budgetId,
            'amount' => $this->amount
        ];
    }

    public static function deserialize(array $data)
    {
        $readmodel = new self($data['budgetId']);
        $readmodel->amount = $data['amount'];
        return $readmodel;
    }
}
