<?php

namespace Src\Task\Domain;
use Src\Shared\Domain\Entity;
use Src\Task\Domain\Enum\TaskStatus;
use Src\Task\Domain\ValueObject\TaskId;
use Src\Task\Domain\ValueObject\TaskName;

final class Task extends Entity {
    public const SEARCHABLE_FILTERS = ['name', 'status'];

    public function __construct(
        TaskId $id,
        public TaskName $name,
        public TaskStatus $status = TaskStatus::PENDING,
    ) {
        parent::__construct($id);
    }

    public function toPrimitives(): array
    {
        return [
            'id' => (string) $this->id,
            'name' => (string) $this->name,
            'status' => $this->status->value,
        ];
    }

    public static function fromPrimitives(array $primitives): Task
    {
        $task = new Task(
            new TaskId($primitives['id']),
            new TaskName($primitives['name']),
        );

        if (isset($primitives['status'])) {
            $task->status = TaskStatus::tryFrom($primitives['status']);
        }

        return $task;
    }
}
