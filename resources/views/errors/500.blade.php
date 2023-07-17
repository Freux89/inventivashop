@extends('frontend.default.layouts.master')
@section('contents')
    <section class="section-404 ptb-120 position-relative overflow-hidden z-1">
        <img src="{{ staticAsset('frontend/default/assets/img/shapes/frame-circle.svg') }}" alt="frame circle"
            class="position-absolute z--1 frame-circle d-none d-sm-block">
        <img src="{{ staticAsset('frontend/default/assets/img/shapes/cauliflower.png') }}" alt="cauliflower"
            class="position-absolute cauliflower z--1 d-none d-sm-block">
        <img src="{{ staticAsset('frontend/default/assets/img/shapes/leaf.svg') }}" alt="leaf"
            class="position-absolute leaf z--1 d-none d-sm-block">
        <img src="{{ staticAsset('frontend/default/assets/img/shapes/pata-xs.svg') }}" alt="pata"
            class="position-absolute pata z--1 d-none d-sm-block">
        <img src="{{ staticAsset('frontend/default/assets/img/shapes/tomato-half.svg') }}" alt="tomato"
            class="position-absolute tomato-half z--1 d-none d-sm-block">
        <img src="{{ staticAsset('frontend/default/assets/img/shapes/garlic-white.png') }}" alt="garlic"
            class="position-absolute garlic-white z--1 d-none d-sm-block">
        <img src="{{ staticAsset('frontend/default/assets/img/shapes/tomato-slice.svg') }}" alt="tomato"
            class="position-absolute tomato-slice z--1 d-none d-sm-block">
        <img src="{{ staticAsset('frontend/default/assets/img/shapes/onion.png') }} " alt="onion"
            class="position-absolute onion z--1 d-none d-sm-block">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6">
                    <div class="content-404 text-center">
                        <img src="{{ staticAsset('frontend/default/assets/img/500.png') }}" alt="not found"
                            class="img-fluid mb-5 d-none d-md-inline-block w-50">
                        <h3 class="fw-bold display-1 mb-0">500</h3>
                        <h2 class="mt-3">Sorry, Internal Server Error</h2>
                        <p class="mb-6">The page you are looking for might have been removed had its name changed or is
                            temporarily unavailable.</p>
                        <a href="{{ env('APP_URL') }}" class="btn btn-secondary btn-md rounded-1">Back to Home Page</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
