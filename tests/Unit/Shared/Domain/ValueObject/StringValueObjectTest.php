<?php

namespace Tests\Unit\Shared\Domain\ValueObject;

use Src\Shared\Domain\ValueObject\StringValueObject;
use PHPUnit\Framework\TestCase;

readonly class ConcreteStringValueObject extends StringValueObject
{
    // ...
}

class StringValueObjectTest extends TestCase
{
    public function test_it_should_create_a_string_value_object()
    {
        $valueObject = new ConcreteStringValueObject('this is a string');

        $this->assertEquals('this is a string', $valueObject->value);
    }

    public function test_it_should_convert_a_string_value_object_to_a_string() // duh...
    {
        $valueObject = new ConcreteStringValueObject('this is another string');

        $this->assertEquals('this is another string', (string) $valueObject);
    }
}
