<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class LimitReport
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $lastAccess = $request->cookie('last_report');
        $now = Carbon::now();

        if ($lastAccess && $now->diffInDays($lastAccess) < 2) {
            return response()->json(['success' => false, 'message' => 'Bạn chỉ được phép báo cáo 2 ngày 1 lần']);
        }

        $cookie = cookie('last_report', $now, 60 * 24 * 7);
        return $next($request)->withCookie($cookie);
    }
}
