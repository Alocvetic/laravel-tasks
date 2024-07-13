<?php

namespace App\Http\Controllers;

use App\DTO\Task\TaskResponseDTO;
use App\Services\TaskStatusService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class TaskStatusController extends Controller
{
    public function __construct(
        protected TaskStatusService $service
    )
    {
    }

    public function index(): JsonResponse
    {
        $taskStatuses = $this->service->getAll();

        $response = new TaskResponseDTO($taskStatuses->toArray());

        return $response->json();
    }

    public function show(int $id): JsonResponse
    {
        $response = new TaskResponseDTO();

        try {
            $taskStatus = $this->service->getById($id);
        } catch (ModelNotFoundException $exception) {
            $response->setStatus(422);
            $response->setMessage('Такого статуса задачи не существует');

            return $response->json();
        }

        $response->setData($taskStatus->toArray());

        return $response->json();
    }
}
