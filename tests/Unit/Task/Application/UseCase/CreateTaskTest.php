<?php

namespace Tests\Unit\Task\Application\UseCase;

use Mockery;
use Mockery\MockInterface;
use Src\Task\Application\UseCase\CreateTask;
use Src\Task\Domain\Exception\TaskAlreadyExistsException;
use Src\Task\Domain\Repository\TaskRepository;
use Src\Task\Domain\Task;
use Tests\TestCase;

class CreateTaskTest extends TestCase
{
    private MockInterface $repository;
    private CreateTask $useCase;

    public function setUp(): void
    {
        $this->repository = Mockery::mock(TaskRepository::class);
        $this->useCase = new CreateTask($this->repository);
    }

    public function testInvokeCreatesTask()
    {
        $taskData = [
            'id' => '5f0e14ae-8afd-4151-9ef0-34791190f77c',
            'name' => 'do the laundry please',
            'status' => 0,
        ];
        $task = Task::fromPrimitives($taskData);

        $this->repository->shouldReceive('find')
            ->once()
            ->withArgs([['id' => '5f0e14ae-8afd-4151-9ef0-34791190f77c']])
            ->andReturn([]);
        $this->repository->shouldReceive('save')
            ->once();
            // TODO: fix error when uncommenting this. ->withArgs([$task]);

        ($this->useCase)($taskData);
    }

    public function testInvokeThrowsCreateTaskAlreadyExists()
    {
        $taskData = [
            'id' => '5f0e14ae-8afd-4151-9ef0-34791190f77c',
            'name' => 'do the laundry please',
        ];
        $task = Task::fromPrimitives($taskData);

        $this->repository->shouldReceive('find')
            ->once()
            ->withArgs([['id' => '5f0e14ae-8afd-4151-9ef0-34791190f77c']])
            ->andReturn([$task]);
        $this->repository->shouldNotReceive('save');

        $this->expectException(TaskAlreadyExistsException::class);
        ($this->useCase)($taskData);
    }
}
