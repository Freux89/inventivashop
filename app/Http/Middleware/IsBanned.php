<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class IsBanned
{
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->is_banned) {

            $redirect_to = "";
            if (auth()->user()->user_type == 'admin' || auth()->user()->user_type == 'staff') {
                $redirect_to = "login";
            } else {
                $redirect_to = "home";
            }

            auth()->logout();

            flash(localize("You have been banned"))->error();

            return redirect()->route($redirect_to);
        }

        return $next($request);
    }
}
