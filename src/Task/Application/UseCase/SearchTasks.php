<?php

namespace Src\Task\Application\UseCase;

use Src\Task\Domain\Repository\TaskRepository;
use Src\Task\Domain\Task;
use InvalidArgumentException;

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
        $this->ensureFiltersAreValid(array_keys($filters));
        $foundTasks = $this->repository->find($filters);
        return array_map(fn(Task $task) => $task->toPrimitives(), $foundTasks);
    }

    /**
     * Ensures that filters are valid.
     *
     * @param string[] $filters
     */
    private function ensureFiltersAreValid(array $filters): void
    {
        $validFilters = Task::SEARCHABLE_FIELDS;
        foreach ($filters as $filter) {
            if (!in_array($filter, $validFilters)) {
                throw new InvalidArgumentException("Field '$filter' is not a valid field.");
            }
        }
    }
}
