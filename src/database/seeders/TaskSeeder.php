<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = TaskStatus::all()->pluck('id');

        for ($i = 0; $i < 12; $i++) {
            Task::factory()
                ->setTaskStatusId($statuses->random())
                ->create();
        }
    }
}
