<?php

namespace Src\Task\Application\UseCase;
use Src\Task\Domain\Repository\TaskRepository;
use Src\Task\Domain\Task;

final class CreateTask
{
    public function __construct(private TaskRepository $repository) {}

    public function __invoke(Task $newTask): void
    {
        $this->repository->save($newTask);
    }
}
