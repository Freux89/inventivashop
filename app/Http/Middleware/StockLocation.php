<?php

namespace App\Http\Middleware;

use App\Models\Location;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Session;

class StockLocation
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
        if (Route::has('home')) {
            if (Session::has('stock_location_id')) {
                // do nothing
            } else {
                $location = Location::where('is_default', 1)->first();
                $request->session()->put('stock_location_id',  $location->id);
            }
        } else {
            $request->session()->put('stock_location_id',  1);
        }
        return $next($request);
    }
}
