<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AvailableTaskFieldsRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $taskCols = ['title', 'description', 'task_status_uuid', 'deadline_at', 'created_at', 'updated_at'];
        $taskStatusCols = ['uuid', 'title', 'created_at', 'updated_at'];

        $columns = explode(',', $value);

        foreach ($columns as $column) {
            if (str_contains($column, ':')) {
                $joinCols = explode(':', $column);
                $column = $joinCols[0];

                if (!in_array($joinCols[1], $taskStatusCols)) {
                    $fail('Недопустимое поле из таблицы task_statuses: ' . $joinCols[1]);
                }
            }

            if (!in_array($column, $taskCols)) {
                $fail('Недопустимое поле из таблицы tasks: ' . $column);
            }
        }
    }
}
