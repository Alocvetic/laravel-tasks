<?php

namespace App\Exceptions;

use App\Services\Response\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, Throwable $e)
    {
        if ($request->wantsJson()) {
            $status = $e->getCode();
            $data = [$e->getMessage()];
            $message = 'Произошла ошибка! Мы уже работаем над ее устранением.';

            if ($e instanceof ValidationException) {
                $status = 422;
                $data = $e->errors();
                $message = 'Ошибка валидации данных';
            } else {
                if ($e instanceof ModelNotFoundException) {
                    $status = 404;
                    $data = [];
                    $message = 'Запись не найдена';
                }
            }

            return ApiResponse::json(
                $data,
                $status,
                $message
            );
        }

        return parent::render($request, $e);
    }

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {

        });
    }
}
