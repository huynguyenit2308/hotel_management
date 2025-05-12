<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    /**
     * Xử lý một yêu cầu đến.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra nếu người dùng đã đăng nhập và có quyền Admin hoặc Super Admin
        if (Auth::check() && Auth::user()->adminRole) {
            $role = Auth::user()->adminRole->role_name;
            
            if ($role === 'Super Admin' || $role === 'Admin') {
                return $next($request);
            }
        }
        
        // Người dùng không được phép truy cập trang này
        return redirect()->route('home')->with('error', 'Bạn không có quyền truy cập trang này.');
    }
} 