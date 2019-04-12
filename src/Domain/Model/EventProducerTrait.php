<?php
namespace App\Domain\Model;

use App\Domain\Event\AggregateChanged;

trait EventProducerTrait
{
    protected $version = 0;
    protected $recordedEvents = [];

    protected function popRecordedEvents(): array
    {
        $pendingEvents = $this->recordedEvents;
        $this->recordedEvents = [];
        return $pendingEvents;
    }

    protected function recordThat(AggregateChanged $event): void
    {
        $this->version += 1;
//        $this->recordedEvents[] = $event->withVersion($this->version);
        $this->recordedEvents[] = $event->setVersion($this->version);
        $this->apply($event);
    }

    abstract protected function aggregateId(): string;
    abstract protected function apply(AggregateChanged $event): void;
}
