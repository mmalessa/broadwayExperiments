<?php

declare(strict_types=1);

namespace App\ReadModel\BudgetBalance;

use Assert\Assertion;
use Broadway\ReadModel\Identifiable;
use Broadway\ReadModel\Repository;
use Doctrine\DBAL\Connection;

class BudgetBalanceMySQLRepository implements Repository
{
    private $connection;
    private $tableName;

    public function __construct(Connection $connection, string $tableName)
    {
        $this->connection = $connection;
        $this->tableName = $tableName;
    }

    public function save(Identifiable $data): void
    {
        Assertion::isInstanceOf($data, BudgetBalance::class);
        /** @var BudgetBalance $data */
        $existingBudget = $this->connection->fetchAssoc(
            "SELECT `budgetId` FROM {$this->tableName} WHERE budgetId = ?", [$data->getId()]
        );
        if ($existingBudget) {
            $this->connection->update(
                $this->tableName,
                [
                    'amount' => $data->getAmount(),
                ],
                [
                    'budgetId' => $data->getId(),
                ]
            );
        } else {
            $this->connection->insert(
                $this->tableName,
                [
                    'budgetId' => $data->getId(),
                    'amount' => $data->getAmount(),
                ]
            );
        }

    }

    public function remove($id): void
    {
        $this->connection->exec("DELETE FROM {$this->tableName} WHERE budgetId = ?", $id);
    }

    public function findBy(array $fields): array
    {
        return [];
    }

    public function findAll(): array
    {
        return [];
    }

    public function find($id): ?Identifiable
    {
        $existingBudget = $this->connection->fetchAssoc("SELECT * FROM {$this->tableName} WHERE budgetId = ?", [$id]);
        if ($existingBudget === []) {
            return null;
        }
        return BudgetBalance::deserialize($existingBudget);
    }
}
