<?php

namespace Tests\Unit\Task\Application\UseCase;
use Src\Task\Application\UseCase\CreateTask;
use Src\Task\Domain\Repository\TaskRepository;
use Src\Task\Domain\Task;
use Src\Task\Domain\ValueObject\TaskId;
use Src\Task\Domain\ValueObject\TaskName;
use Tests\TestCase;

class CreateTaskTest extends TestCase
{
    public function testInvokeSavesTask()
    {
        $newTask = new Task(
            new TaskId('b1f78b1e-620e-4adb-b752-94d24f76abc0'),
            new TaskName('do the laundry'),
        );
        $mockRepository = $this->createMock(TaskRepository::class);

        $mockRepository->expects($this->once())
            ->method('save')
            ->with($newTask);

        $createTask = new CreateTask($mockRepository);
        $createTask($newTask);
    }
}
