<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

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
            // Có thể trả về view riêng hoặc redirect với thông báo
            return response()->view('errors.notfound', [], 404);
            // Hoặc:
            // return redirect()->route('employees.index')->with('error', 'Không tìm thấy nhân viên!');
        }
        return parent::render($request, $exception);
    }
}
