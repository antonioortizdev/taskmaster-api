<?php

namespace Src\Task\Infrastructure\Eloquent\Repository;
use Src\Task\Domain\Repository\TaskRepository;
use Src\Task\Domain\Task;
use App\Models\Task as TaskModel;

class EloquentTaskRepository implements TaskRepository
{
    public function __construct(private TaskModel $taskModel) {}

    public function save(Task $task): void
    {
        $this->taskModel->create(
            [
                'id' => (string)$task->id,
                'name' => (string)$task->name,
            ]
        );
    }
}
