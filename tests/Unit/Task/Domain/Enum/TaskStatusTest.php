<?php

namespace Tests\Unit\Task\Domain\Enum;

use PHPUnit\Framework\TestCase;
use Src\Task\Domain\Enum\TaskStatus;

class TaskStatusTest extends TestCase
{
    public function testTaskStatusEnum()
    {
        $pendingStatusValue = 0;
        $inProgressStatusValue = 1;
        $completedStatusValue = 2;

        $this->assertEquals(TaskStatus::PENDING->value, $pendingStatusValue);
        $this->assertEquals(TaskStatus::IN_PROGRESS->value, $inProgressStatusValue);
        $this->assertEquals(TaskStatus::COMPLETED->value, $completedStatusValue);
    }
}
