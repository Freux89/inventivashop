<section class="pb-120 position-relative z-1 pt-120">
    <div class="container">
        <div class="row g-4 align-items-center justify-content-center">
            <div class="col-xxl-4 col-xl-5 order-2 order-xxl-1 d-none d-xl-block d-none-1399">
                <a href="{{ getSetting('best_deal_banner_link') }}">
                    <img src="{{ uploadedAsset(getSetting('best_deal_banner')) }}" alt="" class="img-fluid">
                </a>
            </div>
            <div class="col-xxl-8 order-1 order-xxl-2">
                <div
                    class="timing-box d-flex align-items-center justify-content-center justify-content-sm-between rounded-3 flex-wrap gap-3">
                    <h4 class="mb-0">{{ localize('Weekly Best Deals') }}</h4>
                    @php
                        $best_deal_end_date = getSetting('best_deal_end_date');
                        if (!is_null($best_deal_end_date)) {
                            $best_deal_end_date = date('m/d/Y H:i:s', strtotime($best_deal_end_date));
                        }
                    @endphp

                    <ul class="timing-countdown countdown-timer d-flex align-items-center gap-2"
                        data-date="{{ $best_deal_end_date }}">
                        <li
                            class="position-relative z-1 d-flex align-items-center justify-content-center flex-column rounded-2">
                            <h5 class="mb-0 days">00</h5>
                            <span class="gshop-subtitle fs-xxs d-block">{{ localize('Days') }}</span>
                        </li>
                        <li
                            class="position-relative z-1 d-flex align-items-center justify-content-center flex-column rounded-2">
                            <h5 class="mb-0 hours">00</h5>
                            <span class="gshop-subtitle fs-xxs d-block">{{ localize('Hours') }}</span>
                        </li>
                        <li
                            class="position-relative z-1 d-flex align-items-center justify-content-center flex-column rounded-2">
                            <h5 class="mb-0 minutes">00</h5>
                            <span class="gshop-subtitle fs-xxs d-block">{{ localize('Min') }}</span>
                        </li>
                        <li
                            class="position-relative z-1 d-flex align-items-center justify-content-center flex-column rounded-2">
                            <h5 class="mb-0 seconds">00</h5>
                            <span class="gshop-subtitle fs-xxs d-block">{{ localize('Sec') }}</span>
                        </li>
                    </ul>
                </div>
                <div class="mt-4">
                    <div class="row g-4">
                        @php
                            $weekly_best_deals = getSetting('weekly_best_deals') != null ? json_decode(getSetting('weekly_best_deals')) : [];
                            $products = \App\Models\Product::whereIn('id', $weekly_best_deals)->get();
                        @endphp

                        @foreach ($products as $product)
                            <div class="col-lg-6">
                                @include(
                                    'frontend.default.pages.partials.products.horizontal-product-card',
                                    [
                                        'product' => $product,
                                    ]
                                )
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
