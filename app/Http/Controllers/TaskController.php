<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use Exception;
use InvalidArgumentException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Src\Task\Application\UseCase\CreateTask;
use Src\Task\Application\UseCase\SearchTasks;
use Src\Task\Domain\Exception\TaskAlreadyExistsException;

class TaskController extends Controller
{
    public function __construct(
        private CreateTask $createTaskUseCase,
        private SearchTasks $searchTasksUseCase,
    ) {}

    public function store(StoreTaskRequest $request): JsonResponse
    {
        try {
            ($this->createTaskUseCase)($request->all());

            return new JsonResponse([
                'id' => $request->id
            ], Response::HTTP_OK);
        } catch (TaskAlreadyExistsException $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function index(IndexTaskRequest $request): JsonResponse
    {
        try {
            return new JsonResponse(
                ($this->searchTasksUseCase)($request->all()),
                Response::HTTP_OK,
            );
        } catch (InvalidArgumentException $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
