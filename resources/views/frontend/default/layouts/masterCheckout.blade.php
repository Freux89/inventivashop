<!DOCTYPE html>
@php
    $locale = str_replace('_', '-', app()->getLocale()) ?? 'en';
    $localLang = \App\Models\Language::where('code', $locale)->first();
@endphp
@if ($localLang->is_rtl == 1)
    <html dir="rtl" lang="{{ $locale }}" data-bs-theme="light">
@else
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
@endif

<head>
    <!--required meta tags-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--meta-->
    <meta name="robots" content="index, follow">
    <meta name="description" content="{{ getSetting('global_meta_description') }}">
    <meta name="keywords" content="{{ getSetting('global_meta_keywords') }}">

    <!--favicon icon-->
    <link rel="icon" href="{{ uploadedAsset(getSetting('favicon')) }}" type="image/png" sizes="16x16">

    <!--title-->
    <title>
        @yield('title', getSetting('system_title'))
    </title>

    @yield('meta')

    

    <!-- head-scripts -->
    @include('frontend.default.inc.head-scripts')
    <!-- head-scripts -->

    <!--build:css-->
    @include('frontend.default.inc.css', ['localLang' => $localLang])
    <!-- endbuild --> 
    @yield('styles')
    <!-- PWA  -->
    <meta name="theme-color" content="#6eb356"/>
    <link rel="apple-touch-icon" href="{{ staticAsset('/icon.png') }}"/>
    <link rel="manifest" href="{{ staticAsset('/manifest.json') }}"/>

</head>

<body class="checkout">

    @php
        // for visitors to add to cart
        $tempValue = strtotime('now') . rand(10, 1000);
        $theTime = time() + 86400 * 365;
        if (!isset($_COOKIE['guest_user_id'])) {
            setcookie('guest_user_id', $tempValue, $theTime, '/'); // 86400 = 1 day
        }
        
    @endphp

    <!--preloader start-->
    <div id="preloader">
        <img src="{{ staticAsset('frontend/default/assets/img/preloader.gif') }}" alt="preloader" class="img-fluid">
    </div>
    <!--preloader end-->

    <!--main content wrapper start-->
    <div class="main-wrapper">
        <!--header section start-->
       
         
        @include('frontend.default.inc.headerCheckout')
       
        
        @yield('contents')

        <!-- modals -->
        @include('frontend.default.pages.partials.products.quickViewModal')
        <!-- modals -->


        

        <!--footer section end-->
        <div class="menu-overlay"></div>
    </div>


    <!--scroll bottom to top button start-->
    <button class="scroll-top-btn">
        <i class="fa-regular fa-hand-pointer"></i></button>
        <!--scroll bottom to top button end-->

        <!--build:js-->
        @include('frontend.default.inc.scripts')
        <!--endbuild-->

        <!--page's scripts-->
        @yield('scripts')
        <!--page's script-->

        <!--for pwa-->
        <script src="{{ staticAsset('/sw.js') }}"></script>
        <script>
            if (!navigator.serviceWorker?.controller) {
                navigator.serviceWorker?.register("./sw.js").then(function(reg) {
                    console.log("Service worker has been registered for scope: " + reg.scope);
                });
            }
        </script>
        <!--for pwa-->
        
        </body>

        </html>
