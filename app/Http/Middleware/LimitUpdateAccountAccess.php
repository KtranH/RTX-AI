<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LimitUpdateAccountAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $lastAccess = $request->cookie('last_update_account_access');
        $now = Carbon::now();

        $errors = [];

        if ($lastAccess && $now->diffInDays($lastAccess) < 7) {
            $errors["ManyTime"] = 'Bạn chỉ được cập nhật tài khoản sau 7 ngày';
            return redirect()->back()->withErrors($errors);
        }

        $cookie = cookie('last_update_account_access', $now, 60 * 24 * 7);
        return $next($request)->withCookie($cookie);
    }
}
