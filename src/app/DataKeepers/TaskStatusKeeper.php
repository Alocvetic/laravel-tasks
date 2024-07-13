<?php

namespace App\DataKeepers;

class TaskStatusKeeper
{
    public const TO_DO = 'To Do';
    public const ACCEPTED = 'Accepted';
    public const IN_PROGRESS = 'In Progress';
    public const ONE_TESTING = 'In Testing';
    public const COMPLETED = 'Completed';
    public const CANCELED = 'Canceled';

    public static function getAll(): array
    {
        return [
            self::TO_DO,
            self::ACCEPTED,
            self::IN_PROGRESS,
            self::ONE_TESTING,
            self::CANCELED,
            self::COMPLETED,
        ];
    }
}
