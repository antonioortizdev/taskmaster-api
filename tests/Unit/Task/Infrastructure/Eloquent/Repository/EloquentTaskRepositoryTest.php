<?php

namespace Tests\Unit\Task\Infrastructure\Eloquent\Repository;


use App\Models\Task as TaskModel;
use Mockery;
use Src\Task\Domain\Task;
use Src\Task\Domain\ValueObject\TaskId;
use Src\Task\Domain\ValueObject\TaskName;
use Src\Task\Infrastructure\Eloquent\Repository\EloquentTaskRepository;
use Tests\TestCase;

class EloquentTaskRepositoryTest extends TestCase
{
    private $taskModelMock;
    public function setUp(): void
    {
        $this->taskModelMock = Mockery::mock(TaskModel::class);
    }

    public function testSaveMethod()
    {
        $task = new Task(
            new TaskId('5f0e14ae-8afd-4151-9ef0-34791190f77c'),
            new TaskName('do the laundry please'),
        );
        $this->taskModelMock->shouldReceive('updateOrCreate')
            ->once()
            ->withArgs([
                [
                    'id' => (string)$task->id,
                ],
                [
                    'name' => (string)$task->name,
                    'status' => $task->status->value,
                ],
            ]);

        $repository = new EloquentTaskRepository($this->taskModelMock);
        $repository->save($task);
    }
}
