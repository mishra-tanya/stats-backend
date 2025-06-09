<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        // Add exceptions you don't want to report (optional)
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        // You can customize reporting or rendering callbacks here if needed
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception): Response
    {
        if ($request->expectsJson() || $request->is('api/*')) {

            if ($exception instanceof ModelNotFoundException) {
                return apiError('Resource not found', 404);
            }

            if ($exception instanceof NotFoundHttpException) {
                return apiError('API route not found', 404);
            }

            if ($exception instanceof ValidationException) {
                return apiError('Validation failed', 422, $exception->errors());
            }

            if ($exception instanceof QueryException) {
                $pdoMessage = $exception->getPrevious()?->getMessage() ?? $exception->getMessage();
                return apiError("Database error: " . $pdoMessage, 500);
            }

            return apiError('Server error: ' . $exception->getMessage(), 500);
        }

        return parent::render($request, $exception);
    }
}
