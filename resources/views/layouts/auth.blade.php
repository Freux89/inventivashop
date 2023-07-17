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
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--favicon icon-->
    <link rel="icon" href="{{ staticAsset('frontend/default/assets/img/favicon.png') }}" type="image/png"
        sizes="16x16">

    <!--title-->
    <title>
        @yield('title')
    </title>

    <!--build:css-->
    @include('frontend.default.inc.css')
    <!-- endbuild -->


    <!-- recaptcha -->
    @if (getSetting('enable_recaptcha') == 1)
        <!-- Include script -->
        <script type="text/javascript">
            function callbackThen(response) {

                // read Promise object
                response.json().then(function(data) {
                    // console.log(data);
                    if (data.success && data.score >= 0.6) {
                        // console.log('valid recaptcha');
                    } else {
                        document.getElementById('login-form').addEventListener('submit', function(event) {
                            event.preventDefault();
                            notifyMe("error", 'Google recaptcha error')
                        });
                    }
                });
            }

            function callbackCatch(error) {
                console.error('Error:', error)
            }
        </script>

        {!! htmlScriptTagJsApi([
            'callback_then' => 'callbackThen',
            'callback_catch' => 'callbackCatch',
        ]) !!}
    @endif
    <!-- recaptcha -->

</head>

<body>

    <!--preloader start-->
    <div id="preloader">
        <div id="status"></div>
    </div>
    <!--preloader end-->

    <!--main content wrapper start-->
    <div class="main-wrapper">

        @yield('contents')

    </div>


    <!-- scripts -->
    @yield('scripts')

    <!--build:js-->
    @include('frontend.default.inc.scripts')
    <!--endbuild-->
</body>

</html>
