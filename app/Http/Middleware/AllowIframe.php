<?php

namespace App\Http\Middleware;

use Closure;

class AllowIframe
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // ❗ Buang X-Frame-Options supaya boleh embed (Blogger / iframe)
        $response->headers->remove('X-Frame-Options');

        // OPTIONAL (lebih selamat): allow iframe dari Blogger sahaja
        // $response->headers->set(
        //     'Content-Security-Policy',
        //     "frame-ancestors 'self' https://*.blogspot.com https://*.googleusercontent.com;"
        // );

        return $response;
    }
}