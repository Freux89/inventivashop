<div class="footer-curve position-relative overflow-hidden">
    <span class="position-absolute section-curve-wrapper top-0 h-100"
        data-background="{{ staticAsset('frontend/default/assets/img/shapes/section-curve.png') }}"></span>
</div>

<footer class="gshop-footer position-relative pt-8 bg-dark z-1 overflow-hidden">
    <img src="{{ staticAsset('frontend/default/assets/img/shapes/tomato.svg') }}" alt="tomato"
        class="position-absolute z--1 tomato vector-shape">
    <img src="{{ staticAsset('frontend/default/assets/img/shapes/pata-lg.svg') }}" alt="pata"
        class="position-absolute z--1 pata-lg vector-shape">
    <img src="{{ staticAsset('frontend/default/assets/img/shapes/pata-xs.svg') }}" alt="pata"
        class="position-absolute z--1 pata-xs vector-shape">
    <img src="{{ staticAsset('frontend/default/assets/img/shapes/frame-circle.svg') }}" alt="frame"
        class="position-absolute z--1 frame-circle vector-shape">
    <img src="{{ staticAsset('frontend/default/assets/img/shapes/leaf.svg') }}" alt="leaf"
        class="position-absolute z--1 leaf vector-shape">
    <!--shape right -->
    <img src="{{ staticAsset('frontend/default/assets/img/shapes/leaf.svg') }}" alt="pata"
        class="position-absolute leaf-2 z--1 vector-shape">
    <img src="{{ staticAsset('frontend/default/assets/img/shapes/pata-xs.svg') }}" alt="pata"
        class="position-absolute pata-xs-2 z--1 vector-shape">
    <img src="{{ staticAsset('frontend/default/assets/img/shapes/tomato-slice.svg') }}" alt="tomato slice"
        class="position-absolute tomato-slice vector-shape z--1">
    <img src="{{ staticAsset('frontend/default/assets/img/shapes/tomato-half.svg') }}" alt="tomato"
        class="position-absolute tomato-half z--1 vector-shape">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6">
                <div class="gshop_subscribe_form text-center">
                    <h4 class="text-white gshop-title">{{ localize('Subscribe to the us') }}<mark
                            class="p-0 position-relative text-secondary bg-transparent"> {{ localize('New Arrivals') }}
                            <img src="{{ staticAsset('frontend/default/assets/img/shapes/border-line.svg') }}"
                                alt="border line" class="position-absolute border-line"></mark><br
                            class="d-none d-sm-block">{{ localize('& Other Information.') }}</h4>
                    <form class="mt-5 d-flex align-items-center bg-white rounded subscribe_form"
                        action="{{ route('subscribe.store') }}" method="POST">
                        @csrf
                        <input type="email" class="form-control" placeholder="{{ localize('Enter Email Address') }}"
                            type="email" name="email" required>
                        <button type="submit"
                            class="btn btn-primary flex-shrink-0">{{ localize('Subscribe Now') }}</button>
                    </form>
                </div>
            </div>
        </div>
        <span class="gradient-spacer my-8 d-block"></span>
        <div class="row g-5">
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                <div class="footer-widget">
                    <h5 class="text-white mb-4">{{ localize('Category') }}</h5>
                    @php
                        $footer_categories = getSetting('footer_categories') != null ? json_decode(getSetting('footer_categories')) : [];
                        $categories = \App\Models\Category::whereIn('id', $footer_categories)->get();
                    @endphp
                    <ul class="footer-nav">
                        @foreach ($categories as $category)
                            <li><a
                                    href="{{ route('products.index') }}?&category_id={{ $category->id }}">{{ $category->collectLocalization('name') }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                <div class="footer-widget">
                    <h5 class="text-white mb-4">{{ localize('Quick Links') }}</h5>
                    @php
                        $quick_links = getSetting('quick_links') != null ? json_decode(getSetting('quick_links')) : [];
                        $pages = \App\Models\Page::whereIn('id', $quick_links)->get();
                    @endphp
                    <ul class="footer-nav">
                        @foreach ($pages as $page)
                            <li><a
                                    href="{{ route('home.pages.show', $page->slug) }}">{{ $page->collectLocalization('title') }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                <div class="footer-widget">
                    <h5 class="text-white mb-4">{{ localize('Customer Pages') }}</h5>
                    <ul class="footer-nav">
                        <li><a href="{{ route('customers.dashboard') }}">{{ localize('Your Account') }}</a></li>
                        <li><a href="{{ route('customers.orderHistory') }}">{{ localize('Your Orders') }}</a></li>
                        <li><a href="{{ route('customers.wishlist') }}">{{ localize('Your Wishlist') }}</a></li>
                        <li><a href="{{ route('customers.address') }}">{{ localize('Address Book') }}</a></li>
                        <li><a href="{{ route('customers.profile') }}">{{ localize('Update Profile') }}</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                <div class="footer-widget">
                    <h5 class="text-white mb-4">{{ localize('Contact Info') }}</h5>
                    <ul class="footer-nav">
                        <li class="text-white pb-2 fs-xs">{{ getSetting('topbar_location') }}</li>
                        <li class="text-white pb-2 fs-xs">{{ getSetting('navbar_contact_number') }}</li>
                        <li class="text-white pb-2 fs-xs">{{ getSetting('topbar_email') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-copyright pt-120 pb-3">
        <span class="gradient-spacer d-block mb-3"></span>
        <div class="container">
            <div class="row align-items-center g-3">
                <div class="col-lg-4">
                    <div class="copyright-text text-light">
                        {!! getSetting('copyright_text') !!}
                    </div>
                </div>
                <div class="col-lg-4 d-none d-lg-block">
                    <div class="logo-wrapper text-center">
                        <a href="{{ route('home') }}" class="logo"><img
                                src="{{ uploadedAsset(getSetting('footer_logo')) }}" alt="footer logo"
                                class="img-fluid"></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="footer-payments-info d-flex align-items-center justify-content-lg-end gap-2">
                        <div
                            class="rounded-1 d-inline-flex align-items-center justify-content-center p-2 flex-shrink-0">
                            <img src="{{ uploadedAsset(getSetting('accepted_payment_banner')) }}"
                                alt="accepted_payment" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
