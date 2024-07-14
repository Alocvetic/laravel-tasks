<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AvailableTaskSortRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $taskColsAsc = ['title', 'deadline_at', 'created_at'];
        $taskColsDesc = array_map(function ($key) {
            return "-$key";
        }, $taskColsAsc);

        $taskCols = array_merge($taskColsAsc, $taskColsDesc);

        $values = explode(',', $value);
        foreach ($values as $sortValue) {
            if (!in_array($sortValue, $taskCols)) {
                $fail('Недопустимое поле из таблицы tasks: ' . $sortValue);
            }
        }
    }
}
