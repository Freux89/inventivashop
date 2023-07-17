<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class CurrencyMiddleware
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
        if (Session::has('currency_code')) {
            // do nothing
        } elseif (env('DEFAULT_CURRENCY') != null) {
            $request->session()->put('currency_code',  env('DEFAULT_CURRENCY'));
            $request->session()->put('local_currency_rate',  env('DEFAULT_CURRENCY_RATE'));
            $request->session()->put('currency_symbol',  env('DEFAULT_CURRENCY_SYMBOL'));
            $request->session()->put('currency_symbol_alignment', env('DEFAULT_CURRENCY_SYMBOL_ALIGNMENT'));
        } else {
            $request->session()->put('currency_code',  "usd");
            $request->session()->put('local_currency_rate', 1);
            $request->session()->put('currency_symbol', '$');
            $request->session()->put('currency_symbol_alignment', 0);
        }
        return $next($request);
    }
}
