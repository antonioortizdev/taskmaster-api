<?php

namespace Tests\Unit\Task\Application\UseCase;

use Mockery;
use Src\Task\Application\UseCase\FindTaskById;
use Src\Task\Domain\Repository\TaskRepository;
use Src\Task\Domain\Task;
use Src\Task\Domain\Exception\TaskNotFoundException;
use Tests\TestCase;

class FindTaskByIdTest extends TestCase
{
    private $repositoryMock, $findATaskByIdUseCase;

    public function setUp(): void
    {
        $this->repositoryMock = Mockery::mock(TaskRepository::class);
        $this->findATaskByIdUseCase = new FindTaskById($this->repositoryMock);
    }

    public function testInvokeFindsTaskSuccessfully()
    {
        $task = Task::fromPrimitives([
            'id' => 'b1f78b1e-620e-4adb-b752-94d24f76abc0',
            'name' => 'do the laundry',
        ]);
        $id = 'b1f78b1e-620e-4adb-b752-94d24f76abc0';
        $this->repositoryMock->shouldReceive('find')
            ->once()
            ->withArgs([
                ['id' => 'b1f78b1e-620e-4adb-b752-94d24f76abc0'],
            ])
            ->andReturn([$task]);

        $result = ($this->findATaskByIdUseCase)($id);

        $this->assertEquals([
            'id' => 'b1f78b1e-620e-4adb-b752-94d24f76abc0',
            'name' => 'do the laundry',
            'status' => 0,
        ], $result);
    }

    public function testInvokeThrowsTaskNotFoundException()
    {
        $id = 'b1f78b1e-620e-4adb-b752-94d24f76abc0';
        $this->repositoryMock->shouldReceive('find')
            ->once()
            ->withArgs([
                ['id' => 'b1f78b1e-620e-4adb-b752-94d24f76abc0'],
            ])
            ->andReturn([]);

        $this->expectException(TaskNotFoundException::class);

        ($this->findATaskByIdUseCase)($id);
    }
}
