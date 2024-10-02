<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Menu;
use App\Models\Product;
use App\Models\Variation;
use App\Models\VariationValue;
use App\Models\Material;
use App\Models\Template;
use App\Models\QuantityDiscount;
use App\Models\QuantityDiscountTier;
use App\Observers\PriceRelatedObserver;
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
        Product::observe(PriceRelatedObserver::class);
        Variation::observe(PriceRelatedObserver::class);
        VariationValue::observe(PriceRelatedObserver::class);
        Material::observe(PriceRelatedObserver::class);
        Template::observe(PriceRelatedObserver::class);
        QuantityDiscount::observe(PriceRelatedObserver::class);
        QuantityDiscountTier::observe(PriceRelatedObserver::class);
        $this->composeCartData();


        $this->composeMenu();

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

    protected function composeMenu()
    {
         // Componi la vista con il menu principale
         View::composer('frontend.default.inc.menu', function ($view) {
            $menu = Menu::with([
                'items' => function ($query) {
                    $query->orderBy('position');
                },
                'items.columns' => function ($query) {
                    $query->orderBy('position');
                },
                'items.columns.items' => function ($query) {
                    $query->orderBy('position');
                }
            ])->where('is_main', true)->first();

            $view->with('menu', $menu);
        });

    }
    
}
