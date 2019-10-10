<?php

declare(strict_types=1);

namespace App\Application\Socking\Event;

use Broadway\Serializer\Serializable;

class SockingStarted implements Serializable
{
    public function serialize(): array
    {
        return [];
    }

    public static function deserialize(array $data)
    {
        return new self();
    }
}
