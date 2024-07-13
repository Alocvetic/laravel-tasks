<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskStatus>
 */
class TaskStatusFactory extends Factory
{
    protected string $title;

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function definition(): array
    {
        return [
            'title' => $this->title,
        ];
    }
}
