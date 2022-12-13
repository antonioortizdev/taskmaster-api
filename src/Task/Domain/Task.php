<?php

namespace Src\Task\Domain;
use Src\Shared\Domain\Entity;
use Src\Task\Domain\ValueObject\TaskId;
use Src\Task\Domain\ValueObject\TaskName;

final class Task extends Entity {
    public function __construct(
        TaskId $id,
        public TaskName $name,
    ) {
        parent::__construct($id);
    }

    public function toPrimitives(): array
    {
        return [
            'id' => (string) $this->id,
            'name' => (string) $this->name,
        ];
    }

    public static function fromPrimitives(array $primitives): static
    {
        return new Task(
            new TaskId($primitives['id']),
            new TaskName($primitives['name']),
        );
    }
}
