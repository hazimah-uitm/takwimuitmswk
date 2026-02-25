<?php

namespace App\Http\Middleware;

use Closure;

class AllowIframe
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set(
            'Content-Security-Policy',
            "frame-ancestors 'self' https://sarawak.uitm.edu.my"
        );

        $response->headers->remove('X-Frame-Options');

        return $response;
    }
}