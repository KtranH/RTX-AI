<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyTurnstileCaptcha
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->input('skip_captcha')) {
            return $next($request);
        }

        $token = $request->input('cf-turnstile-response');

        if (!$token) {
            if ($request->is('login')) {
                return $next($request);
            }
            if ($request->is('signup')) {
                return $next($request);
            }
            if ($request->is('forgetpass')) {
                return $next($request);
            }
            if ($request->is('inputcodetochangepass')) {
                return $next($request);
            }
            return back()->withErrors(['captcha' => 'Vui lòng xác nhận Captcha.']);
        }

        $client = new Client();
        $response = $client->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'form_params' => [
                'secret' => config('services.turnstile.secret_key'),
                'response' => $token,
                'remoteip' => $request->ip(),
            ],
        ]);

        $result = json_decode($response->getBody(), true);

        if (!$result['success']) {
            return back()->withErrors(['captcha' => 'Captcha xác thực không thành công.']);
        }

        return $next($request);
    }
}
