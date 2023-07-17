<section class="featured-products pt-120 pb-200 bg-shade position-relative overflow-hidden z-1">
    <img src="{{ staticAsset('frontend/default/assets/img/shapes/roll-1.png') }}" alt="roll"
        class="position-absolute roll-1 z--1" data-parallax='{"y": -120}'>
    <img src="{{ staticAsset('frontend/default/assets/img/shapes/roll-2.png') }}" alt="roll"
        class="position-absolute roll-2 z--1" data-parallax='{"y": 120}'>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6">
                <div class="section-title text-center mb-4">
                    <h3 class="mb-2">{{ localize('Our Featured Products') }}</h3>
                    <p class="mb-0">{{ getSetting('featured_sub_title') }}</p>
                </div>
            </div>
        </div>
        <div class="row g-4 justify-content-center">
            <!-- left column -->
            @php
                $featured_products_left = getSetting('featured_products_left') != null ? json_decode(getSetting('featured_products_left')) : [];
                $left_products = \App\Models\Product::whereIn('id', $featured_products_left)->get();
            @endphp

            <div class="col-xxl-4 col-lg-6">
                @foreach ($left_products as $product)
                    <div class="{{ !$loop->last ? 'mb-3' : '' }}">
                        @include('frontend.default.pages.partials.products.horizontal-product-card', [
                            'product' => $product,
                            'bgClass' => 'bg-white',
                        ])
                    </div>
                @endforeach
            </div>

            <!-- banner -->
            <div class="col-xxl-4 col-lg-6 order-3 order-xxl-2 d-none d-xl-block d-none-1399">
                <div class="product-card-lg bg-light rounded-2 d-flex flex-column h-100">
                    <a href="{{ getSetting('featured_banner_link') }}" class="my-auto">
                        <img src="{{ uploadedAsset(getSetting('featured_center_banner')) }}" alt="">
                    </a>
                </div>
            </div>

            <!-- right column -->
            @php
                $featured_products_right = getSetting('featured_products_right') != null ? json_decode(getSetting('featured_products_right')) : [];
                $right_products = \App\Models\Product::whereIn('id', $featured_products_right)->get();
            @endphp


            <div class="col-xxl-4 col-lg-6 order-2 order-xxl-3">
                @foreach ($right_products as $product)
                    <div class="{{ !$loop->last ? 'mb-3' : '' }}">
                        @include('frontend.default.pages.partials.products.horizontal-product-card', [
                            'product' => $product,
                            'bgClass' => 'bg-white',
                        ])
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    <img src="{{ staticAsset('frontend/default/assets/img/shapes/bg-shape-2.png') }}" alt="bg shape"
        class="position-absolute start-0 bottom-0 w-100 z--1">
</section>
