<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    protected int $taskStatusId;

    public function setTaskStatusId(int $task_status_id): static
    {
        $this->taskStatusId = $task_status_id;

        return $this;
    }

    public function definition(): array
    {
        return [
            'title' => fake()->text(20),
            'description' => fake()->text(100),
            'task_status_id' => $this->taskStatusId,
            'deadline_at' => fake()->dateTimeBetween('now', '+1 year')->format('Y-m-d')
        ];
    }
}
