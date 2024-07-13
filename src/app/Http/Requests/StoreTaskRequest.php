<?php

namespace App\Http\Requests;

use App\DTO\Task\StoreTaskDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:2', 'max:255'],
            'description' => ['required', 'string', 'min:2', 'max:255'],
            'task_status_id' => ['required', 'integer', 'min:1', 'max:99999999999', Rule::exists('task_statuses', 'id')],
            'deadline_at' => ['date', 'after_or_equal:today', 'date_format:Y-m-d'],
        ];
    }

    public function toDto(): StoreTaskDTO
    {
        $this->validated();

        $dto = new StoreTaskDTO();

        $dto->setTitle($this->title);
        $dto->setDescription($this->description);
        $dto->setTaskStatusId((int)$this->task_status_id);

        $deadline_at = isset($this->deadline_at) ? $this->deadline_at : null;
        $dto->setDeadlineAt($deadline_at);

        return $dto;
    }
}
