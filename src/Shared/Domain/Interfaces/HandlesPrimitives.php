<?php

namespace Src\Shared\Domain\Interfaces;

interface HandlesPrimitives
{
    public function toPrimitives(): array;
    public static function fromPrimitives(array $primitives): static;
}
