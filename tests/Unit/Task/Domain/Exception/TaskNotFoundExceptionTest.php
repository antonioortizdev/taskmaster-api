<?php

namespace Tests\Unit\Task\Domain\Exception;

use Src\Task\Domain\ValueObject\TaskId;
use Src\Task\Domain\Exception\TaskNotFoundException;
use Tests\TestCase;

class TaskNotFoundExceptionTest extends TestCase
{
    public function testThrowExceptionPrintsMessageWithTaskId()
    {
        $id = new TaskId('3d852cec-62fd-4a39-b6cf-715db597d7c0');

        $this->expectExceptionMessage('Task with ID ' . $id . ' not found.');

        throw new TaskNotFoundException($id);
    }
}
