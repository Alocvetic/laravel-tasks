<?php

namespace App\Services;

use App\DTO\Task\{StoreTaskDTO, UpdateTaskDTO};
use App\Filters\TaskFilter;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TaskService
{
    public function __construct(
        protected TaskFilter $taskFilter
    )
    {
    }

    /**
     * Получение всех Задач
     *
     * @param Request $request
     * @return Collection
     */
    public function getAll(Request $request): Collection
    {
        if (!empty($request->query())) {
            $query = $this->taskFilter->buildQuery($request);
            return $query->get();
        }

        return Task::all();
    }


    /**
     * Получение Задачи по id
     *
     * @param int $id
     * @return Task|ModelNotFoundException
     */
    public function getById(int $id): Task|ModelNotFoundException
    {
        return Task::where('id', $id)->firstOrFail();
    }

    /**
     * Проверка наличия Задачи по id
     *
     * @param int $id
     * @return bool
     */
    public function checkById(int $id): bool
    {
        return Task::where('id', $id)->exists();
    }

    /**
     * Создание Задачи
     *
     * @param StoreTaskDTO $dto
     * @return int
     */
    public function create(StoreTaskDTO $dto): int
    {
        $task = new Task();

        $this->populate($task, $dto);
        $task->save();

        return $task->id;
    }

    /**
     * Обновление Задачи
     *
     * @param int $id
     * @param UpdateTaskDTO $dto
     * @return int
     */
    public function update(int $id, UpdateTaskDTO $dto): int
    {
        $task = Task::where('id', $id)->first();

        $this->populate($task, $dto);
        $task->save();

        return $task->id;
    }

    /**
     * Подготовка данных Задачи
     *
     * @param Task $task
     * @param StoreTaskDTO|UpdateTaskDTO $dto
     * @return Task
     */
    protected function populate(Task $task, StoreTaskDTO|UpdateTaskDTO $dto): Task
    {
        $task->title = $dto->getTitle();
        $task->description = $dto->getDescription();
        $task->deadline_at = $dto->getDeadlineAt();
        $task->task_status_id = $dto->getTaskStatusId();

        return $task;
    }

    /**
     * Удаление Задачи
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        Task::where('id', $id)->delete();
    }
}
