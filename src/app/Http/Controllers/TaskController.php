<?php

namespace App\Http\Controllers;

use App\Http\Requests\{
    StoreTaskRequest,
    UpdateTaskRequest
};
use App\Services\TaskService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskController extends Controller
{
    public function __construct(
        protected TaskService $service
    )
    {
    }

    public function index(): array
    {
        $tasks = $this->service->getAll();

        return [
            'status' => 'success',
            'data' => $tasks
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

    public function store(StoreTaskRequest $request): array
    {
        $dto = $request->toDto();
        $id = $this->service->create($dto);

        return [
            'status' => 'success',
            'data' => ['id' => $id],
        ];
    }

    public function update(UpdateTaskRequest $request, int $id): array
    {
        if (!$this->service->checkById($id)) {
            return [
                'status' => 'error',
                'message' => 'Такой задачи не существует'
            ];
        }

        $dto = $request->toDto();
        $id = $this->service->update($id, $dto);

        return [
            'status' => 'success',
            'data' => ['id' => $id],
        ];

    }

    public function delete(int $id): array
    {
        if (!$this->service->checkById($id)) {
            return [
                'status' => 'error',
                'message' => 'Такой задачи не существует'
            ];
        }

        $this->service->delete($id);

        return [
            'status' => 'success',
            'data' => ['id' => $id],
        ];
    }
}
