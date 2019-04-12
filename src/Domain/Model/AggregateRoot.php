<?php

namespace App\Domain\Model;

use App\Domain\Event\AggregateChanged;

abstract class AggregateRoot
{
    use EventSourcedTrait;
    use EventProducerTrait;

//    private $events = [];

    protected function __construct()
    {
    }

    protected function apply(AggregateChanged $event): void
    {
        $handler = $this->determineEventHandlerMethodFor($event);
        if (! \method_exists($this, $handler)) {
            throw new \RuntimeException(\sprintf(
                'Missing event handler method %s for aggregate root %s',
                $handler,
                \get_class($this)
            ));
        }

        $this->{$handler}($event);
    }

    protected function determineEventHandlerMethodFor(AggregateChanged $event): string
    {
        return 'when' . \implode(\array_slice(\explode('\\', \get_class($event)), -1));
    }
}
