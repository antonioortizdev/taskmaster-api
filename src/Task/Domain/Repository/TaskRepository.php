<?php

namespace Src\Task\Domain\Repository;
use Src\Task\Domain\Task;

interface TaskRepository
{
    public function save(Task $task): void;
}
