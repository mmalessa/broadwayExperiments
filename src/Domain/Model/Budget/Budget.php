<?php
namespace App\Domain\Model\Budget;

use App\Domain\Event\Budget\BudgetWasCreated;
use App\Domain\Event\Budget\MoneyPaidIn;
use App\Domain\Event\Budget\MoneyPaidOut;
use App\Domain\Model\AggregateRoot;

class Budget extends AggregateRoot
{
    private $budgetId;
    private $balance;

    public static function create(string $id, int $initBalance = 0)
    {
        $self = new self();
        $self->recordThat(BudgetWasCreated::create($id, $initBalance));
        return $self;
    }

    protected function aggregateId(): string
    {
        return $this->budgetId;
    }

    public function addAmount(int $amount)
    {
        $this->recordThat(MoneyPaidIn::create($this->budgetId, $amount));
    }

    public function subAmount(int $amount)
    {
        $this->recordThat(MoneyPaidOut::create($this->budgetId, $amount));
    }


    protected function whenBudgetWasCreated(BudgetWasCreated $event)
    {
        $this->budgetId = $event->getBudgetId();
        $this->balance = $event->getBalance();
    }

    protected function whenMoneyPaidIn(MoneyPaidIn $event)
    {
        $this->balance += $event->getAmount();
    }

    protected function whenMoneyPaidOut(MoneyPaidOut $event)
    {
        $this->balance -= $event->getAmount();
    }
}
