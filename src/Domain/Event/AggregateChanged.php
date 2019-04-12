<?php
namespace App\Domain\Event;

abstract class AggregateChanged
{
    protected $version;

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version): AggregateChanged
    {
        $this->version = $version;
        return $this;
    }

}
