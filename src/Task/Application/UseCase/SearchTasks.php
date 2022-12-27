<?php

namespace Src\Task\Application\UseCase;

use Src\Task\Domain\Repository\TaskRepository;

class SearchTasks
{
    public function __construct(
        private TaskRepository $repository,
    ) {}

    /**
     * Find tasks by filters.
     *
     * @param array $filters
     * @return Task[]
     */
    public function __invoke(array $filters): array
    {
        return $this->repository->find($filters);
    }
}
