<?php

namespace Src\Task\Infrastructure\Eloquent\Repository;
use Src\Task\Domain\Enum\TaskStatus;
use Src\Task\Domain\Repository\TaskRepository;
use Src\Task\Domain\Task;
use App\Models\Task as TaskModel;
use Src\Task\Domain\ValueObject\TaskId;
use Src\Task\Domain\ValueObject\TaskName;

class EloquentTaskRepository implements TaskRepository
{
    public function __construct(private TaskModel $taskModel) {}

    /**
     * Find tasks matching the filters.
     *
     * @param array $filters
     * @return Task[]
     */
    public function find(array $filters): array
    {
        $validFields = ['id', 'name', 'status'];
        $filters = array_intersect_key($filters, array_flip($validFields));
        $query = $this->taskModel->newQuery();

        foreach ($filters as $field => $value) {
            if ($field === 'name') {
                $query->where('name', 'like', '%' . $value . '%');
                continue;
            }
            $query->where($field, $value);
        }

        $tasks = $query->get();
        return $tasks->map(function ($task) {
            return Task::fromPrimitives([
                'id' => $task->id,
                'name' => $task->name,
                'status' => $task->status
            ]);
        })->all();
    }

    public function save(Task $task): void
    {
        $this->taskModel->updateOrCreate(
            [ 'id' => (string)$task->id ],
            [
                'name' => (string)$task->name,
                'status' => $task->status->value,
            ]
        );
    }
}
