<?php

namespace Database\Seeders;

use App\DataKeepers\TaskStatusKeeper;
use App\Models\TaskStatus;
use Illuminate\Database\Seeder;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses_list = TaskStatusKeeper::getAll();

        foreach ($statuses_list as $status) {
            TaskStatus::factory()
                ->setTitle($status)
                ->create();
        }
    }
}
