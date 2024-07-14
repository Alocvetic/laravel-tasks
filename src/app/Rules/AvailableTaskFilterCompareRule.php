<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AvailableTaskFilterCompareRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $rules = [
            'task_status_uuid' => ['eq', 'ne', 'in', 'notIn'],
            'deadline_at' => ['eq', 'ne', 'lt', 'lte', 'gt', 'gte']
        ];

        $column = explode('.', $attribute)[1];
        $columnKeys = array_keys($value);

        if (!in_array($column, array_keys($rules))) {
            $fail('Недопустимое поле из таблицы tasks: ' . $column);
        }

        $columnKeysList = $rules[$column];
        foreach ($columnKeys as $key) {
            if (!in_array($key, $columnKeysList)) {
                $fail('Недоступный тип фильтрации для поля: ' . $key);
            }
        }
    }
}
