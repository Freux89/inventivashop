<?php

use App\Http\Controllers\Backend\Appearance\AboutUsPageController;
use App\Http\Controllers\Backend\Appearance\BannerSectionOneController;
use App\Http\Controllers\Backend\Appearance\BannerSectionTwoController;
use App\Http\Controllers\Backend\Appearance\BestDealProductsController;
use App\Http\Controllers\Backend\Appearance\BestSellingProductsController;
use App\Http\Controllers\Backend\Appearance\ClientFeedbackController;
use App\Http\Controllers\Backend\Appearance\FeaturedProductsController;
use App\Http\Controllers\Backend\Appearance\FooterController;
use App\Http\Controllers\Backend\Appearance\HeaderController;
use App\Http\Controllers\Backend\Appearance\HeroController;
use App\Http\Controllers\Backend\Appearance\ProductsPageController;
use App\Http\Controllers\Backend\Appearance\TopCategoriesController;
use App\Http\Controllers\Backend\Appearance\TopTrendingProductsController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\CurrenciesController;
use App\Http\Controllers\Backend\LanguageController;
use App\Http\Controllers\Backend\SettingsController;
use App\Http\Controllers\Backend\SubscribersController;
use App\Http\Controllers\Backend\CustomersController;
use App\Http\Controllers\Backend\StaffsController;
use App\Http\Controllers\Backend\Products\VariationsController;
use App\Http\Controllers\Backend\Products\VariationValuesController;
use App\Http\Controllers\Backend\Products\BrandsController;
use App\Http\Controllers\Backend\Products\UnitsController;
use App\Http\Controllers\Backend\Products\TaxesController;
use App\Http\Controllers\Backend\Products\CategoriesController;
use App\Http\Controllers\Backend\Products\ProductsController;
use App\Http\Controllers\Backend\Promotions\CouponsController;
use App\Http\Controllers\Backend\Promotions\CampaignsController;
use App\Http\Controllers\Backend\Pages\PagesController;
use App\Http\Controllers\Backend\BlogSystem\TagsController;
use App\Http\Controllers\Backend\BlogSystem\BlogCategoriesController;
use App\Http\Controllers\Backend\BlogSystem\BlogsController;
use App\Http\Controllers\Backend\Contacts\ContactUsMessagesController;
use App\Http\Controllers\Backend\Logistics\LogisticsController;
use App\Http\Controllers\Backend\Logistics\LogisticZonesController;
use App\Http\Controllers\Backend\Logistics\CountriesController;
use App\Http\Controllers\Backend\Logistics\StatesController;
use App\Http\Controllers\Backend\Logistics\CitiesController;
use App\Http\Controllers\Backend\MediaManager\MediaManagerController;
use App\Http\Controllers\Backend\Newsletters\NewslettersController;
use App\Http\Controllers\Backend\Orders\OrdersController;
use App\Http\Controllers\Backend\Stocks\StocksController;
use App\Http\Controllers\Backend\Stocks\LocationsController;
use App\Http\Controllers\Backend\Rewards\RewardsController;
use App\Http\Controllers\Backend\Refunds\RefundsController;
use App\Http\Controllers\Backend\Rewards\WalletController;
use App\Http\Controllers\Backend\OrderSettingsController;
use App\Http\Controllers\Backend\Pos\PosController;
use App\Http\Controllers\Backend\Roles\RolesController;
use App\Http\Controllers\Backend\Reports\ReportsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

# variation to create product --> also used in vendor panel
Route::group(['prefix' => 'backend'], function () {
    Route::group(['prefix' => 'products', 'middleware' => ['auth']], function () {
        Route::post('/get-variation-values', [ProductsController::class, 'getVariationValues'])->name('product.getVariationValues');
        Route::post('/new-variation', [ProductsController::class, 'getNewVariation'])->name('product.newVariation');
        Route::post('/variation-combination', [ProductsController::class, 'generateVariationCombinations'])->name('product.generateVariationCombinations');
    });

    # change settings
    Route::post('/change-currency', [CurrenciesController::class, 'changeCurrency'])->name('backend.changeCurrency');
    Route::post('/change-language', [LanguageController::class, 'changeLanguage'])->name('backend.changeLanguage');
    Route::post('/change-location', [LocationsController::class, 'changeLocation'])->name('backend.changeLocation');
});


