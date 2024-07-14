<?php

namespace App\Services;

use App\DTO\Task\{StoreTaskDTO, UpdateTaskDTO};
use App\Filters\TaskFilter;
use App\Http\Requests\GetTasksRequest;
use App\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class TaskService
{
    public function __construct(
        protected TaskFilter $taskFilter
    ) {
    }

    /**
     * Получение всех Задач
     *
     * @param GetTasksRequest $request
     * @return LengthAwarePaginator|Collection
     */
    public function getAll(GetTasksRequest $request): LengthAwarePaginator|Collection
    {
        if (!empty($request->query())) {
            $query = $this->taskFilter->buildQuery($request);

            $paginateData = $this->taskFilter->buildPaginateData();
            if (!is_null($paginateData)) {
                return $query->paginate(perPage: $paginateData['limit'], page: $paginateData['number']);
            }

            return $query->get();
        }

        return Task::all();
    }


    /**
     * Получение Задачи по id
     *
     * @param int $id
     * @return Task
     */
    public function getById(int $id): Task
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
        $task->task_status_uuid = $dto->getTaskStatusUuid();

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
