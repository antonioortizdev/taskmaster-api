<?php

namespace Tests\Unit\Shared\Domain\ValueObject;

use Src\Shared\Domain\ValueObject\Uuid;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid as RamseyUuid;

readonly class ConcreteUuid extends Uuid
{
    // ...
}

class UuidTest extends TestCase
{
    /** @test */
    public function it_should_create_a_uuid()
    {
        $uuid = new ConcreteUuid('6c0fb1de-1a8c-4600-9f28-c0b5ec3634e7');

        $this->assertEquals('6c0fb1de-1a8c-4600-9f28-c0b5ec3634e7', $uuid->value);
    }

    /** @test */
    public function it_should_convert_a_uuid_to_a_string()
    {
        $uuid = new ConcreteUuid('6c0fb1de-1a8c-4600-9f28-c0b5ec3634e7');

        $this->assertEquals('6c0fb1de-1a8c-4600-9f28-c0b5ec3634e7', (string) $uuid);
    }

    /** @test */
    public function it_should_throw_an_exception_when_creating_a_uuid_from_an_invalid_value()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('<Tests\Unit\Shared\Domain\ValueObject\ConcreteUuid> does not allow the value <foo>.');

        $mock = $this->createMock(RamseyUuid::class);
        $mock->method('isValid')
            ->willReturn(false);

        new ConcreteUuid('foo');
    }
}

