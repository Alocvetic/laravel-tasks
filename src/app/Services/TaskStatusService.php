<?php

namespace App\Services;

use App\Models\TaskStatus;
use Illuminate\Database\Eloquent\Collection;

class TaskStatusService
{
    /**
     * Получение всех Статусов задач
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return TaskStatus::all();
    }

    /**
     * Получение Статуса задачи по uuid
     *
     * @param string $uuid
     * @return TaskStatus
     */
    public function getByUuid(string $uuid): TaskStatus
    {
        return TaskStatus::where('uuid', $uuid)->firstOrFail();
    }
}
