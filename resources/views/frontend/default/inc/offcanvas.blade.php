<div class="offcanvas_menu position-fixed">
    <div class="tt-short-info d-none d-md-none d-lg-none d-xl-block">
        <button class="offcanvas-close"><i class="fa-solid fa-xmark"></i></button>
        <a href="{{ route('home') }}" class="logo-wrapper d-inline-block mb-5"><img
                src="{{ uploadedAsset(getSetting('navbar_logo')) }}" alt="logo"></a>
        <div class="offcanvas-content">
            <h4 class="mb-4">{{ 'About Us' }}</h4>
            <p>{{ getSetting('about_us') }}</p>
            <a href="{{ route('home.pages.aboutUs') }}" class="btn btn-primary mt-4">{{ 'About Us' }}</a>
        </div>
    </div>

    <div class="mobile-menu d-md-block d-lg-block d-xl-none mb-4">
        <button class="offcanvas-close"><i class="fa-solid fa-xmark"></i></button>

        <nav class="mobile-menu-wrapperoffcanvas-contact">
            <ul>
                <li>
                    <a href="{{ route('home') }}">{{ localize('Home') }}</a>
                </li>
                <li>
                    <a href="{{ route('products.index') }}">{{ localize('Products') }}</a>
                </li>
                <li>
                    <a href="{{ route('home.campaigns') }}">{{ localize('Campaigns') }}</a>
                </li>
                <li>
                    <a href="{{ route('home.coupons') }}">{{ localize('Coupons') }}</a>
                </li>
                <li class="has-submenu">
                    <a href="javascript:void(0)">{{ localize('Pages') }}<span class="ms-1 fs-xs float-end"><i
                                class="fa-solid fa-angle-right"></i></span></a>
                    <ul>
                        @php
                            $pages = [];
                            if (getSetting('navbar_pages') != null) {
                                $pages = \App\Models\Page::whereIn('id', json_decode(getSetting('navbar_pages')))->get();
                            }
                        @endphp

                        <li><a href="{{ route('home.blogs') }}">{{ localize('Blogs') }}</a></li>
                        <li><a href="{{ route('home.pages.aboutUs') }}">{{ localize('About Us') }}</a></li>
                        <li><a href="{{ route('home.pages.contactUs') }}">{{ localize('Contact Us') }}</a></li>
                        @foreach ($pages as $navbarPage)
                            <li><a
                                    href="{{ route('home.pages.show', $navbarPage->slug) }}">{{ $navbarPage->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                @php
                    if (Session::has('locale')) {
                        $locale = Session::get('locale', Config::get('app.locale'));
                    } else {
                        $locale = env('DEFAULT_LANGUAGE');
                    }
                    $currentLanguage = \App\Models\Language::where('code', $locale)->first();
                    
                    if ($currentLanguage == null) {
                        $currentLanguage = \App\Models\Language::where('code', 'en')->first();
                    }
                @endphp

                <li class="has-submenu">
                    <a href="javascript:void(0)">{{ $currentLanguage->name }}<span class="ms-1 fs-xs float-end"><i
                                class="fa-solid fa-angle-right"></i></span></a>
                    <ul>
                        @foreach (\App\Models\Language::where('is_active', 1)->get() as $key => $language)
                            <li>
                                <a href="javascript:void(0);" onclick="changeLocaleLanguage(this)"
                                    data-flag="{{ $language->code }}">
                                    {{ $language->name }}
                                </a>
                            </li>
                        @endforeach

                    </ul>
                </li>



                @php
                    if (Session::has('currency_code')) {
                        $currency_code = Session::get('currency_code', Config::get('app.currency_code'));
                    } else {
                        $currency_code = env('DEFAULT_CURRENCY');
                    }
                    $currentCurrency = \App\Models\Currency::where('code', $currency_code)->first();
                    
                    if ($currentCurrency == null) {
                        $currentCurrency = \App\Models\Currency::where('code', 'usd')->first();
                    }
                @endphp

                <li class="has-submenu">
                    <a href="javascript:void(0)" class="text-uppercase">{{ $currentCurrency->symbol }}
                        {{ $currentCurrency->code }}<span class="ms-1 fs-xs float-end"><i
                                class="fa-solid fa-angle-right"></i></span></a>
                    <ul>
                        @foreach (\App\Models\Currency::where('is_active', 1)->get() as $key => $currency)
                            <li>
                                <a class="text-uppercase" href="javascript:void(0);"
                                    onclick="changeLocaleCurrency(this)" data-currency="{{ $currency->code }}">
                                    {{ $currency->symbol }} {{ $currency->code }}
                                </a>
                            </li>
                        @endforeach

                    </ul>
                </li>

                @auth
                    <li>
                        <a href="{{ route('logout') }}">{{ localize('Sign Out') }}</a>
                    </li>
                @endauth
                @guest
                    <li>
                        <a href="{{ route('login') }}">{{ localize('Sign In') }}</a>
                    </li>
                @endguest
            </ul>
        </nav>

    </div>

    <div class="offcanvas-contact mt-4">
        <h5 class="mb-4 mt-5">{{ 'Contact Info' }}</h5>
        <address>
            {{ getSetting('topbar_location') }} <br>
            <a href="tel:{{ getSetting('navbar_contact_number') }}">{{ getSetting('navbar_contact_number') }}</a> <br>
            <a href="mailto:{{ getSetting('topbar_email') }}">{{ getSetting('topbar_email') }}</a>
        </address>
    </div>
    <div class="offcanvas-contact social-contact mt-4">
        <a href="{{ getSetting('facebook_link') }}" target="_blank" class="social-btn"><i
                class="fab fa-facebook-f"></i></a>
        <a href="{{ getSetting('twitter_link') }}" target="_blank" class="social-btn"><i
                class="fab fa-twitter"></i></a>
        <a href="{{ getSetting('linkedin_link') }}" target="_blank" class="social-btn"><i
                class="fab fa-linkedin"></i></a>
        <a href="{{ getSetting('youtube_link') }}" target="_blank" class="social-btn"><i
                class="fab fa-youtube"></i></a>
    </div>
</div>
