<?php

namespace Src\Task\Domain\Exception;

use Exception;
use Src\Task\Domain\ValueObject\TaskId;

class TaskAlreadyExistsException extends Exception
{
    public function __construct(TaskId $id)
    {
        parent::__construct('Task with ID ' . $id . ' already exists');
    }
}
