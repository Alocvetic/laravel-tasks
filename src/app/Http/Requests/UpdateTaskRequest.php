<?php

namespace App\Http\Requests;

use App\DTO\Task\UpdateTaskDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:2', 'max:255'],
            'description' => ['required', 'string', 'min:2', 'max:800'],
            'task_status_uuid' => ['required', 'string', 'min:1', 'max:255', Rule::exists('task_statuses', 'uuid')],
            'deadline_at' => ['date', 'after_or_equal:today', 'date_format:Y-m-d'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Заполните поле',
            'title.string' => 'Должна быть строка',
            'title.min' => 'Длина не менее :min символов',
            'title.max' => 'Длина не более :min символов',
            'description.required' => 'Заполните поле',
            'description.string' => 'Должна быть строка',
            'description.min' => 'Длина не менее :min символов',
            'description.max' => 'Длина не более :min символов',
            'task_status_uuid.required' => 'Выберите статус',
            'task_status_uuid.string' => 'Должна быть строка',
            'task_status_uuid.min' => 'Длина не менее :min символов',
            'task_status_uuid.max' => 'Длина не более :min символов',
            'task_status_uuid.exists' => 'Выберите существующий статус',
            'deadline_at.date' => 'Должна быть дата',
            'deadline_at.after_or_equal' => 'Диапазон от сегодняшней даты',
            'deadline_at.date_format' => 'Должен быть формат Y-m-d',
        ];
    }

    public function toDto(): UpdateTaskDTO
    {
        $this->validated();

        $dto = new UpdateTaskDTO();

        $dto->setTitle($this->title);
        $dto->setDescription($this->description);
        $dto->setTaskStatusUuid($this->task_status_uuid);

        $deadline_at = isset($this->deadline_at) ? $this->deadline_at : null;
        $dto->setDeadlineAt($deadline_at);

        return $dto;
    }
}
