<?php

namespace Database\Seeders;

use App\DataKeepers\TaskStatusKeeper;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses_list = TaskStatusKeeper::getAll();

        $query = [];
        $now = now();
        foreach ($statuses_list as $uuid => $status) {
            $query[] = [
                'uuid' => $uuid,
                'title' => $status,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('task_statuses')->upsert($query, 'uuid');
    }
}
