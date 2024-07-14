<?php

namespace App\Http\Controllers;

use App\DTO\Task\TaskResponseDTO;
use Illuminate\Http\Request;
use App\Http\Requests\{StoreTaskRequest, UpdateTaskRequest};
use App\Services\TaskService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    public function __construct(
        protected TaskService $service
    )
    {
    }

    public function index(Request $request): JsonResponse
    {
        $tasks = $this->service->getAll($request);

        $response = new TaskResponseDTO($tasks->toArray());

        return $response->json();
    }

    public function show(int $id): JsonResponse
    {
        $response = new TaskResponseDTO();

        try {
            $task = $this->service->getById($id);
        } catch (ModelNotFoundException $exception) {
            $response->setStatus(422);
            $response->setMessage('Такой задачи не существует');

            return $response->json();
        }

        $response->setData($task->toArray());

        return $response->json();
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $dto = $request->toDto();
        $id = $this->service->create($dto);

        $response = new TaskResponseDTO(['id' => $id]);

        return $response->json();
    }

    public function update(UpdateTaskRequest $request, int $id): JsonResponse
    {
        $response = new TaskResponseDTO();

        if (!$this->service->checkById($id)) {
            $response->setStatus(422);
            $response->setMessage('Такой задачи не существует');

            return $response->json();
        }

        $dto = $request->toDto();
        $id = $this->service->update($id, $dto);

        $response = new TaskResponseDTO(['id' => $id]);

        return $response->json();
    }

    public function delete(int $id): JsonResponse
    {
        $response = new TaskResponseDTO();

        if (!$this->service->checkById($id)) {
            $response->setStatus(422);
            $response->setMessage('Такой задачи не существует');

            return $response->json();
        }

        $this->service->delete($id);

        $response = new TaskResponseDTO(['id' => $id]);

        return $response->json();
    }
}
