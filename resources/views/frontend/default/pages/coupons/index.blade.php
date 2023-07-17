@extends('frontend.default.layouts.master')

@section('title')
    {{ localize('Coupons') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('breadcrumb-contents')
    <div class="breadcrumb-content">
        <h2 class="mb-2 text-center">{{ localize('All Coupons') }}</h2>
        <nav>
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item fw-bold" aria-current="page"><a
                        href="{{ route('home') }}">{{ localize('Home') }}</a></li>
                <li class="breadcrumb-item fw-bold" aria-current="page">{{ localize('Coupons') }}</li>
            </ol>
        </nav>
    </div>
@endsection

@section('contents')
    <!--breadcrumb-->
    @include('frontend.default.inc.breadcrumb')
    <!--breadcrumb-->

    <!--campaign section start-->
    <section class="tt-campaigns ptb-100">
        <div class="container">
            <div class="row g-4">

                @php
                    $coupons = \App\Models\Coupon::where('end_date', '>=', strtotime(date('Y-m-d')))
                        ->latest()
                        ->get();
                @endphp

                @forelse ($coupons as $coupon)
                    <div class="col-lg-4 col-md-6">
                        <div class="card shadow-lg border-0 tt-coupon-single tt-gradient-top"
                            style="background:
          url('{{ uploadedAsset($coupon->banner) }}')no-repeat center
          center / cover">
                            <div class="card-body text-center py-5 px-4">
                                <div class="offer-text mb-2 justify-content-center">
                                    <div class="up-to fw-bold text-light">{{ localize('UP TO') }}</div>
                                    <div class="display-4 fw-bold text-danger">
                                        {{ $coupon->discount_type != 'flat' ? $coupon->discount_value : formatPrice($coupon->discount_value) }}
                                    </div>
                                    <p class="mb-0 fw-bold text-danger">
                                        <span>{{ $coupon->discount_type != 'flat' ? '%' : '' }}</span> <br>
                                        {{ localize('Off') }}
                                    </p>
                                </div>
                                <div class="coupon-row">
                                    <span class="copyCode">{{ $coupon->code }}</span>
                                    <span class="copyBtn copy-text"
                                        data-clipboard-text="{{ $coupon->code }}">{{ localize('Copy Code') }}</span>
                                </div>
                                <ul class="timing-countdown countdown-timer d-inline-block gap-2 mt-3"
                                    data-date="{{ date('m/d/Y', $coupon->end_date) }} 23:59:59">
                                    <li class="list-inline-item bg-white position-relative z-1 rounded-2">
                                        <h5 class="mb-1 days fs-sm">00</h5>
                                        <span class="gshop-subtitle fs-xxs d-block">{{ localize('Days') }}</span>
                                    </li>
                                    <li class="list-inline-item bg-white position-relative z-1 rounded-2">
                                        <h5 class="mb-1 hours fs-sm">00</h5>
                                        <span class="gshop-subtitle fs-xxs d-block">{{ localize('Hours') }}</span>
                                    </li>
                                    <li class="list-inline-item bg-white position-relative z-1 rounded-2">
                                        <h5 class="mb-1 minutes fs-sm">00</h5>
                                        <span class="gshop-subtitle fs-xxs d-block">{{ localize('Min') }}</span>
                                    </li>
                                    <li class="list-inline-item bg-white position-relative z-1 rounded-2">
                                        <h5 class="mb-1 seconds fs-sm">00</h5>
                                        <span class="gshop-subtitle fs-xxs d-block">{{ localize('Sec') }}</span>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 col-md-6 mx-auto">

                        <img src="{{ staticAsset('frontend/default/assets/img/no-data-found.png') }}" class="img-fluid"
                            alt="">
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <!--campaign section end-->
@endsection
