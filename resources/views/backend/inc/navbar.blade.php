<header class="tt-top-fixed bg-light-subtle">
    <div class="container-fluid">
        <nav class="navbar navbar-top navbar-expand" id="navbarDefault">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="tt-mobile-toggle-brand d-lg-none d-md-none">
                    <a class="tt-toggle-sidebar pe-3" href="#offcanvasLeft" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasLeft">
                        <i data-feather="menu"></i>
                    </a>
                    <div class="tt-brand pe-3">
                        <a href="{{ route('admin.dashboard') }}">
                            <img src="{{ uploadedAsset(getSetting('favicon')) }}" class="tt-brand-favicon"
                                alt="favicon" />
                        </a>
                    </div>
                </div>

                @if (Route::is('admin.pos.index'))
                    <div class="align-items-center d-none d-lg-flex">
                        <a class="pe-3" href="{{ route('admin.dashboard') }}" data-bs-toggle="tooltip"
                            data-bs-placement="right" data-bs-title="Go to Dashboard">
                            <i data-feather="pie-chart"></i>
                        </a>
                        <div class="tt-brand pe-3">
                            <a href="{{ route('admin.dashboard') }}">
                                <img src="{{ uploadedAsset(getSetting('favicon')) }}" class="tt-brand-favicon"
                                    alt="favicon" />
                            </a>
                        </div>
                    </div>
                @endif

                <div class="tt-search-box d-none d-md-block d-lg-block flex-grow-1 me-4">
                    <form action="">
                        <div class="input-group">
                            <span class="position-absolute top-50 start-0 translate-middle-y ms-2"> <i
                                    data-feather="search"></i></span>
                            <input class="form-control rounded-start w-100 border-0 bg-transparent" type="text"
                                name="search"
                                @isset($searchKey)
                                    value="{{ $searchKey }}"
                                @endisset
                                placeholder="{{ localize('Search') }}...">
                        </div>
                    </form>
                </div>
                <ul class="navbar-nav flex-row align-items-center tt-top-navbar">

                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link tt-visit-store" target="_blank">
                            <i data-feather="globe" class="me-2"></i>
                            {{ localize('Visit Store') }}
                        </a>
                    </li>



                    <li class="nav-item dropdown">
                        @php
                            if (Session::has('locale')) {
                                $locale = Session::get('locale', Config::get('app.locale'));
                            } else {
                                $locale = env('DEFAULT_LANGUAGE');
                            }
                            $currentLanguage = \App\Models\Language::where('code', $locale)->first();
                        @endphp

                    <li class="nav-item dropdown tt-curency-lang-dropdown d-none d-md-block">
                        <a href="javascript:void(0);" class="nav-link" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <img src="{{ staticAsset('backend/assets/img/flags/' . $currentLanguage->flag . '.png') }}"
                                alt="country" class="img-fluid me-1"> {{ $currentLanguage->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end py-0 shadow border-0">
                            @foreach (\App\Models\Language::where('is_active', 1)->get() as $key => $language)
                                <!-- item-->
                                <li>
                                    <a href="javascript:void(0);"
                                        class="dropdown-item @if ($currentLanguage->code == $language->code) active @endif"
                                        onclick="changeLocaleLanguage(this)" data-flag="{{ $language->code }}">
                                        <img src="{{ staticAsset('backend/assets/img/flags/' . $language->flag . '.png') }}"
                                            alt="{{ $language->code }}" class="img-fluid me-1"> <span
                                            class="align-middle">{{ $language->name }}</span>
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
                    @endphp

                    <li class="nav-item dropdown tt-curency-lang-dropdown d-none d-md-block">
                        <a href="#" class="nav-link text-uppercase" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">{{ $currentCurrency->symbol }} {{ $currentCurrency->code }}</a>
                        <ul class="dropdown-menu dropdown-menu-end py-0 shadow border-0">

                            @foreach (\App\Models\Currency::where('is_active', 1)->get() as $key => $currency)
                                <li>
                                    <a class="dropdown-item fs-xs text-uppercase" href="javascript:void(0);"
                                        onclick="changeLocaleCurrency(this)" data-currency="{{ $currency->code }}">
                                        {{ $currency->symbol }} {{ $currency->code }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>


                    <li class="nav-item">
                        <a href="javascript:void(0)" class="nav-link tt-theme-toggle">
                            <div class="tt-theme-light"><i data-feather="moon" class="fs-xm"></i></div>
                            <div class="tt-theme-dark"><i data-feather="sun" class="fs-xm"></i></div>
                        </a>
                    </li>

                    @php
                        $newOrdersCount = 0;
                        $newMsgCount = 0;
                    @endphp

                    @can('orders')
                        @php
                            $newOrdersCount = \App\Models\Order::isPlaced()->count();
                        @endphp
                    @endcan

                    @can('contact_us_messages')
                        @php
                            $newMsgCount = \App\Models\ContactUsMessage::where('is_seen', 0)->count();
                        @endphp
                    @endcan


                    <a class="nav-link position-relative tt-notification" href="#" role="button"
                        id="notificationDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                        data-bs-auto-close="outside">
                        <i data-feather="bell"></i>
                        @if ($newMsgCount > 0 || $newOrdersCount > 0)
                            <span class="tt-notification-dot bg-danger rounded-circle"></span>
                        @endif
                    </a>

                    <div class="dropdown-menu dropdown-menu-end py-0 shadow-sm border-0"
                        aria-labelledby="notificationDropdown">
                        <div class="card position-relative border-0">
                            <div class="card-body p-0">
                                <div class="scrollbar-overlay">

                                    @can('orders')
                                        @if ($newOrdersCount > 0)
                                            <div class="p-3 position-relative border-bottom">
                                                <a href="{{ route('admin.orders.index') }}"
                                                    class="d-flex align-items-center">
                                                    <h4 class="fs-md mb-0"><i data-feather="shopping-cart"
                                                            class="me-1 text-accent" width="18"></i>
                                                        {{ localize('New Order Placed') }} ({{ $newOrdersCount }})</h4>
                                                </a>
                                            </div>
                                        @endif
                                    @endcan


                                    @can('contact_us_messages')
                                        @if ($newMsgCount > 0)
                                            <div class="p-3 position-relative border-bottom">
                                                <a href="{{ route('admin.queries.index') }}"
                                                    class="d-flex align-items-center">
                                                    <h4 class="fs-md mb-0"><i data-feather="mail" width="18"
                                                            class="me-1 text-success"></i>
                                                        {{ localize('New Contact Message') }} ({{ $newMsgCount }})</h4>
                                                </a>
                                            </div>
                                        @endif
                                    @endcan

                                    @if ($newMsgCount <= 0 && $newOrdersCount <= 0)
                                        <div class="p-3 position-relative border-bottom">
                                            <h4 class="fs-md mb-0 text-muted fw-normal"><i data-feather="info"
                                                    width="18"
                                                    class="me-1 text-danger"></i>{{ localize('No New Notification') }}
                                            </h4>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    </li>

                    <li class="nav-item dropdown tt-user-dropdown">
                        <a class="nav-link lh-1 pe-0" id="navbarDropdownUser" href="#!" role="button"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true"
                            aria-expanded="true">
                            <div class="avatar avatar-sm status-online">
                                <img class="rounded-circle" src="{{ uploadedAsset(auth()->user()->avatar) }}"
                                    alt="avatar">
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end py-0 shadow-sm border-0"
                            aria-labelledby="navbarDropdownUser">
                            <div class="card position-relative border-0">
                                <div class="card-body py-2">
                                    <ul class="tt-user-nav list-unstyled d-flex flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link px-0" href="{{ route('admin.profile') }}">
                                                <i data-feather="user" class="me-1 fs-sm"></i>
                                                {{ localize('My Account') }}
                                            </a>
                                        </li>
                                        @can('general_settings')
                                            <li class="nav-item">
                                                <a class="nav-link px-0" href="{{ route('admin.generalSettings') }}">
                                                    <i data-feather="settings" class="me-1 fs-sm"></i>
                                                    {{ localize('Settings') }}
                                                </a>
                                            </li>
                                        @endcan
                                        <li class="nav-item">
                                            <a class="nav-link px-0" href="{{ route('logout') }}">
                                                <i data-feather="log-out"
                                                    class="me-1 fs-sm"></i>{{ localize('Sign out') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>

<!--mobile offcanvas menu start-->
<div class="offcanvas offcanvas-start tt-aside-navbar" id="offcanvasLeft" tabindex="-1">
    <div class="offcanvas-header border-bottom">
        <div class="tt-brand">
            <a href="index.html" class="tt-brand-link">
                <img src="{{ uploadedAsset(getSetting('favicon')) }}" class="tt-brand-favicon ms-1"
                    alt="favicon" />
                <img src="{{ uploadedAsset(getSetting('admin_panel_logo')) }}" class="tt-brand-logo ms-2"
                    alt="logo" />
            </a>
        </div>
        <button class="btn-close" type="button" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-2 pb-9" data-simplebar>
        <div class="tt-sidebar-nav">
            <nav class="navbar navbar-vertical">
                <div class="w-100">
                    @include('backend.inc.sidebarMenus')
                </div>
            </nav>
        </div>
    </div>
</div>
<!--mobile offcanvas menu end-->
