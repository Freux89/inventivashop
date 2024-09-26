<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FrontendMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->is('admin/*') && !$request->is('backend/*')) {
            app()->instance('isFrontend', true);
        } else {
            app()->instance('isFrontend', false);
        }
    

        return $next($request);
    }
}
