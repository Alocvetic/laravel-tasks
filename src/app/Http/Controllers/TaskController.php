<?php

namespace App\Http\Controllers;

use App\Http\Requests\{GetTasksRequest, StoreTaskRequest, UpdateTaskRequest};
use App\Services\Response\ApiResponse;
use App\Services\Response\BuildResponseHelper;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    public function __construct(
        protected TaskService $service
    ) {
    }

    public function index(GetTasksRequest $request): JsonResponse
    {
        $tasks = $this->service->getAll($request);
        $result = BuildResponseHelper::buildResponseData($tasks);

        return ApiResponse::json($result);
    }

    public function show(int $id): JsonResponse
    {
        $task = $this->service->getById($id);

        return ApiResponse::json($task->toArray());
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $dto = $request->toDto();
        $id = $this->service->create($dto);

        return ApiResponse::json(['id' => $id], message: 'Задача успешно создана');
    }

    public function update(UpdateTaskRequest $request, int $id): JsonResponse
    {
        if (!$this->service->checkById($id)) {
            return ApiResponse::json(status: 404, message: 'Такой задачи не существует');
        }

        $dto = $request->toDto();
        $id = $this->service->update($id, $dto);

        return ApiResponse::json(['id' => $id], message: 'Задача успешно обновлена');
    }

    public function delete(int $id): JsonResponse
    {
        if (!$this->service->checkById($id)) {
            return ApiResponse::json(status: 404, message: 'Такой задачи не существует');
        }

        $this->service->delete($id);

        return ApiResponse::json(message: 'Задача успешно удалена');
    }
}
