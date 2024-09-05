<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">

<head>
    <!--required meta tags-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--favicon icon-->
    <link rel="shortcut icon" href="{{ staticAsset('backend/assets/img/favicon.png') }}">

    <!--title-->
    <title>
        @yield('title')
    </title>

    <!--build:css-->
    @include('backend.inc.styles')
    <link rel="stylesheet" href="https://kit-free.fontawesome.com/releases/v6.4.2/css/free.min.css" media="all">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css"/>
    <!-- end build -->
    @yield('extra-head')

</head>

<body>
    <!--preloader start-->
    <div id="preloader" class="bg-light-subtle">
        <div class="preloader-wrap">
            <img src="{{ uploadedAsset(getSetting('navbar_logo')) }}" class="img-fluid">
            <div class="loading-bar"></div>
        </div>
    </div>
    <!--preloader end-->

    <!--sidebar section start-->
    @if (!Route::is('admin.pos.index'))
        @include('backend.inc.leftSidebar')
    @endif
    <!--sidebar section end-->

    <!--main content wrapper start-->
    <main class="tt-main-wrapper bg-secondary-subtle"
        @if (!Route::is('admin.pos.index')) id="content" @else  id="pos-content" @endif>
        <!--header section start-->
        @include('backend.inc.navbar')
        <!--header section end-->

        <!-- Start Content-->
        @yield('contents')
        <!-- container -->

        <!--footer section start-->
        @if (!Route::is('admin.pos.index'))
            @include('backend.inc.footer')
        @endif
        <!--footer section end-->

        <!-- media-manager -->
        @include('backend.inc.media-manager.media-manager')

    </main>
    <!--main content wrapper end-->

    <!-- delete modal -->
    @include('backend.inc.deleteModal')

    <!--build:js-->
    @include('backend.inc.scripts')
    <!--endbuild-->

    <!-- scripts from different pages -->
    @yield('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr@1.8.2/dist/pickr.min.js"></script>
    <!-- required scripts -->
    <script>
        "use strict";

        // change language
        function changeLocaleLanguage(e) {
            var locale = e.dataset.flag;
            $.post("{{ route('backend.changeLanguage') }}", {
                _token: '{{ csrf_token() }}',
                locale: locale
            }, function(data) {
                location.reload();
            });
        }


        // change currency
        function changeLocaleCurrency(e) {
            var currency_code = e.dataset.currency;
            $.post("{{ route('backend.changeCurrency') }}", {
                _token: '{{ csrf_token() }}',
                currency_code: currency_code
            }, function(data) {
                location.reload();
            });
        }

        // change location
        function changeLocation(e) {
            var text = '{{ localize('If you change the location your cart will be cleared. Do you want to proceed?') }}'
            var confirm = window.confirm(text);
            if (confirm) {
                var location_id = e.dataset.location;
                $.post("{{ route('backend.changeLocation') }}", {
                    _token: '{{ csrf_token() }}',
                    location_id: location_id
                }, function(data) {
                    location.reload();
                });
            }
        }

        // localize data
        function localizeData(langKey) {
            window.location = '{{ url()->current() }}?lang_key=' + langKey + '&localize';
        }

        // ajax toast 
        function notifyMe(level, message) {
            if (level == 'danger') {
                level = 'error';
            }
            toastr.options = {
                closeButton: true,
                newestOnTop: false,
                progressBar: true,
                positionClass: "toast-top-center",
                preventDuplicates: false,
                onclick: null,
                showDuration: "3000",
                hideDuration: "1000",
                timeOut: "5000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
            };
            toastr[level](message);
        }

        //laravel flash toast messages 
        @foreach (session('flash_notification', collect())->toArray() as $message)
            notifyMe("{{ $message['level'] }}", "{{ $message['message'] }}");
        @endforeach


        

    </script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const colorPickers = document.querySelectorAll('.color-picker-button');

        colorPickers.forEach(pickerElement => {
            const id = pickerElement.getAttribute('data-id');
            const inputElement = document.getElementById(id);

            const pickr = Pickr.create({
                el: pickerElement,
                theme: 'classic', // classic, monolith, nano
                default: inputElement.value,
                swatches: [
                    '#C9AC20', '#4E838E', '#289BB1', '#801854',
                    '#D4F3F9', '#EAEAEA', '#DADADA', '#FFF2CE',
                    '#98C0C6', '#9BA3A4', '#DAD0A6', '#9A7785', '#e7eeef',
                    '#580830', '#a18110', '#105862', '#007480',
                    '#404647', '#f4f8f8', '#ffffff', '#000000'
                ],
                components: {
                    // Main components
                    preview: true,
                    opacity: true,
                    hue: true,

                    // Input / output Options
                    interaction: {
                        input: true,
                        save: true
                    }
                }
            });

            // Aggiorna il colore al cambiamento
            pickr.on('change', (color, source, instance) => {
                inputElement.value = color.toHEXA().toString();
                pickerElement.style.backgroundColor = color.toHEXA().toString();
            });

            // Chiudi la finestra di selezione del colore dopo aver cliccato su "Save"
            pickr.on('save', (color, instance) => {
                instance.hide(); // Chiude la finestra
            });
        });
    });
</script>

    @yield('extra-script-footer')
</body>

</html>
