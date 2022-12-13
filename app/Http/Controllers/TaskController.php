<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\JsonResponse;
use Src\Task\Domain\Task;
use Src\Task\Application\UseCase\CreateTask;

class TaskController extends Controller
{
    public function __construct(private CreateTask $createTaskUseCase) {}

    public function store(StoreTaskRequest $request): JsonResponse
    {
        ($this->createTaskUseCase)($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'New task created successfully!',
            'data' => [ 'id' => $request->id ],
        ]);
    }
}
