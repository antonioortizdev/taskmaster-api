<?php

namespace Tests\Unit\Task\Domain;
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
    }

    public function testFromPrimitivesConvertsArrayToTaskObject()
    {
        $primitives = [
            'id' => 'b1f78b1e-620e-4adb-b752-94d24f76abc0',
            'name' => 'do the laundry',
        ];
        $task = Task::fromPrimitives($primitives);

        $this->assertEquals(new TaskId($primitives['id']), $task->id);
        $this->assertEquals(new TaskName($primitives['name']), $task->name);
    }

    public function testToPrimitivesReturnsArrayOfProperties()
    {
        $id = 'b1f78b1e-620e-4adb-b752-94d24f76abc0';
        $name = 'do the laundry';

        $task = new Task(new TaskId($id), new TaskName($name));

        $primitives = $task->toPrimitives();

        $this->assertSame($primitives['id'], $id);
        $this->assertSame($primitives['name'], $name);
    }
}
