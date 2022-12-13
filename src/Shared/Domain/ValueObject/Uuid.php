<?php

namespace Src\Shared\Domain\ValueObject;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid as RamseyUuid;

abstract readonly class Uuid {
    public function __construct(public string $value)
    {
        $this->ensureIsValidUuid($value);
    }

    public function __toString(): string
    {
        return $this->value;
    }

    private function ensureIsValidUuid(string $id)
    {
        if (!RamseyUuid::isValid($id)) {
            throw new InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', static::class, $id));
        }
    }
}
