<?php

namespace Src\Task\Application\UseCase;

use Src\Task\Domain\Exception\TaskNotFoundException;
use Src\Task\Domain\Repository\TaskRepository;
use Src\Task\Domain\Task;
use Src\Task\Domain\ValueObject\TaskId;

class FindTaskById
{
    public function __construct(private TaskRepository $repository) {}

    public function __invoke(string $id): Task
    {
        $tasksFound = $this->repository->find([ 'id' => $id ]);

        if (empty($tasksFound))
            throw new TaskNotFoundException(new TaskId($id));

        return $tasksFound[0];
    }
}
