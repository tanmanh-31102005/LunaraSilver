<?php

namespace App\Http\Middleware;

use App\Models\SeoRedirect;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SeoRedirectMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->isMethodSafe()) {
            return $next($request);
        }

        try {
            $path = SeoRedirect::normalizePath($request->getPathInfo());

            $redirect = SeoRedirect::query()->where('old_path', $path)->first();

            if ($redirect) {
                $target = $redirect->new_path;
                $query = $request->getQueryString();

                if ($query) {
                    $separator = str_contains($target, '?') ? '&' : '?';
                    $target .= $separator.$query;
                }

                return redirect($target, $redirect->status_code);
            }
        } catch (\Throwable $e) {
            // Silently fall through if table doesn't exist during early bootstrap
        }

        return $next($request);
    }
}
