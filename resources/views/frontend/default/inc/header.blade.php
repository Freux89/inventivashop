<header class="gheader position-relative z-2 header-sticky pb-6 pb-lg-0">
    
    <div class="ghead-topbar bg-gray d-none d-lg-block">
        <div class="content-wrapper">
            <div class="row align-items-center m-0">
                <div class="col-12 p-0">
                    <div class="topbar-nav fw-bold">
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link ps-0" href="#">FAQ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Blog</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Servizi di grafica</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Preventivo personalizzato</a>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- <div class="col-xxl-8 col-xl-9">

                    <ul class="d-flex align-items-center justify-content-center justify-content-xl-end topbar-info-right">
                        <li class="nav-item">
                            <a href="mailto:{{ getSetting('topbar_email') }}">
                <span class="me-1">
                    <svg width="16" height="14" viewBox="0 0 20 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.2422 0H1.75781C0.790547 0 0 0.783572 0 1.75V12.25C0 13.2168 0.791055 14 1.75781 14H18.2422C19.2095 14 20 13.2164 20 12.25V1.75C20 0.783339 19.2091 0 18.2422 0ZM17.9723 1.16667C17.4039 1.73433 10.7283 8.40194 10.4541 8.67588C10.225 8.90462 9.77512 8.90478 9.54594 8.67588L2.02773 1.16667H17.9723ZM1.17188 12.0355V1.96447L6.21348 7L1.17188 12.0355ZM2.02773 12.8333L7.04078 7.82631L8.71598 9.49951C9.40246 10.1852 10.5978 10.1849 11.2841 9.49951L12.9593 7.82635L17.9723 12.8333H2.02773ZM18.8281 12.0355L13.7865 7L18.8281 1.96447V12.0355Z" fill="white" />
                    </svg>
                </span>
                {{ getSetting('topbar_email') }}
                </a>
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

                <li class="nav-item dropdown tt-language-dropdown">
                    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <img src="{{ staticAsset('backend/assets/img/flags/' . $currentLanguage->flag . '.png') }}" alt="country" class="img-fluid me-1"> {{ $currentLanguage->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end">

                        @foreach (\App\Models\Language::where('is_active', 1)->get() as $key => $language)
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);" onclick="changeLocaleLanguage(this)" data-flag="{{ $language->code }}">
                                <img src="{{ staticAsset('backend/assets/img/flags/' . $language->flag . '.png') }}" alt="country" class="img-fluid me-1">
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

                <li class="nav-item dropdown tt-curency-dropdown">
                    <a href="#" class="dropdown-toggle text-uppercase" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $currentCurrency->symbol }}
                        {{ $currentCurrency->code }}</a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @foreach (\App\Models\Currency::where('is_active', 1)->get() as $key => $currency)
                        <li>
                            <a class="dropdown-item fs-xs text-uppercase" href="javascript:void(0);" onclick="changeLocaleCurrency(this)" data-currency="{{ $currency->code }}">
                                {{ $currency->symbol }} {{ $currency->code }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="javascript:void(0)" class="btn btn-link p-0 tt-theme-toggle fw-normal">
                        <div class="tt-theme-light" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Dark">{{ localize('Dark') }} <i class="fas fa-moon fs-lg ms-1"></i>
                        </div>
                        <div class="tt-theme-dark" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Light">{{ localize('Light') }} <i class="fas fa-sun fs-lg ms-1"></i>
                        </div>
                    </a>
                </li>
                </ul>
            </div> --}}
        </div>
    </div>
    </div>
    <div class="content-wrapper">
        <div class="gshop-navbar rounded position-relative pt-6 px-2 px-md-0">
            <div class="row align-items-center justify-content-between m-0">
<div class="mobile-nav-icon col-4 d-block d-md-none">
          <a class="" href="#">
            <span class="fa fa-bars"></span>
          </a>
