<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class IsCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->user_type == 'customer') {
                return $next($request);
            } else {
                flash(localize('Please login as customer to continue'))->error();
                return redirect()->route('home');
            }
        } else {
            session(['link' => url()->current()]);
            flash(localize('Please login to continue'))->error();
            return redirect()->route('login');
        }
    }
}
