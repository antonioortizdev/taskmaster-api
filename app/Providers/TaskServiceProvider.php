<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Task\Domain\Repository\TaskRepository;
use Src\Task\Infrastructure\Eloquent\Repository\EloquentTaskRepository;

class TaskServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $bindings = [
        TaskRepository::class => EloquentTaskRepository::class,
    ];
}
