<?php

namespace Tests\Unit\Task\Application\UseCase;

use Mockery;
use Src\Task\Application\UseCase\FindTaskById;
use Src\Task\Domain\Repository\TaskRepository;
use Src\Task\Domain\Task;
use Src\Task\Domain\Exception\TaskNotFoundException;
use Tests\TestCase;

class FindATaskByIdTest extends TestCase
{
    private $repositoryMock, $findATaskByIdUseCase;

    public function setUp(): void
    {
        $this->repositoryMock = Mockery::mock(TaskRepository::class);
        $this->findATaskByIdUseCase = new FindTaskById($this->repositoryMock);
    }

    public function testInvokeSavesTask()
    {
        $id = 'b1f78b1e-620e-4adb-b752-94d24f76abc0';

        $this->repositoryMock->shouldReceive('find')
            ->once()
            ->with([ 'id' => $id ])
            ->andReturn([
                Task::fromPrimitives([
                    'id' => $id,
                    'name' => 'do the laundry',
                ])
            ]);

        ($this->findATaskByIdUseCase)($id);
    }

    public function testInvokeThrowsTaskNotFoundException()
    {
        $id = 'b1f78b1e-620e-4adb-b752-94d24f76abc0';

        $this->repositoryMock->shouldReceive('find')
            ->once()
            ->with([ 'id' => $id ])
            ->andReturn([]);

        $this->expectException(TaskNotFoundException::class);

        ($this->findATaskByIdUseCase)($id);
    }
}
