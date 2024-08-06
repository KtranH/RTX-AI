<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class ThrottleRequests
{
    public function handle($request, Closure $next, $maxAttempts = 2, $decayMinutes = 1)
    {
        $key = $this->resolveRequestSignature($request);

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) 
        {
            Session::flash("Manytimes","checked");
            return redirect()->route("forgetpass");
        }

        RateLimiter::hit($key, $decayMinutes * 60);

        return $next($request);
    }

    protected function resolveRequestSignature($request)
    {
        return sha1(
            $request->ip()
        );
    }
}