<?php

namespace Tests\Unit\Task\Domain;
use Src\Task\Domain\Enum\TaskStatus;
use Src\Task\Domain\Task;
use Src\Task\Domain\ValueObject\TaskId;
use Src\Task\Domain\ValueObject\TaskName;
use Tests\TestCase;

class TaskTest extends TestCase
{
    public function testConstructorSetsProperties()
    {
        $id = new TaskId('b1f78b1e-620e-4adb-b752-94d24f76abc0');
        $name = new TaskName('do the laundry');

        $task = new Task($id, $name);

        $this->assertSame($id, $task->id);
        $this->assertSame($name, $task->name);
        $this->assertSame(TaskStatus::PENDING, $task->status);
    }

    public function testToPrimitivesReturnsArrayOfProperties()
    {
        $id = 'b1f78b1e-620e-4adb-b752-94d24f76abc0';
        $name = 'do the laundry';
        $completedStatus = 2;

        $task = new Task(
            new TaskId($id),
            new TaskName($name),
            TaskStatus::COMPLETED,
        );

        $primitives = $task->toPrimitives();

        $this->assertSame($primitives['id'], $id);
        $this->assertSame($primitives['name'], $name);
        $this->assertSame($primitives['status'], $completedStatus);
    }

    public function testFromPrimitivesConvertsArrayToTaskObject()
    {
        $inProgressStatus = 1;
        $primitives = [
            'id' => 'b1f78b1e-620e-4adb-b752-94d24f76abc0',
            'name' => 'do the laundry',
            'status' => $inProgressStatus,
        ];
        $task = Task::fromPrimitives($primitives);

        $this->assertEquals(new TaskId($primitives['id']), $task->id);
        $this->assertEquals(new TaskName($primitives['name']), $task->name);
        $this->assertEquals(TaskStatus::IN_PROGRESS, $task->status);
    }
}
