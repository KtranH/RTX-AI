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
        $lastAccess = Session::get('last_update_account_access');
        $now = Carbon::now();

        if ($lastAccess && $now->diffInDays($lastAccess) < 7) {
            Session::flash("Manytimes","checked");
            return redirect()->route("showaccount");
        }

        Session::put('last_update_account_access', $now);
        return $next($request);
    }
}
