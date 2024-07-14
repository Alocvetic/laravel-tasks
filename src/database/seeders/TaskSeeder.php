<?php

namespace Database\Seeders;

use App\DataKeepers\TaskStatusKeeper;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = TaskStatusKeeper::getAll();
        $statusUuids = array_keys($statuses);

        $query = [];
        $now = now();

        for ($i = 1; $i <= 12; $i++) {
            $query[] = [
                'title' => "title $i",
                'description' => "description $i",
                'task_status_uuid' => $statusUuids[array_rand($statusUuids)],
                'deadline_at' => $now->clone()->addDays(random_int(1, 300)),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('tasks')->upsert($query, 'id');
    }
}
