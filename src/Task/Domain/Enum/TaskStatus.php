<?php

namespace Src\Task\Domain\Enum;

enum TaskStatus: int
{
    case PENDING = 0;
    case IN_PROGRESS = 1;
    case COMPLETED = 2;
}
