<?php

namespace App\DTO\Task;

use Illuminate\Http\JsonResponse;

class TaskResponseDTO
{
    public int $status;
    public string $message;
    public array $data;

    public function __construct(array $data = [], int $status = 200, string $message = '')
    {
        $this->status = $status;
        $this->data = $data;
        $this->message = $message;
    }

    public function json(): JsonResponse
    {
        $data['status'] = $this->status;

        if (strlen($this->message) > 0) {
            $data['message'] = $this->message;
        }

        $data['data'] = $this->data;

        return response()->json($data, $this->status);
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function getCode()
    {
        return $this->status;
    }
}
