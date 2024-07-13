<?php

namespace App\DTO\Task;

class StoreTaskDTO
{
    public string $title;
    public string $description;
    public int $task_status_id;
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

    public function getTaskStatusId(): int
    {
        return $this->task_status_id;
    }

    public function setTaskStatusId(int $task_status_id): void
    {
        $this->task_status_id = $task_status_id;
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
