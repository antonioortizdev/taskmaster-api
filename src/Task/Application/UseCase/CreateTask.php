<?php

namespace Src\Task\Application\UseCase;

use Src\Task\Domain\Exception\TaskAlreadyExistsException;
use Src\Task\Domain\Repository\TaskRepository;
use Src\Task\Domain\Task;

class CreateTask
{
    public function __construct(private TaskRepository $repository) {}

    public function __invoke(array $taskData): void
    {
        $task = Task::fromPrimitives($taskData);
        $this->ensureTaskDoesNotExist($task);
        $this->repository->save($task);
    }

    private function ensureTaskDoesNotExist(Task $task): void
    {
        $foundTasks = $this->repository->find([ 'id' => (string) $task->id ]);
        if (!empty($foundTasks))
            throw new TaskAlreadyExistsException($task->id);
    }
}
