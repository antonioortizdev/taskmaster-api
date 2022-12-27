<?php

namespace Tests\Unit\Task\Application\UseCase;

use Mockery;
use Mockery\MockInterface;
use Src\Task\Application\UseCase\SearchTasks;
use Src\Task\Domain\Repository\TaskRepository;
use Src\Task\Domain\Task;
use Tests\TestCase;

class SearchTasksTest extends TestCase
{
    private MockInterface $repository;
    private SearchTasks $useCase;

    public function setUp(): void
    {
        $this->repository = Mockery::mock(TaskRepository::class);
        $this->useCase = new SearchTasks($this->repository);
    }

    public function testInvokeFindsMultipleTasks()
    {
        $filters = [
            'name' => 'do the laundry',
            'status' => 0,
        ];
        $task1 = Task::fromPrimitives([
            'id' => 'e48bf15a-ccaa-41ef-b7ce-402f2da40a48',
            'name' => 'do the laundry',
            'status' => 0,
        ]);
        $task2 = Task::fromPrimitives([
            'id' => '9ad5f3f3-2d79-4cf4-8c7d-fbaf1a2a5d38',
            'name' => 'do the laundry please',
            'status' => 0,
        ]);
        $tasks = [$task1, $task2];

        $this->repository->shouldReceive('find')
            ->once()
            ->withArgs([$filters])
            ->andReturn($tasks);

        $this->assertEquals($tasks, ($this->useCase)($filters));
    }
}
