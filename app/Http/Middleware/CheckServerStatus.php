<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDOException;

class CheckServerStatus
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            // Cố gắng kết nối đến database
            DB::connection()->getPdo();
        } catch (PDOException $e) {
            // Nếu không kết nối được → trả về trang thông báo
            return response()->view('errors.503', [], 503);
        }

        return $next($request);
    }
}
