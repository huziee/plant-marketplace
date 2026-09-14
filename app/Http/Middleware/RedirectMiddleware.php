<?php

namespace App\Http\Middleware;

use App\Models\UrlRedirect;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectMiddleware
{
    /**
     * Handle an incoming request and redirect if a database URL redirect is present.
     * Prevents redirect loops and ensures proper 301/302 HTTP status codes.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $pathInfo = $request->getPathInfo();
        $pathWithSlash = '/' . ltrim($pathInfo, '/');
        $pathNoSlash = ltrim($pathInfo, '/');

        // Check if redirect rule exists for current path (with or without leading slash)
        $redirect = UrlRedirect::whereIn('old_url', [$pathWithSlash, $pathNoSlash])->first();

        if ($redirect) {
            $destination = $redirect->new_url;

            // Prevent self-referential loop
            if ($destination === $pathWithSlash || $destination === $pathNoSlash || $destination === $request->fullUrl()) {
                return $next($request);
            }

            // Follow redirect chains up to 5 steps to find final destination and avoid multi-hop chains
            $currentDest = $destination;
            $steps = 0;
            while ($steps < 5) {
                $nextRedirect = UrlRedirect::whereIn('old_url', ['/' . ltrim($currentDest, '/'), ltrim($currentDest, '/')])->first();
                if (!$nextRedirect || $nextRedirect->new_url === $currentDest) {
                    break;
                }
                $currentDest = $nextRedirect->new_url;
                $steps++;
            }

            $statusCode = in_array((int) $redirect->status_code, [301, 302, 307, 308]) ? (int) $redirect->status_code : 301;

            return redirect($currentDest, $statusCode);
        }

        return $next($request);
    }
}
