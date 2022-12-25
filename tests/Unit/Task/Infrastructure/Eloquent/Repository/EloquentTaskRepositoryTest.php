<?php

namespace Tests\Unit\Task\Infrastructure\Eloquent\Repository;


use App\Models\Task as TaskModel;
use Mockery;
use Mockery\MockInterface;
use Src\Task\Domain\Task;
use Src\Task\Infrastructure\Eloquent\Repository\EloquentTaskRepository;
use Tests\TestCase;

class EloquentTaskRepositoryTest extends TestCase
{
    private MockInterface $taskModel;
    private EloquentTaskRepository $repository;

    public function setUp(): void
    {
        $this->taskModel = Mockery::mock(TaskModel::class);
        $this->repository = new EloquentTaskRepository($this->taskModel);
    }

    public function testFindMethod()
    {
        $task1 = Task::fromPrimitives([
            'id' => '6403a11a-edb0-4365-9ce0-76e6469adb93',
            'name' => 'do the laundry',
            'status' => 1,
        ]);
        $task2 = Task::fromPrimitives([
            'id' => 'a478c00e-5bbb-436c-a8c0-4a0e1ad1631f',
            'name' => 'do the laundry again',
            'status' => 2,
        ]);
        $tasks = [$task1, $task2];

        $taskModel1 = new TaskModel;
        $taskModel1->id = (string) $task1->id;
        $taskModel1->name = (string) $task1->name;
        $taskModel1->status = $task1->status->value;
        $taskModel2 = new TaskModel;
        $taskModel2->id = (string) $task2->id;
        $taskModel2->name = (string) $task2->name;
        $taskModel2->status = $task2->status->value;

        $this->taskModel->shouldReceive('newQuery')
            ->once()
            ->andReturnSelf();
        $this->taskModel->shouldReceive('get')
            ->once()
            ->andReturn(collect([$taskModel1, $taskModel2]));

        $result = $this->repository->find([]);
        $this->assertEquals($tasks, $result);
    }

    public function testSaveMethod()
    {
        $task = Task::fromPrimitives([
            'id' => 'a478c00e-5bbb-436c-a8c0-4a0e1ad1631f',
            'name' => 'do the laundry again',
            'status' => 2,
        ]);

        $this->taskModel->shouldReceive('updateOrCreate')
            ->once()
            ->withArgs([
                [ 'id' => (string)$task->id ],
                [
                    'name' => (string)$task->name,
                    'status' => $task->status->value,
                ],
            ]);

        $this->repository->save($task);
    }
}
