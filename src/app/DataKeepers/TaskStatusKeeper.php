<?php

namespace App\DataKeepers;


enum TaskStatusKeeper: string
{
    case TO_DO_VALUE = 'To Do';
    case TO_DO_UUID = 'aa71b3fe-bfea-4ec3-812e-c34d350f15df';
    case ACCEPTED_VALUE = 'Accepted';
    case ACCEPTED_UUID = '28ec059d-da72-4eeb-add8-d1f1d677cda0';
    case IN_PROGRESS_VALUE = 'In Progress';
    case IN_PROGRESS_UUID = '5ac8bfab-d929-46cf-a300-d464216ae5e8';
    case ONE_TESTING_VALUE = 'In Testing';
    case ONE_TESTING_UUID = 'a68289bc-d66e-4713-8f7e-675868bf3f67';
    case COMPLETED_VALUE = 'Completed';
    case COMPLETED_UUID = '02d6b771-da29-4c6d-a274-cac9ef865201';
    case CANCELED_VALUE = 'Canceled';
    case CANCELED_UUID = '649b6650-79a8-4705-ac5a-3cfce1d48712';

    public static function getAll(): array
    {
        return [
            self::TO_DO_UUID->value => self::TO_DO_VALUE->value,
            self::ACCEPTED_UUID->value => self::ACCEPTED_VALUE->value,
            self::IN_PROGRESS_UUID->value => self::IN_PROGRESS_VALUE->value,
            self::ONE_TESTING_UUID->value => self::ONE_TESTING_VALUE->value,
            self::COMPLETED_UUID->value => self::CANCELED_VALUE->value,
            self::CANCELED_UUID->value => self::COMPLETED_VALUE->value,
        ];
    }
}
