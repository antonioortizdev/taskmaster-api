<?php

namespace Src\Task\Application\UseCase;

use Src\Task\Domain\Repository\TaskRepository;
use Src\Task\Domain\Task;

class CreateTask
{
    public function __construct(private TaskRepository $repository) {}

    public function __invoke(array $taskData): void
    {
        $task = Task::fromPrimitives($taskData);
        $this->repository->save($task);
    }
}
