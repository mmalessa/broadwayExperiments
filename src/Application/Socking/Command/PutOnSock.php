<?php

declare(strict_types=1);

namespace App\Application\Socking\Command;

class PutOnSock
{
    private $sockingId;

    public function __construct(string $sockingId)
    {
        $this->sockingId = $sockingId;
    }

    public function getSockingId(): string
    {
        return $this->sockingId;
    }
}
