<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            // Lỗi không tìm thấy model (ví dụ: nhân viên không tồn tại)
            return redirect()->route('employees.index')->with('error', 'Dữ liệu không tồn tại!');
        }
        if ($exception instanceof NotFoundHttpException) {
            // Lỗi không tìm thấy route (ví dụ: /abc)
            return redirect()->route('employees.index')->with('error', 'Đường dẫn không tồn tại!');
        }
        return parent::render($request, $exception);
    }
}
