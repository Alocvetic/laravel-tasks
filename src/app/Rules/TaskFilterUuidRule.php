<?php

namespace App\Rules;

use App\DataKeepers\TaskStatusKeeper;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class TaskFilterUuidRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $taskStatusUuidList = array_map(function ($item) {
            return (string)$item;
        }, explode(',', $value));

        $taskStatusUuidKeeper = array_keys(TaskStatusKeeper::getAll());
        foreach ($taskStatusUuidList as $uuid) {
            if (!in_array($uuid, $taskStatusUuidKeeper)) {
                $fail('Такого статуса не существует');
            }
        }
    }
}
