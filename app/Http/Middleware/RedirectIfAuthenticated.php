<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;
    
        foreach ($guards as $guard) {
            // Kiểm tra người dùng đã đăng nhập chưa
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user(); // Lấy thông tin người dùng đã đăng nhập
    
                // Debug thông tin người dùng
                dd($user); // Kiểm tra giá trị của $user
    
                // Kiểm tra vai trò của người dùng
                if ($user->role == 'user') {
                    return redirect('/dashboard');
                } elseif ($user->role == 'agent') {
                    return redirect('/agent/dashboard');
                } else {
                    return redirect('/admin/dashboard');
                }
            }
        }
    
        return $next($request);
    }
    

    

    
}
