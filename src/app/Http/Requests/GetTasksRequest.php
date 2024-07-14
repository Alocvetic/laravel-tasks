<?php

namespace App\Http\Requests;

use App\Rules\AvailableTaskFieldsRule;
use App\Rules\AvailableTaskFilterCompareRule;
use App\Rules\AvailableTaskSortRule;
use App\Rules\TaskFilterUuidRule;
use Illuminate\Foundation\Http\FormRequest;

class GetTasksRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'page' => ['nullable', 'array'],
            'page.number' => ['nullable', 'integer', 'min:0'],
            'page.limit' => ['required_with:page.offset', 'nullable', 'integer', 'min:1'],
            'page.offset' => ['nullable', 'integer', 'min:0'],
            'fields' => ['nullable', 'string', new AvailableTaskFieldsRule()],
            'sort' => ['nullable', 'string', new AvailableTaskSortRule()],
            'filter' => ['nullable', 'array'],
            'filter.task_status_uuid' => ['nullable', 'array', new AvailableTaskFilterCompareRule()],
            'filter.task_status_uuid.*' => ['nullable', 'string', new TaskFilterUuidRule()],
            'filter.deadline_at' => ['nullable', 'array', new AvailableTaskFilterCompareRule()],
            'filter.deadline_at.*' => ['nullable', 'after_or_equal:today', 'date_format:Y-m-d'],
        ];
    }

    public function messages(): array
    {
        return [
            'page.array' => 'Должен быть массив page',
            'page.*.integer' => 'Должно быть целое число',
            'page.*.min' => 'Длина не менее :min символов',
            'page.limit.required_with' => 'Укажите limit',
            'fields.string' => 'Должна быть строка',
            'sort.string' => 'Должна быть строка',
            'filter.array' => 'Должен быть массив filter',
            'filter.*.array' => 'Должен быть массив',
            'filter.task_status_uuid.*.string' => 'Должна быть строка',
            'filter.deadline_at.*.date_format' => 'Должен быть формат Y-m-d',
            'filter.deadline_at.*.after_or_equal' => 'Диапазон от сегодняшней даты',
        ];
    }
}
