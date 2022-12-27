<?php

namespace Tests\Unit\Task\Domain\Exception;

use Src\Task\Domain\Exception\TaskAlreadyExistsException;
use Src\Task\Domain\ValueObject\TaskId;
use Tests\TestCase;

class TaskAlreadyExistsExceptionTest extends TestCase
{
    public function testConstructSetsMessageWithTaskId()
    {
        $this->expectExceptionMessage('Task with ID 13621702-7f86-4f8b-84f6-81267460a1d2 already exists.');
        throw new TaskAlreadyExistsException(
            new TaskId('13621702-7f86-4f8b-84f6-81267460a1d2'),
        );
    }
}
