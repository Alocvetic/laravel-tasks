<?php

namespace App\DTO\Task;

class StoreTaskDTO
{
    public string $title;
    public string $description;
    public string $task_status_uuid;
    public ?string $deadline_at = null;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getTaskStatusUuid(): string
    {
        return $this->task_status_uuid;
    }

    public function setTaskStatusUuid(string $task_status_uuid): void
    {
        $this->task_status_uuid = $task_status_uuid;
    }

    public function getDeadlineAt(): ?string
    {
        return $this->deadline_at;
    }

    public function setDeadlineAt(?string $deadline_at): void
    {
        $this->deadline_at = $deadline_at;
    }
}
