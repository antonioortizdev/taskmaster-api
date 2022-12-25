<?php

namespace Src\Task\Domain\Repository;
use Src\Task\Domain\Task;

interface TaskRepository
{
    /**
     * Find tasks matching the filters.
     *
     * @param array $filters
     * @return Task[]
     */
    public function find(array $filters): array;

    public function save(Task $task): void;
}
