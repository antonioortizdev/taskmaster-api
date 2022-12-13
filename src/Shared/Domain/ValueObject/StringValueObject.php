<?php

namespace Src\Shared\Domain\ValueObject;

abstract readonly class StringValueObject {
    public function __construct(public string $value) {}

    public function __toString()
    {
        return $this->value;
    }
}
