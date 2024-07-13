<?php

namespace App\Http\Requests;

use App\DTO\Task\TaskResponseDTO;
use App\DTO\Task\UpdateTaskDTO;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
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
            'description' => ['required', 'string', 'min:2', 'max:255'],
            'task_status_id' => ['required', 'integer', 'min:1', 'max:99999999999', Rule::exists('task_statuses', 'id')],
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
            'task_status_id.required' => 'Выберите статус',
            'task_status_id.integer' => 'Должно быть целое число',
            'task_status_id.min' => 'Длина не менее :min символов',
            'task_status_id.max' => 'Длина не более :min символов',
            'task_status_id.exists' => 'Выберите существующий статус',
            'deadline_at.date' => 'Должна быть дата',
            'deadline_at.after_or_equal' => 'Диапазон от сегодняшней даты',
            'deadline_at.date_format' => 'Должен быть формат Y-m-d',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $response = new TaskResponseDTO(
            $validator->errors()->messages(),
            422,
            'Ошибка валидации данных'
        );

        throw new HttpResponseException($response->json());
    }

    public function toDto(): UpdateTaskDTO
    {
        $this->validated();

        $dto = new UpdateTaskDTO();

        $dto->setTitle($this->title);
        $dto->setDescription($this->description);
        $dto->setTaskStatusId((int)$this->task_status_id);

        $deadline_at = isset($this->deadline_at) ? $this->deadline_at : null;
        $dto->setDeadlineAt($deadline_at);

        return $dto;
    }
}
