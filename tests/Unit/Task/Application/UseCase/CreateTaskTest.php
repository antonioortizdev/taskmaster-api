<?php

namespace Tests\Unit\Task\Application\UseCase;

use Mockery;
use Src\Task\Application\UseCase\CreateTask;
use Src\Task\Domain\Exception\TaskAlreadyExistsException;
use Src\Task\Domain\Repository\TaskRepository;
use Src\Task\Domain\Task;
use Tests\TestCase;

class CreateTaskTest extends TestCase
{
    public function testCreateTask()
    {
        $taskData = [
            'id' => '5f0e14ae-8afd-4151-9ef0-34791190f77c',
            'name' => 'do the laundry please',
        ];

        $task = Task::fromPrimitives($taskData);

        $repositoryMock = Mockery::mock(TaskRepository::class);
        $repositoryMock->shouldReceive('find')
            ->withArgs([['id' => '5f0e14ae-8afd-4151-9ef0-34791190f77c']])
            ->andReturn([]);
        $repositoryMock->shouldReceive('save')
            ->withArgs([$task])
            ->once();

        $useCase = new CreateTask($repositoryMock);
        $useCase($taskData);
    }

    public function testCreateTaskAlreadyExists()
    {
        $taskData = [
            'id' => '5f0e14ae-8afd-4151-9ef0-34791190f77c',
            'name' => 'do the laundry please',
        ];

        $task = Task::fromPrimitives($taskData);

        $repositoryMock = Mockery::mock(TaskRepository::class);
        $repositoryMock->shouldReceive('find')
            ->withArgs([['id' => '5f0e14ae-8afd-4151-9ef0-34791190f77c']])
            ->andReturn([$task]);
        $repositoryMock->shouldNotReceive('save');

        $useCase = new CreateTask($repositoryMock);
        $this->expectException(TaskAlreadyExistsException::class);
        $useCase($taskData);
    }
}
