<?php

namespace App\Http\Controllers;

use App\Services\TaskStatusService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskStatusController extends Controller
{
    public function __construct(
        protected TaskStatusService $service
    )
    {
    }

    public function index(): array
    {
        $taskStatuses = $this->service->getAll();

        return [
            'status' => 'success',
            'data' => $taskStatuses
        ];
    }

    public function show(int $id): array
    {
        try {
            $task = $this->service->getById($id);
        } catch (ModelNotFoundException $exception) {
            return [
                'status' => 'error',
                'message' => 'Такой задачи не существует'
            ];
        }

        return [
            'status' => 'success',
            'data' => $task
        ];
    }
}
