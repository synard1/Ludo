<?php

namespace App\Http\Middleware;

use Closure;

class PreventHotlinking
{
    public function handle($request, Closure $next)
    {
        $referer = $request->headers->get('referer');

        // List of allowed domains
        $allowedDomains = ['https://ludo.my.id', 'https://dev.ludo.my.id'];

        // Check if the referrer is in the allowed domains
        if ($referer && !in_array($referer, $allowedDomains)) {
            return abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}
