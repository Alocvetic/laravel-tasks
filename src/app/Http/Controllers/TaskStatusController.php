<?php

namespace App\Http\Controllers;

use App\Services\Response\ApiResponse;
use App\Services\TaskStatusService;
use Illuminate\Http\JsonResponse;

class TaskStatusController extends Controller
{
    public function __construct(
        protected TaskStatusService $service
    ) {
    }

    public function index(): JsonResponse
    {
        $taskStatuses = $this->service->getAll();

        return ApiResponse::json($taskStatuses->toArray());
    }

    public function show(string $uuid): JsonResponse
    {
        $taskStatus = $this->service->getByUuid($uuid);

        return ApiResponse::json($taskStatus->toArray());
    }
}
