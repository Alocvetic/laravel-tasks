<?php

namespace App\Services;

use App\Models\TaskStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskStatusService
{
    public function getAll(): Collection
    {
        return TaskStatus::all();
    }

    public function getById(int $id): TaskStatus|ModelNotFoundException
    {
        return TaskStatus::where('id', $id)->firstOrFail();
    }
}
