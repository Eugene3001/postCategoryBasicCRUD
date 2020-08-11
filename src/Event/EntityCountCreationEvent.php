<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class EntityCountCreationEvent extends Event implements EntityCounterInterface
{
    private $className;

    public function __construct(string $className)
    {
        $this->className = $className;
    }

    public function getClassName(): string
    {
        return $this->className;
    }
}