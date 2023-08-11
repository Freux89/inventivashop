<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use Illuminate\Support\Facades\View;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        $this->composeCartData();
    }
    
    protected function composeCartData()
    {
        View::composer('*', function ($view) {
            $carts = [];
            if (Auth::check()) {
                $carts = Cart::where('user_id', Auth::user()->id)
                    ->where('location_id', session('stock_location_id'))
                    ->get();
            } else {
                if (isset($_COOKIE['guest_user_id'])) {
                    $carts = Cart::where('guest_user_id', (int) $_COOKIE['guest_user_id'])
                        ->where('location_id', session('stock_location_id'))
                        ->get();
                }
            }
            
            // Condividi la variabile $carts con tutte le viste
            $view->with('carts', $carts);
        });
    }


    
}
