<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


        if (!in_array($request->lang, config('app.locales'))) {
;
            $segments = $request->segments();
            $segments[1] = config('app.fallback_locale');

            return redirect()->to(implode('/', $segments));
        }
        //$request->except(0);
        app()->setLocale($request->lang);

        return $next($request);
    }
}
