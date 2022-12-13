<?php

namespace Src\Shared\Domain;
use Src\Shared\Domain\ValueObject\Uuid;
use Src\Shared\Domain\Interfaces\HandlesPrimitives;

abstract class Entity implements HandlesPrimitives
{
    public function __construct(public Uuid $id) {}
}
