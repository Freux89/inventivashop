@extends('frontend.default.layouts.master')
@section('title')
    Under Maintenance
@endsection
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
                        <img src="{{ staticAsset('frontend/default/assets/img/503.svg') }}" alt="not found"
                            class="img-fluid">
                        <h2 class="mt-4">We are under development.</h2>
                        <p class="mb-6">The page you are looking for is
                            temporarily unavailable.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
