<?php

namespace Tests\Unit\Task\Application\UseCase;
use Src\Task\Application\UseCase\CreateTask;
use Src\Task\Domain\Repository\TaskRepository;
use Src\Task\Domain\Task;
use Tests\TestCase;

final class CreateTaskTest extends TestCase
{
    public function testInvokeSavesTask()
    {
        $newTaskData = [
            'id' => 'b1f78b1e-620e-4adb-b752-94d24f76abc0',
            'name' => 'do the laundry',
        ];
        $mockRepository = $this->createMock(TaskRepository::class);

        $mockRepository->expects($this->once())
            ->method('save')
            ->with(Task::fromPrimitives($newTaskData));

        $createTask = new CreateTask($mockRepository);
        $createTask($newTaskData);
    }
}
