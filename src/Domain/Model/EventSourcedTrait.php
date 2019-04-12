<?php
namespace App\Domain\Model;

use App\Domain\Event\AggregateChanged;
use Iterator;

trait EventSourcedTrait
{
    protected $version = 0;

    protected static function reconstituteFromHistory(Iterator $historyEvents): self
    {
        $instance = new static();
        $instance->replay($historyEvents);
        return $instance;
    }

    protected function replay(Iterator $historyEvents): void
    {
        foreach ($historyEvents as $pastEvent) {
            $this->version = $pastEvent->version();
            $this->apply($pastEvent);
        }
    }

    abstract protected function aggregateId(): string;
    abstract protected function apply(AggregateChanged $event): void;
}