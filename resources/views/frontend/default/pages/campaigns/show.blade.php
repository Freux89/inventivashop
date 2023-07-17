@extends('frontend.default.layouts.master')

@section('title')
    {{ localize('Campaign Products') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    <!--breadcrumb-->
    <div class="gstore-breadcrumb position-relative z-1 overflow-hidden mt--50 tt-campaign-single-bg"
        style="background:
      url('{{ uploadedAsset($campaign->banner) }}')no-repeat center
      center / cover">
        <img src="{{ staticAsset('frontend/default/assets/img/shapes/bg-shape-6.png') }}" alt="bg-shape"
            class="position-absolute start-0 z--1 w-100 bg-shape">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="breadcrumb-content">
                        <h2 class="mb-2 text-center text-light">{{ $campaign->title }}</h2>
                        <ul class="timing-countdown countdown-timer d-flex align-items-center gap-2 mt-3 justify-content-center"
                            data-date="{{ date('m/d/Y', $campaign->end_date) }} 23:59:59">
                            <li
                                class="position-relative z-1 d-flex align-items-center justify-content-center flex-column rounded-2">
                                <h5 class="mb-1 days fs-sm">00</h5>
                                <span class="gshop-subtitle fs-xxs d-block">{{ localize('Days') }}</span>
                            </li>
                            <li
                                class="position-relative z-1 d-flex align-items-center justify-content-center flex-column rounded-2">
                                <h5 class="mb-1 hours fs-sm">00</h5>
                                <span class="gshop-subtitle fs-xxs d-block">{{ localize('Hours') }}</span>
                            </li>
                            <li
                                class="position-relative z-1 d-flex align-items-center justify-content-center flex-column rounded-2">
                                <h5 class="mb-1 minutes fs-sm">00</h5>
                                <span class="gshop-subtitle fs-xxs d-block">{{ localize('Min') }}</span>
                            </li>
                            <li
                                class="position-relative z-1 d-flex align-items-center justify-content-center flex-column rounded-2">
                                <h5 class="mb-1 seconds fs-sm">00</h5>
                                <span class="gshop-subtitle fs-xxs d-block">{{ localize('Sec') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumb-->

    <!--campaign section start-->
    <section class="pb-100 pt-80 position-relative overflow-hidden z-1 trending-products-area">
        <img src="{{ staticAsset('frontend/default/assets/img/shapes/garlic.png') }}" alt="garlic"
            class="position-absolute garlic z--1" data-parallax='{"y": 100}'>
        <img src="{{ staticAsset('frontend/default/assets/img/shapes/carrot.png') }}" alt="carrot"
            class="position-absolute carrot z--1" data-parallax='{"y": -100}'>
        <img src="{{ staticAsset('frontend/default/assets/img/shapes/mashrom.png') }}" alt="mashrom"
            class="position-absolute mashrom z--1" data-parallax='{"x": 100}'>

        <div class="container">
            <div class="row justify-content-center g-4 mt-5">
                @php
                    $campaignProductIds = \App\Models\CampaignProduct::where('campaign_id', $campaign->id)->pluck('product_id');
                    $campaign_products = \App\Models\Product::whereIn('id', $campaignProductIds)
                        ->latest()
                        ->get();
                @endphp

                @foreach ($campaign_products as $product)
                    <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-10">
                        @include('frontend.default.pages.partials.products.trending-product-card', [
                            'product' => $product,
                            'bgClass' => 'bg-white',
                            'showSold' => true,
                        ])
                    </div>
                @endforeach
            </div>
    </section>
    <!--campaign section end-->
@endsection
