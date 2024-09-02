<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LimitContentUpdate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $updateCount = Cookie::get('update_count', 0);
        $lastUpdate = Cookie::get('last_update', now()->timestamp);

        if ($updateCount >= 2 && now()->timestamp - $lastUpdate < 604800) {
            Session::flash('Manytimes', 'checked');
            return redirect()->back();
        }

        Cookie::queue('update_count', $updateCount + 1, 604800);
        Cookie::queue('last_update', now()->timestamp, 604800);

        return $next($request);
    }
}
