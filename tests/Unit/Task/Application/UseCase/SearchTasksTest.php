<?php

namespace Tests\Unit\Task\Application\UseCase;

use Mockery;
use Mockery\MockInterface;
use InvalidArgumentException;
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
        $filters = [
            'name' => 'do the laundry',
            'status' => 0,
        ];
        $this->repository->shouldReceive('find')
            ->once()
            ->withArgs([$filters])
            ->andReturn([$task1, $task2]);

        $result = ($this->useCase)($filters);

        $this->assertEquals([
            [
                'id' => 'e48bf15a-ccaa-41ef-b7ce-402f2da40a48',
                'name' => 'do the laundry',
                'status' => 0,
            ],
            [
                'id' => '9ad5f3f3-2d79-4cf4-8c7d-fbaf1a2a5d38',
                'name' => 'do the laundry please',
                'status' => 0,
            ],
        ], $result);
    }

    public function testInvokeThrowsInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Field 'id' is not a valid field.");

        ($this->useCase)(['id' => 'd0261842-c398-4a2b-97ad-2377ce6b7fc8']);
    }
}
