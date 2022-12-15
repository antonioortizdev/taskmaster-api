<?php

namespace Tests\Unit\Task\Application\UseCase;

use Mockery;
use Src\Task\Application\UseCase\CreateTask;
use Src\Task\Domain\Repository\TaskRepository;
use Src\Task\Domain\Task;
use Tests\TestCase;

class CreateTaskTest extends TestCase
{
    private $repositoryMock, $createTaskUseCase;

    public function setUp(): void
    {
        $this->repositoryMock = Mockery::mock(TaskRepository::class);
        $this->createTaskUseCase = new CreateTask($this->repositoryMock);
    }

    public function testInvokeSavesTask()
    {
        $newData = [
            'id' => 'b1f78b1e-620e-4adb-b752-94d24f76abc0',
            'name' => 'do the laundry',
        ];
        $task = Task::fromPrimitives($newData);

        $this->repositoryMock->shouldReceive('save')
            ->once()
            ->withArgs([$task])
            ->andReturn();

        ($this->createTaskUseCase)($newData);
    }
}
