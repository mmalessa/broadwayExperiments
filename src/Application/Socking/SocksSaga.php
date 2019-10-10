<?php

declare(strict_types=1);

namespace App\Application\Socking;

use App\Application\Socking\Command\PutOnSock;
use App\Application\Socking\Event\LeftSockWasFound;
use App\Application\Socking\Event\RightSockWasFound;
use App\Application\Socking\Event\SockingStarted;
use Broadway\CommandHandling\CommandBus;
use Broadway\Saga\Metadata\StaticallyConfiguredSagaInterface;
use Broadway\Saga\Saga;
use Broadway\Saga\State;
use Broadway\Saga\State\Criteria;
use Broadway\UuidGenerator\UuidGeneratorInterface;

class SocksSaga extends Saga implements StaticallyConfiguredSagaInterface
{
    private $commandBus;
    private $uuidGenerator;
    public function __construct(
        CommandBus $commandBus,
        UuidGeneratorInterface $uuidGenerator
    ) {
        $this->commandBus    = $commandBus;
        $this->uuidGenerator = $uuidGenerator;
    }

    public static function configuration()
    {
        echo "SocksSaga configuration\n";
        return [
            'SockingStarted' => function (SockingStarted $event) {
                return null;
            },
            'LeftSockWasFound' => function (LeftSockWasFound $event) {
                return new Criteria([
                    'sockingId' => $event->getSockingId()
                ]);
            },
            'RightSockWasFound' => function (RightSockWasFound $event) {
                return new Criteria([
                    'sockingId' => $event->getSockingId()
                ]);
            }
        ];
    }

    public function handleSockingStarted(SockingStarted $event, State $state)
    {
        echo "handleSockingStarted\n";
        $state->set('sockingId', $this->uuidGenerator->generate());
        $state->set('leftSockWasFound', false);
        $state->set('rightSockWasFound', false);
        return $state;
    }

    public function handleLeftSockWasFound(LeftSockWasFound $event, State $state)
    {
        echo "handleLeftSockWasFound\n";
        $state->set('leftSockWasFound', true);
        if ($state->get('rightSockWasFound')) {
            $state->setDone();
            $this->commandBus->dispatch(new PutOnSock($event->getSockingId()));
        }
        return $state;
    }

    public function handleRightSockWasFound(RightSockWasFound $event, State $state)
    {
        echo "handleRightSockWasFound\n";
        $state->set('rightSockWasFound', true);
        if ($state->get('leftSockWasFound')) {
            $state->setDone();
            $this->commandBus->dispatch(new PutOnSock($event->getSockingId()));
        }
        return $state;
    }
}