</div>
                <div class="col-xxl-2 col-xl-3 col-md-3 col-4 p-0">
                    <a href="{{ route('home') }}" class="logo">
                        <img src="{{ uploadedAsset(getSetting('navbar_logo')) }}" alt="logo" class="img-fluid logo-light">
                        <!-- <img src="{{ asset('public/frontend/default/assets/img/logo-dark.svg') }}" alt="logo" class="img-fluid logo-dark"> -->
                    </a>
                </div>
                <div class="col-xxl-5 col-xl-6 col-md-5 col-3 d-none d-md-block ps-6">
                    <form class="search-form d-flex align-items-center" action="{{ route('products.index') }}">
                        <button type="submit" class="submit-icon-btn-secondary"><i class="fa-solid fa-magnifying-glass"></i></button>

                        <input type="text" placeholder="{{ localize('Search products') }}" class="w-100" name="search" @isset($searchKey) value="{{ $searchKey }}" @endisset>
                    </form>
                </div>

                <div class="col-xxl-5 col-xl-3 col-md-4 col-4">

                    <div class="gshop-navbar-right d-flex align-items-center justify-content-end position-relative">
                       

                        <div class="gshop-header-icons gap-0 gap-sm-4 d-inline-flex align-items-center justify-content-end ms-3">
                        <div class="gshop-header-help position-relative d-none d-lg-block">
                            <a href="#" title="{{localize('Vuoi un aiuto')}}">
                            <svg width="20" id="ef38b990-bdea-429d-ad58-78f9ef51a100" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48"><defs><clipPath id="a099faaf-e198-4a3c-a1fa-941dd359472e"><rect id="f882fa1f-56a5-4fb6-a9ea-79f1e1fd5cfe" data-name="SVGID" x="-0.02" y="3.51" width="48.05" height="40.97" style="fill:none"/></clipPath></defs><title>help</title><g style="clip-path:url(#a099faaf-e198-4a3c-a1fa-941dd359472e)"><path d="M46,25.28l-.34,0V23.13A4,4,0,0,0,43,19.42C40.28-1.76,8.48-1.79,5.64,19.32A4,4,0,0,0,2.7,23.13v2.28A2,2,0,0,0,.1,26.62a2.16,2.16,0,0,0-.12.71v9a2.05,2.05,0,0,0,2,2.05H2a2.15,2.15,0,0,0,.67-.13v2.28a4,4,0,0,0,7.91,0V23.14A3.93,3.93,0,0,0,8,19.42c2.71-18.08,29.89-18.1,32.69-.1a3.94,3.94,0,0,0-2.93,3.81V40.52a4,4,0,1,0,7.9,0V38.33l.34,0a2.05,2.05,0,0,0,2.05-2h0v-9a2.05,2.05,0,0,0-2.05-2h0" style="fill:#414647"/></g></svg>
                            <div class="d-none d-xl-block">
                                {{localize('Vuoi un aiuto')}}
                            </div>
                            </a>
                        
                        </div>

                        <div class="gshop-header-help position-relative d-none d-sm-block">
                            <a href="#" title="{{localize('Le mie creazioni')}}" >
                            <svg width="17" id="e5174820-0a88-4174-9843-8f051f50a108" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48"><defs><clipPath id="a3519339-cc5f-4a7a-9e33-06f7bb57f78b"><rect id="afcac5a9-cff0-49c5-b13f-59e1b31ec7c4" data-name="SVGID" y="1.41" width="48" height="45.17" style="fill:none"/></clipPath></defs><title>star</title><g style="clip-path:url(#a3519339-cc5f-4a7a-9e33-06f7bb57f78b)"><path d="M22,3.06c1.1-2.2,2.9-2.2,4,0l4.1,8.18a9.64,9.64,0,0,0,6.46,4.63l9.18,1.32c2.46.36,3,2,1.24,3.75l-6.64,6.38a9.42,9.42,0,0,0-2.47,7.48l1.57,9c.42,2.41-1,3.45-3.23,2.31L28,41.87a9.76,9.76,0,0,0-8,0L11.8,46.12c-2.19,1.13-3.64.1-3.22-2.31l1.57-9a9.4,9.4,0,0,0-2.47-7.48L1,20.94c-1.77-1.7-1.22-3.39,1.23-3.75l9.18-1.31a9.67,9.67,0,0,0,6.45-4.63Z" style="fill:#414647"/></g></svg>                            
                            <div class="d-none d-xl-block">
                                {{localize('Le mie creazioni')}}
                            </div>
                            </a>
                        
                        </div>
                            <div class="gshop-header-user position-relative">
                                <button type="button" class="header-icon">
                                <svg width="17" id="acbc88fc-2ec0-4805-ab5b-4145d3c620c8" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48"><defs><clipPath id="bfaa4b2c-0910-48a3-afdf-60bc1ac2ba48"><rect id="a72b34f5-e6d5-4c2b-8be9-533226f53ab6" data-name="SVGID" x="4.29" width="39.42" height="48" style="fill:none"/></clipPath></defs><title>login</title><g style="clip-path:url(#bfaa4b2c-0910-48a3-afdf-60bc1ac2ba48)"><path d="M37.66,13.56H36.13V7.71A7.72,7.72,0,0,0,28.41,0H19.59a7.72,7.72,0,0,0-7.72,7.71v1.7h4.4V7.71a3.32,3.32,0,0,1,3.3-3.3h8.84a3.31,3.31,0,0,1,3.3,3.3v5.85H10.34a6.05,6.05,0,0,0-6,6.06V42a6,6,0,0,0,6.05,6H37.66a6.05,6.05,0,0,0,6.05-6V19.62a6.05,6.05,0,0,0-6.05-6.06M26.05,36.65a2,2,0,0,1,.08.54V40a2.13,2.13,0,1,1-4.26,0V37.2a2,2,0,0,1,.07-.54,7.37,7.37,0,1,1,4.11,0" style="fill:#414647"/></g></svg>                                    
                                <div class="d-none d-xl-block">
                                    {{localize('Accedi')}}
                                </div>
                                </button>
                                <div class="user-menu-wrapper">
                                    <ul class="user-menu">
                                        @auth
                                        @if (auth()->user()->user_type == 'customer' || auth()->user()->user_type == 'admin' )
                                        <li><a href="{{ route('customers.dashboard') }}"><span class="me-2"><i class="fa-solid fa-user"></i></span>{{ localize('My Account') }}</a>
                                        </li>
                                        <li><a href="{{ route('customers.orderHistory') }}"><span class="me-2"><i class="fa-solid fa-tags"></i></span>{{ localize('My Orders') }}</a>
                                        </li>
                                        <li><a href="{{ route('customers.wishlist') }}"><span class="me-2"><i class="fa-solid fa-heart"></i></span>{{ localize('My Wishlist') }}</a>
                                        </li>
                                        @else
                                        <li><a href="{{ route('admin.dashboard') }}"><span class="me-2"><i class="fa-solid fa-bars"></i></span>{{ localize('Dashboard') }}</a>
                                        </li>
                                        @endif

                                        <li><a href="{{ route('logout') }}"><span class="me-2"><i class="fa-solid fa-arrow-right-from-bracket"></i></span>{{ localize('Sign Out') }}
                                            </a></li>
                                        @endauth


                                        @guest
                                        <li><a href="{{ route('login') }}"><span class="me-2"><i class="fa-solid fa-arrow-right-from-bracket"></i></span>{{ localize('Sign In') }}</a>
                                        </li>
                                        @endguest


                                    </ul>
                                </div>
                            </div>
                            <div class="gshop-header-cart position-relative">



                                <button type="button" class="header-icon">
                                <svg width="17" id="f96f1b2e-61fc-40e0-9b4d-ef079bea0777" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48"><defs><clipPath id="a0a5a8a2-f232-4222-a649-01e399bdc859"><rect id="ad6dfd97-da9e-4b0e-aacd-b85cd884c816" data-name="SVGID" x="8.55" width="30.9" height="48" style="fill:none"/></clipPath></defs><title>cart</title><g style="clip-path:url(#a0a5a8a2-f232-4222-a649-01e399bdc859)"><path d="M33,13.18V8.7a8.7,8.7,0,0,0-17.4-.32v4.8H8.55V48h30.9V13.18ZM18.71,8.7a5.61,5.61,0,1,1,11.22,0v4.48H18.71Z" style="fill:#414647"/></g></svg>                                    <span class="cart-counter badge bg-primary rounded-circle p-0 {{ count($carts) > 0 ? '' : 'd-none' }}">{{ count($carts) }}</span>
                                <div class="d-none d-xl-block">
                                {{localize('Carrello')}}
                                </div>
                                </button>
                                <div class="cart-box-wrapper">
                                    <div class="apt_cart_box theme-scrollbar">
                                        <ul class="at_scrollbar scrollbar cart-navbar-wrapper">
                                            <!--cart listing-->
                                            @include('frontend.default.pages.partials.carts.cart-navbar', [
                                            'carts' => $carts,
                                            ])
                                            <!--cart listing-->

                                        </ul>
                                        <div class="d-flex align-items-center justify-content-between mt-3">
                                            <h6 class="mb-0">{{ localize('Subtotal') }}:</h6>
                                            <span class="fw-semibold text-secondary sub-total-price">{{ formatPrice(getSubTotal($carts, false)) }}</span>
                                        </div>
                                        <div class="row align-items-center justify-content-between ">
                                            <div class="col-6">
                                                <a href="{{ route('carts.index') }}" class="btn btn-primary btn-md mt-4 w-100 justify-content-center"><span class="me-2"><i class="fa-solid fa-shopping-bag"></i></span>{{ localize('View Cart') }}</a>
                                            </div>
                                            <div class="col-6">
                                                <a href="{{ route('checkout.proceed') }}" class="btn btn-primary btn-md mt-4 w-100 justify-content-center"><span class="me-2"><i class="fa-solid fa-credit-card"></i></span>{{ localize('Checkout') }}</a>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                      
                    </div>
                </div>
            </div>
            @include('frontend.default.inc.menu')
        </div>
    </div>
   
</header>
