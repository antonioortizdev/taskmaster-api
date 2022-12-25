<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Src\Task\Application\UseCase\CreateTask;
use Src\Task\Domain\Exception\TaskAlreadyExistsException;

class TaskController extends Controller
{
    public function __construct(private CreateTask $createTaskUseCase) {}

    public function store(StoreTaskRequest $request): JsonResponse
    {
        try {
            ($this->createTaskUseCase)($request->all());

            return new JsonResponse([
                'message' => 'New task created successfully!',
                'data' => [ 'id' => $request->id ],
            ], Response::HTTP_OK);
        } catch (TaskAlreadyExistsException $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
