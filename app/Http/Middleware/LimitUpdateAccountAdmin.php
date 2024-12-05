<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class LimitUpdateAccountAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $lastAccess = $request->cookie('last_update_account_admin');
        $now = Carbon::now();

        $errors = [];

        if ($lastAccess && $now->diffInDays($lastAccess) < 7) {
            $errors["ManyTime"] = 'Bạn chỉ được cập nhật tài khoản sau 7 ngày';
            return response()->json(['success' => false, 'message' => "Bạn chỉ được cập nhật tài khoản sau 7 ngày"]);
        }

        $cookie = cookie('last_update_account_admin', $now, 60 * 24 * 7);
        return $next($request)->withCookie($cookie);
    }
}