Route::group(
    ['prefix' => 'admin', 'middleware' => ['auth', 'admin']],
    function () {
        # dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/profile', [DashboardController::class, 'profile'])->name('admin.profile');
        Route::post('/profile', [DashboardController::class, 'updateProfile'])->name('admin.profile.update');

        # auth settings 
        Route::get('/settings/auth', [SettingsController::class, 'authSettings'])->name('admin.settings.authSettings');

        # otp settings 
        Route::get('/settings/otp', [SettingsController::class, 'otpSettings'])->name('admin.settings.otpSettings');

        # settings
        Route::post('/settings/env-key-update', [SettingsController::class, 'envKeyUpdate'])->name('admin.envKey.update');
        Route::get('/settings/general-settings', [SettingsController::class, 'index'])->name('admin.generalSettings');
        Route::get('/settings/smtp-settings', [SettingsController::class, 'smtpSettings'])->name('admin.smtpSettings.index');
        Route::post('/settings/test/smtp', [SettingsController::class, 'testEmail'])->name('admin.test.smtp');
        Route::post('/settings/update', [SettingsController::class, 'update'])->name('admin.settings.update');

        #payment methods 
        Route::get('/settings/payment-methods', [SettingsController::class, 'paymentMethods'])->name('admin.settings.paymentMethods');
        Route::post('/settings/update-payment-methods', [SettingsController::class, 'updatePaymentMethods'])->name('admin.settings.updatePaymentMethods');

        #order settings
        Route::get('/settings/order-settings', [OrderSettingsController::class, 'index'])->name('admin.orderSettings');
        Route::post('/settings/add-time-slot', [OrderSettingsController::class, 'store'])->name('admin.timeslot.store');
        Route::get('/settings/edit-time-slot/{id}', [OrderSettingsController::class, 'edit'])->name('admin.timeslot.edit');
        Route::post('/settings/update-time-slot', [OrderSettingsController::class, 'update'])->name('admin.timeslot.update');
        Route::get('/settings/delete-time-slot/{id}', [OrderSettingsController::class, 'delete'])->name('admin.timeslot.delete');

        # social login
        Route::get('/settings/social-media-login', [SettingsController::class, 'socialLogin'])->name('admin.settings.socialLogin');
        Route::post('/settings/activation', [SettingsController::class, 'updateActivation'])->name('admin.settings.activation');

        # currencies  
        Route::get('/settings/currencies', [CurrenciesController::class, 'index'])->name('admin.currencies.index');
        Route::post('/settings/store-currency', [CurrenciesController::class, 'store'])->name('admin.currencies.store');
        Route::get('/settings/currencies/edit/{id}', [CurrenciesController::class, 'edit'])->name('admin.currencies.edit');
        Route::post('/settings/update-currency', [CurrenciesController::class, 'update'])->name('admin.currencies.update');
        Route::post('/settings/update-currency-status', [CurrenciesController::class, 'updateStatus'])->name('admin.currencies.updateStatus');

        # languages  
        Route::get('/settings/languages', [LanguageController::class, 'index'])->name('admin.languages.index');
        Route::post('/settings/store-language', [LanguageController::class, 'store'])->name('admin.languages.store');
        Route::get('/settings/languages/edit/{id}', [LanguageController::class, 'edit'])->name('admin.languages.edit');
        Route::post('/settings/update-language', [LanguageController::class, 'update'])->name('admin.languages.update');
        Route::post('/settings/update-language-status', [LanguageController::class, 'updateStatus'])->name('admin.languages.updateStatus');
        Route::post('/settings/update-language-default-status', [LanguageController::class, 'defaultLanguage'])->name('admin.languages.defaultLanguage');

        # localizations
        Route::get('/settings/languages/localizations/{id}', [LanguageController::class, 'showLocalizations'])->name('admin.languages.localizations');
        Route::post('/settings/languages/key-value-store', [LanguageController::class, 'key_value_store'])->name('admin.languages.key_value_store');

        # products
        Route::group(['prefix' => 'products'], function () {
            # products 
            Route::get('/', [ProductsController::class, 'index'])->name('admin.products.index');
            Route::get('/add-product', [ProductsController::class, 'create'])->name('admin.products.create');
            Route::post('/product', [ProductsController::class, 'store'])->name('admin.products.store');
            Route::get('/update-product/{id}', [ProductsController::class, 'edit'])->name('admin.products.edit');
            Route::post('/update-product', [ProductsController::class, 'update'])->name('admin.products.update');
            Route::post('/update-featured-product', [ProductsController::class, 'updateFeatured'])->name('admin.products.updateFeatureStatus');
            Route::post('/update-published-product', [ProductsController::class, 'updatePublishedStatus'])->name('admin.products.updatePublishedStatus');
            Route::get('/delete-product/{id}', [ProductsController::class, 'delete'])->name('admin.products.delete');

            # categories 
            Route::get('/category', [CategoriesController::class, 'index'])->name('admin.categories.index');
            Route::get('/add-category', [CategoriesController::class, 'create'])->name('admin.categories.create');
            Route::post('/category', [CategoriesController::class, 'store'])->name('admin.categories.store');
            Route::get('/update-category/{id}', [CategoriesController::class, 'edit'])->name('admin.categories.edit');
            Route::post('/update-category', [CategoriesController::class, 'update'])->name('admin.categories.update');
            Route::post('/update-feature-category', [CategoriesController::class, 'updateFeatured'])->name('admin.categories.updateFeatureStatus');
            Route::post('/update-top-category', [CategoriesController::class, 'updateTop'])->name('admin.categories.updateTopStatus');
            Route::get('/products/delete-category/{id}', [CategoriesController::class, 'delete'])->name('admin.categories.delete');

            # variations
            Route::get('/variations', [VariationsController::class, 'index'])->name('admin.variations.index');
            Route::post('/variation', [VariationsController::class, 'store'])->name('admin.variations.store');
            Route::get('/variations/edit/{id}', [VariationsController::class, 'edit'])->name('admin.variations.edit');
            Route::post('/variations/update', [VariationsController::class, 'update'])->name('admin.variations.update');
            Route::post('/variations/update-status', [VariationsController::class, 'updateStatus'])->name('admin.variations.updateStatus');
            Route::get('/variations/delete/{id}', [VariationsController::class, 'delete'])->name('admin.variations.delete');

            # variation values
            Route::get('/variations/{id}', [VariationValuesController::class, 'index'])->name('admin.variationValues.index');
            Route::post('/variation-values', [VariationValuesController::class, 'store'])->name('admin.variationValues.store');
            Route::get('/variations-values/edit/{id}', [VariationValuesController::class, 'edit'])->name('admin.variationValues.edit');
            Route::post('/variations-values/update', [VariationValuesController::class, 'update'])->name('admin.variationValues.update');
            Route::post('/variations-values/update-status', [VariationValuesController::class, 'updateStatus'])->name('admin.variationValues.updateStatus');
            Route::get('/variations-values/delete/{id}', [VariationValuesController::class, 'delete'])->name('admin.variationValues.delete');

            # brands
            Route::get('/brands', [BrandsController::class, 'index'])->name('admin.brands.index');
            Route::post('/brand', [BrandsController::class, 'store'])->name('admin.brands.store');
            Route::get('/brands/edit/{id}', [BrandsController::class, 'edit'])->name('admin.brands.edit');
            Route::post('/brands/update-brand', [BrandsController::class, 'update'])->name('admin.brands.update');
            Route::post('/brands/update-status', [BrandsController::class, 'updateStatus'])->name('admin.brands.updateStatus');
            Route::get('/brands/delete/{id}', [BrandsController::class, 'delete'])->name('admin.brands.delete');

            # units
            Route::get('/units', [UnitsController::class, 'index'])->name('admin.units.index');
            Route::post('/unit', [UnitsController::class, 'store'])->name('admin.units.store');
            Route::get('/units/edit/{id}', [UnitsController::class, 'edit'])->name('admin.units.edit');
            Route::post('/units/update-unit', [UnitsController::class, 'update'])->name('admin.units.update');
            Route::post('/units/update-status', [UnitsController::class, 'updateStatus'])->name('admin.units.updateStatus');
            Route::get('/units/delete/{id}', [UnitsController::class, 'delete'])->name('admin.units.delete');

            # taxes
            Route::get('/taxes', [TaxesController::class, 'index'])->name('admin.taxes.index');
            Route::post('/tax', [TaxesController::class, 'store'])->name('admin.taxes.store');
            Route::get('/taxes/edit/{id}', [TaxesController::class, 'edit'])->name('admin.taxes.edit');
            Route::post('/taxes/update', [TaxesController::class, 'update'])->name('admin.taxes.update');
            Route::post('/taxes/update-status', [TaxesController::class, 'updateStatus'])->name('admin.taxes.updateStatus');
            Route::get('/taxes/delete/{id}', [TaxesController::class, 'delete'])->name('admin.taxes.delete');
        });

        #pos 
        Route::get('/pos', [PosController::class, 'index'])->name('admin.pos.index');
        Route::post('/pos-products', [PosController::class, 'products'])->name('admin.pos.products');
        Route::post('/pos-customers', [PosController::class, 'customers'])->name('admin.pos.customers');
        Route::post('/pos-customer-info', [PosController::class, 'customerInfo'])->name('admin.pos.customerInfo');
        Route::post('/pos-new-customer', [PosController::class, 'newCustomer'])->name('admin.pos.newCustomer');
        Route::post('/add-to-pos-cart', [PosController::class, 'addToList'])->name('admin.pos.addToList');
        Route::post('/pos-product-info', [PosController::class, 'productInfo'])->name('admin.pos.productInfo');
        Route::post('/delete-from-cart', [PosController::class, 'deleteFromCart'])->name('admin.pos.deleteFromCart');
        Route::post('/handle-pos-cart-qty', [PosController::class, 'handleQty'])->name('admin.pos.handleQty');
        Route::post('/get-variation-id', [PosController::class, 'getVariationId'])->name('admin.pos.getVariationId');
        Route::post('/update-pos-summary', [PosController::class, 'updatePosSummary'])->name('admin.pos.updatePosSummary');
        Route::post('/submit-pos-order', [PosController::class, 'completeOrder'])->name('admin.pos.completeOrder');
        Route::get('/pos/invoice-download/{id}', [PosController::class, 'downloadInvoice'])->name('admin.pos.downloadInvoice');


        # orders
        Route::group(['prefix' => 'orders'], function () {
            Route::get('/', [OrdersController::class, 'index'])->name('admin.orders.index');
            Route::get('/{id}', [OrdersController::class, 'show'])->name('admin.orders.show');
            Route::post('/update-payment-status', [OrdersController::class, 'updatePaymentStatus'])->name('admin.orders.update_payment_status');
            Route::post('/update-delivery-status', [OrdersController::class, 'updateDeliveryStatus'])->name('admin.orders.update_delivery_status');
            Route::get('/invoice-download/{id}', [OrdersController::class, 'downloadInvoice'])->name('admin.orders.downloadInvoice');
        });

        # stocks
        Route::group(['prefix' => 'stocks'], function () {
            # stocks 
            Route::get('/add', [StocksController::class, 'create'])->name('admin.stocks.create');
            Route::post('/get-variation-stocks', [StocksController::class, 'getVariationStocks'])->name('admin.stocks.getVariationStocks');
            Route::post('/add', [StocksController::class, 'store'])->name('admin.stocks.store');

            # locations
            Route::get('/locations', [LocationsController::class, 'index'])->name('admin.locations.index');
            Route::get('/add-location', [LocationsController::class, 'create'])->name('admin.locations.create');
            Route::post('/add-location', [LocationsController::class, 'store'])->name('admin.locations.store');
            Route::get('/edit-location/{id}', [LocationsController::class, 'edit'])->name('admin.locations.edit');
            Route::post('/update-location', [LocationsController::class, 'update'])->name('admin.locations.update');
            Route::post('/update-default-location', [LocationsController::class, 'updateDefaultStatus'])->name('admin.locations.updateDefaultStatus');
            Route::post('/update-published-location', [LocationsController::class, 'updatePublishedStatus'])->name('admin.locations.updatePublishedStatus');
        });

        # refunds
        Route::group(['prefix' => 'refunds'], function () {
            Route::get('/', [RefundsController::class, 'configurations'])->name('admin.refund.configurations');
            Route::get('/requests', [RefundsController::class, 'requests'])->name('admin.refund.requests');
            Route::get('/approve/{id}', [RefundsController::class, 'approve'])->name('admin.refund.approve');
            Route::post('/reject/{id}', [RefundsController::class, 'reject'])->name('admin.refund.reject');

            Route::get('/refunded', [RefundsController::class, 'refunded'])->name('admin.refund.refunded');
            Route::get('/rejected', [RefundsController::class, 'rejected'])->name('admin.refund.rejected');
        });


        # rewards & wallet
        Route::group(['prefix' => 'rewards'], function () {
            # rewards 
            Route::get('/', [RewardsController::class, 'configurations'])->name('admin.rewards.configurations');
            Route::get('/set-points', [RewardsController::class, 'setPoints'])->name('admin.rewards.setPoints');
            Route::post('/store-points', [RewardsController::class, 'storePoints'])->name('admin.rewards.storePoints');
            Route::post('/store-each-product-points', [RewardsController::class, 'storeEachProductPoints'])->name('admin.rewards.storeEachProductPoints');

            # wallet
            Route::get('/wallet-configurations', [WalletController::class, 'configurations'])->name('admin.wallet.configurations');
        });

        # pages
        Route::group(['prefix' => 'pages'], function () {
            Route::get('/', [PagesController::class, 'index'])->name('admin.pages.index');
            Route::get('/add-page', [PagesController::class, 'create'])->name('admin.pages.create');
            Route::post('/add-page', [PagesController::class, 'store'])->name('admin.pages.store');
            Route::get('/edit/{id}', [PagesController::class, 'edit'])->name('admin.pages.edit');
            Route::post('/update-page', [PagesController::class, 'update'])->name('admin.pages.update');
            Route::get('/delete/{id}', [PagesController::class, 'delete'])->name('admin.pages.delete');
        });

        # customers
        Route::group(['prefix' => 'customers'], function () {
            Route::get('/', [CustomersController::class, 'index'])->name('admin.customers.index');
            Route::post('/update-banned-customer', [CustomersController::class, 'updateBanStatus'])->name('admin.customers.updateBanStatus');
        });

        # tags
        Route::get('/tags', [TagsController::class, 'index'])->name('admin.tags.index');
        Route::post('/tag', [TagsController::class, 'store'])->name('admin.tags.store');
        Route::get('/tags/edit/{id}', [TagsController::class, 'edit'])->name('admin.tags.edit');
        Route::post('/tags/update-tag', [TagsController::class, 'update'])->name('admin.tags.update');
        Route::get('/tags/delete/{id}', [TagsController::class, 'delete'])->name('admin.tags.delete');

        # blog system
        Route::group(['prefix' => 'blogs'], function () {
            # blogs
            Route::get('/', [BlogsController::class, 'index'])->name('admin.blogs.index');
            Route::get('/add-blog', [BlogsController::class, 'create'])->name('admin.blogs.create');
            Route::post('/add-blog', [BlogsController::class, 'store'])->name('admin.blogs.store');
            Route::get('/edit/{id}', [BlogsController::class, 'edit'])->name('admin.blogs.edit');
            Route::post('/update-blog', [BlogsController::class, 'update'])->name('admin.blogs.update');
            Route::post('/update-popular', [BlogsController::class, 'updatePopular'])->name('admin.blogs.updatePopular');
            Route::post('/update-status', [BlogsController::class, 'updateStatus'])->name('admin.blogs.updateStatus');
            Route::get('/delete/{id}', [BlogsController::class, 'delete'])->name('admin.blogs.delete');

            # categories
            Route::get('/categories', [BlogCategoriesController::class, 'index'])->name('admin.blogCategories.index');
            Route::post('/category', [BlogCategoriesController::class, 'store'])->name('admin.blogCategories.store');
            Route::get('/categories/edit/{id}', [BlogCategoriesController::class, 'edit'])->name('admin.blogCategories.edit');
            Route::post('/categories/update-category', [BlogCategoriesController::class, 'update'])->name('admin.blogCategories.update');
            Route::get('/categories/delete/{id}', [BlogCategoriesController::class, 'delete'])->name('admin.blogCategories.delete');
        });

        # media manager 
        Route::get('/media-manager', [MediaManagerController::class, 'index'])->name('admin.mediaManager.index');

        # bulk-emails
        Route::controller(NewslettersController::class)->group(function () {
            Route::get('/bulk-emails', 'index')->name('admin.newsletters.index');
            Route::post('/bulk-emails/send', 'sendNewsletter')->name('admin.newsletters.send');
        });

        # subscribed users
        Route::get('/subscribers', [SubscribersController::class, 'index'])->name('admin.subscribers.index');
        Route::get('/subscribers/delete/{id}', [SubscribersController::class, 'delete'])->name('admin.subscribers.delete');

        # coupons
        Route::group(['prefix' => 'coupons'], function () {
            Route::get('/', [CouponsController::class, 'index'])->name('admin.coupons.index');
            Route::get('/add-coupon', [CouponsController::class, 'create'])->name('admin.coupons.create');
            Route::post('/', [CouponsController::class, 'store'])->name('admin.coupons.store');
            Route::get('/update-coupon/{id}', [CouponsController::class, 'edit'])->name('admin.coupons.edit');
            Route::post('/update-coupon', [CouponsController::class, 'update'])->name('admin.coupons.update');
            Route::get('/delete-coupon/{id}', [CouponsController::class, 'delete'])->name('admin.coupons.delete');
        });

        # campaigns 
        Route::group(['prefix' => 'campaigns'], function () {
            Route::get('/', [CampaignsController::class, 'index'])->name('admin.campaigns.index');
            Route::get('/add-campaign', [CampaignsController::class, 'create'])->name('admin.campaigns.create');
            Route::post('/', [CampaignsController::class, 'store'])->name('admin.campaigns.store');
            Route::get('/update-campaign/{id}', [CampaignsController::class, 'edit'])->name('admin.campaigns.edit');
            Route::post('/update-campaign', [CampaignsController::class, 'update'])->name('admin.campaigns.update');
            Route::get('/delete-campaign/{id}', [CampaignsController::class, 'delete'])->name('admin.campaigns.delete');
            Route::post('/product_discount', [CampaignsController::class, 'productDiscount'])->name('admin.campaigns.productDiscount');
            Route::post('/product_discount_edit', [CampaignsController::class, 'productDiscountEdit'])->name('admin.campaigns.productDiscountEdit');
            Route::post('/update-published-status', [CampaignsController::class, 'updatePublishedStatus'])->name('admin.campaigns.updatePublishedStatus');
        });

        # logistics system
        Route::group(['prefix' => 'logistics'], function () {
            # logistics
            Route::get('/', [LogisticsController::class, 'index'])->name('admin.logistics.index');
            Route::get('/add-logistic', [LogisticsController::class, 'create'])->name('admin.logistics.create');
            Route::post('/add-logistic', [LogisticsController::class, 'store'])->name('admin.logistics.store');
            Route::get('/update-logistic/{id}', [LogisticsController::class, 'edit'])->name('admin.logistics.edit');
            Route::post('/update-logistic', [LogisticsController::class, 'update'])->name('admin.logistics.update');
            Route::post('/update-status', [LogisticsController::class, 'updateStatus'])->name('admin.logistics.updateStatus');
            Route::get('/delete-logistic/{id}', [LogisticsController::class, 'delete'])->name('admin.logistics.delete');

            # shipping zones
            Route::get('/zones', [LogisticZonesController::class, 'index'])->name('admin.logisticZones.index');
            Route::get('/add-zone', [LogisticZonesController::class, 'create'])->name('admin.logisticZones.create');
            Route::post('/add-zone', [LogisticZonesController::class, 'store'])->name('admin.logisticZones.store');
            Route::get('/update-zone/{id}', [LogisticZonesController::class, 'edit'])->name('admin.logisticZones.edit');
            Route::post('/update-zone', [LogisticZonesController::class, 'update'])->name('admin.logisticZones.update');
            Route::get('/delete-zone/{id}', [LogisticZonesController::class, 'delete'])->name('admin.logisticZones.delete');
            Route::post('/logistic-cities', [LogisticZonesController::class, 'getLogisticCities'])->name('admin.logisticZones.getLogisticCities');

            # countries
            Route::get('/countries', [CountriesController::class, 'index'])->name('admin.countries.index');
            Route::post('/update-country-status', [CountriesController::class, 'updateStatus'])->name('admin.countries.updateStatus');

            # states
            Route::get('/states', [StatesController::class, 'index'])->name('admin.states.index');
            Route::get('/add-state', [StatesController::class, 'create'])->name('admin.states.create');
            Route::post('/add-state', [StatesController::class, 'store'])->name('admin.states.store');
            Route::get('/update-state/{id}', [StatesController::class, 'edit'])->name('admin.states.edit');
            Route::post('/update-state', [StatesController::class, 'update'])->name('admin.states.update');
            Route::post('/update-state-status', [StatesController::class, 'updateStatus'])->name('admin.states.updateStatus');

            # cities
            Route::get('/cities', [CitiesController::class, 'index'])->name('admin.cities.index');
            Route::get('/add-city', [CitiesController::class, 'create'])->name('admin.cities.create');
            Route::post('/add-city', [CitiesController::class, 'store'])->name('admin.cities.store');
            Route::get('/update-city/{id}', [CitiesController::class, 'edit'])->name('admin.cities.edit');
            Route::post('/update-city', [CitiesController::class, 'update'])->name('admin.cities.update');
            Route::post('/update-city-status', [CitiesController::class, 'updateStatus'])->name('admin.cities.updateStatus');
        });

        # roles & permissions
        Route::group(['prefix' => 'roles'], function () {
            Route::get('/', [RolesController::class, 'index'])->name('admin.roles.index');
            Route::get('/add-role', [RolesController::class, 'create'])->name('admin.roles.create');
            Route::post('/add-role', [RolesController::class, 'store'])->name('admin.roles.store');
            Route::get('/update-role/{id}', [RolesController::class, 'edit'])->name('admin.roles.edit');
            Route::post('/update-role', [RolesController::class, 'update'])->name('admin.roles.update');
            Route::get('/delete-role/{id}', [RolesController::class, 'delete'])->name('admin.roles.delete');
        });

        # reports
        Route::group(['prefix' => 'reports'], function () {
            Route::get('/product-sales', [ReportsController::class, 'index'])->name('admin.reports.sales');
            Route::get('/orders', [ReportsController::class, 'orders'])->name('admin.reports.orders');
            Route::get('/category-wise-sales', [ReportsController::class, 'categoryWise'])->name('admin.reports.categorySales');
            Route::get('/sales-amount-report', [ReportsController::class, 'amountWise'])->name('admin.reports.salesAmount');
            Route::get('/delivery-status-report', [ReportsController::class, 'deliveryStatus'])->name('admin.reports.deliveryStatus');
        });

        # contact us message
        Route::group(['prefix' => 'contacts'], function () {
            Route::get('/', [ContactUsMessagesController::class, 'index'])->name('admin.queries.index');
            Route::get('/mark-as-read/{id}', [ContactUsMessagesController::class, 'read'])->name('admin.queries.markRead');
        });


        # appearance
        Route::group(['prefix' => 'appearance'], function () {

            # homepage - hero
            Route::get('/homepage/hero', [HeroController::class, 'hero'])->name('admin.appearance.homepage.hero');
            Route::post('/homepage/hero', [HeroController::class, 'storeHero'])->name('admin.appearance.homepage.storeHero');
            Route::get('/homepage/hero/edit/{id}', [HeroController::class, 'edit'])->name('admin.appearance.homepage.editHero');
            Route::post('/homepage/hero/update', [HeroController::class, 'update'])->name('admin.appearance.homepage.updateHero');
            Route::get('/homepage/hero/delete/{id}', [HeroController::class, 'delete'])->name('admin.appearance.homepage.deleteHero');

            # homepage - top category 
            Route::get('/homepage/top-category', [TopCategoriesController::class, 'index'])->name('admin.appearance.homepage.topCategories');

            # homepage - featured products 
            Route::get('/homepage/featured-products', [FeaturedProductsController::class, 'index'])->name('admin.appearance.homepage.featuredProducts');

            # homepage - top trending products 
            Route::get('/homepage/trending-products', [TopTrendingProductsController::class, 'index'])->name('admin.appearance.homepage.topTrendingProducts');
            Route::post('/homepage/get-products-for-trending', [TopTrendingProductsController::class, 'getProducts'])->name('admin.appearance.homepage.getProducts');

            # homepage - banner section one
            Route::get('/homepage/banner-section-one', [BannerSectionOneController::class, 'index'])->name('admin.appearance.homepage.bannerOne');
            Route::post('/homepage/banner-section-one', [BannerSectionOneController::class, 'storeBannerOne'])->name('admin.appearance.homepage.storeBannerOne');
            Route::get('/homepage/banner-section-one/edit/{id}', [BannerSectionOneController::class, 'edit'])->name('admin.appearance.homepage.editBannerOne');
            Route::post('/homepage/banner-section-one/update', [BannerSectionOneController::class, 'update'])->name('admin.appearance.homepage.updateBannerOne');
            Route::get('/homepage/banner-section-one/delete/{id}', [BannerSectionOneController::class, 'delete'])->name('admin.appearance.homepage.deleteBannerOne');

            # homepage - best deals products 
            Route::get('/homepage/best-deal-products', [BestDealProductsController::class, 'index'])->name('admin.appearance.homepage.bestDeals');

            # homepage - banner section two
            Route::get('/homepage/banner-section-two', [BannerSectionTwoController::class, 'index'])->name('admin.appearance.homepage.bannerTwo');

            # client feedback
            Route::get('/homepage/client-feedback', [ClientFeedbackController::class, 'index'])->name('admin.appearance.homepage.clientFeedback');
            Route::post('/homepage/client-feedback', [ClientFeedbackController::class, 'store'])->name('admin.appearance.homepage.storeClientFeedback');
            Route::get('/homepage/client-feedback/edit/{id}', [ClientFeedbackController::class, 'edit'])->name('admin.appearance.homepage.editClientFeedback');
            Route::post('/homepage/client-feedback/update', [ClientFeedbackController::class, 'update'])->name('admin.appearance.homepage.updateClientFeedback');
            Route::get('/homepage/client-feedback/delete/{id}', [ClientFeedbackController::class, 'delete'])->name('admin.appearance.homepage.deleteClientFeedback');

            # homepage - best selling products 
            Route::get('/homepage/best-selling-products', [BestSellingProductsController::class, 'index'])->name('admin.appearance.homepage.bestSelling');

            # products - listing
            Route::get('/homepage/products', [ProductsPageController::class, 'index'])->name('admin.appearance.products.index');

            # products - details
            Route::get('/homepage/products-details', [ProductsPageController::class, 'details'])->name('admin.appearance.products.details');
            Route::post('/homepage/products-details', [ProductsPageController::class, 'storeWidget'])->name('admin.appearance.products.details.storeWidget');
            Route::get('/homepage/products-details/edit/{id}', [ProductsPageController::class, 'edit'])->name('admin.appearance.products.details.editWidget');
            Route::post('/homepage/products-details/update', [ProductsPageController::class, 'update'])->name('admin.appearance.products.details.updateWidget');
            Route::get('/homepage/products-details/delete/{id}', [ProductsPageController::class, 'delete'])->name('admin.appearance.products.details.deleteWidget');

            # about us - intro
            Route::get('/about-us', [AboutUsPageController::class, 'index'])->name('admin.appearance.about-us.index');

            # about us - popular brands
            Route::get('/about-us/popular-brands', [AboutUsPageController::class, 'popularBrands'])->name('admin.appearance.about-us.popularBrands');

            # about us - features
            Route::get('/about-us/features', [AboutUsPageController::class, 'features'])->name('admin.appearance.about-us.features');
            Route::post('/about-us/features', [AboutUsPageController::class, 'storeFeatures'])->name('admin.appearance.about-us.storeFeatures');
            Route::get('/about-us/features/edit/{id}', [AboutUsPageController::class, 'edit'])->name('admin.appearance.about-us.editFeatures');
            Route::post('/about-us/features/update', [AboutUsPageController::class, 'update'])->name('admin.appearance.about-us.updateFeatures');
            Route::get('/about-us/features/delete/{id}', [AboutUsPageController::class, 'delete'])->name('admin.appearance.about-us.deleteFeatures');

            # about us - why choose us
            Route::get('/about-us/why-choose-us', [AboutUsPageController::class, 'whyChooseUs'])->name('admin.appearance.about-us.whyChooseUs');
            Route::post('/about-us/why-choose-us', [AboutUsPageController::class, 'storeWhyChooseUs'])->name('admin.appearance.about-us.storeWhyChooseUs');
            Route::get('/about-us/why-choose-us/edit/{id}', [AboutUsPageController::class, 'editWhyChooseUs'])->name('admin.appearance.about-us.editWhyChooseUs');
            Route::post('/about-us/why-choose-us/update', [AboutUsPageController::class, 'updateWhyChooseUs'])->name('admin.appearance.about-us.updateWhyChooseUs');
            Route::get('/about-us/why-choose-us/delete/{id}', [AboutUsPageController::class, 'deleteWhyChooseUs'])->name('admin.appearance.about-us.deleteWhyChooseUs');

            # header
            Route::get('/header', [HeaderController::class, 'index'])->name('admin.appearance.header');

            # footer
            Route::get('/footer', [FooterController::class, 'index'])->name('admin.appearance.footer');
        });

        # staffs
        Route::group(['prefix' => 'staffs'], function () {
            Route::get('/', [StaffsController::class, 'index'])->name('admin.staffs.index');
            Route::get('/add-staff', [StaffsController::class, 'create'])->name('admin.staffs.create');
            Route::post('/add-staff', [StaffsController::class, 'store'])->name('admin.staffs.store');
            Route::get('/update-staff/{id}', [StaffsController::class, 'edit'])->name('admin.staffs.edit');
            Route::post('/update-staff', [StaffsController::class, 'update'])->name('admin.staffs.update');
            Route::get('/delete-staff/{id}', [StaffsController::class, 'delete'])->name('admin.staffs.delete');
        });
    }
);
