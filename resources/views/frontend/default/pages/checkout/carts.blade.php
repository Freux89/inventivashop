@extends('frontend.default.layouts.master')

@section('title')
    {{ localize('Carts') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('breadcrumb-contents')
    <div class="breadcrumb-content">
        <h2 class="mb-2 text-center">{{ localize('Shopping Cart') }}</h2>
        <nav>
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item fw-bold" aria-current="page"><a
                        href="{{ route('home') }}">{{ localize('Home') }}</a></li>
                <li class="breadcrumb-item fw-bold" aria-current="page">{{ localize('Carts') }}</li>
            </ol>
        </nav>
    </div>
@endsection

@section('contents')
    <!--breadcrumb-->
    @include('frontend.default.inc.breadcrumb')
    <!--breadcrumb-->

    <!--cart section start-->
    <section class="cart-section ptb-120">
        <div class="container">
            <div class="rounded-2 overflow-hidden">
                <table class="cart-table w-100 bg-white">
                    <thead>
                        <th>{{ localize('Image') }}</th>
                        <th>{{ localize('Product Name') }}</th>
                        <th>{{ localize('U. Price') }}</th>
                        <th>{{ localize('Quantity') }}</th>
                        <th>{{ localize('T. Price') }}</th>
                        <th>{{ localize('Action') }}</th>
                    </thead>
                    <tbody class="cart-listing">
                        <!--cart listing-->
                        @include('frontend.default.pages.partials.carts.cart-listing', ['carts' => $carts])
                        <!--cart listing-->
                    </tbody>
                </table>
            </div>
            <div class="row g-4">
                <div class="col-xl-7">
                    <div class="voucher-box py-7 px-5 position-relative z-1 overflow-hidden bg-white rounded mt-4">
                        <img src="{{ staticAsset('frontend/default/assets/img/shapes/circle-half.png') }}"
                            alt="circle shape" class="position-absolute end-0 top-0 z--1">
                        <h4 class="mb-4">{{ localize('Have a coupon?') }}</h4>
                        <div class="font-bold mb-2">{{ localize('Apply coupon to get discount.') }}</div>

                        <!-- coupon form -->
                        <form class="d-flex align-items-center coupon-form">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <input type="text" name="code" placeholder="{{ localize('Enter Your Coupon Code') }}"
                                class="theme-input w-100 coupon-input"
                                @if (isset($_COOKIE['coupon_code'])) value="{{ $_COOKIE['coupon_code'] }}" disabled @endif
                                required>

                            @if (isset($_COOKIE['coupon_code']))
                                <button type="submit"
                                    class="btn btn-secondary flex-shrink-0 apply-coupon-btn d-none px-4">{{ localize('Apply Coupon') }}</button>
                                <button type="button" class="btn btn-secondary flex-shrink-0 clear-coupon-btn"><i
                                        class="fas fa-close"></i></button>
                            @else
                                <button type="submit"
                                    class="btn btn-secondary flex-shrink-0 apply-coupon-btn px-4">{{ localize('Apply Coupon') }}</button>
                                <button type="button" class="btn btn-secondary flex-shrink-0 clear-coupon-btn d-none"><i
                                        class="fas fa-close"></i></button>
                            @endif
                        </form>
                        <!-- coupon form -->

                    </div>
                </div>

                <div class="col-xl-5">
                    <div class="cart-summery bg-white rounded-2 pt-4 pb-7 px-5 mt-4">
                        <table class="w-100">
                            <tr>
                                <td class="py-3">
                                    <h5 class="mb-0 fw-medium">{{ localize('Subtotal') }}</h5>
                                </td>
                                <td class="py-3">
                                    <h5 class="mb-0 text-end sub-total-price">
                                        {{ formatPrice(getSubTotal($carts, false)) }}</h5>
                                </td>
                            </tr>

                            <tr class="coupon-discount-wrapper {{ getCoupon() == '' ? 'd-none' : '' }}">
                                <td class="py-3">
                                    <h5 class="mb-0 fw-medium">{{ localize('Coupon Discount') }}</h5>
                                </td>
                                <td class="py-3">
                                    <h5 class="mb-0 text-end coupon-discount-price">
                                        {{ formatPrice(getCouponDiscount(getSubTotal($carts, false), getCoupon())) }}</h5>
                                </td>
                            </tr>

                        </table>
                        <p class="mb-5 mt-2">{{ localize('Shipping options will be updated during checkout.') }}</p>
                        <div class="btns-group d-flex flex-wrap gap-3">

                            <a href="{{ route('home') }}"
                                class="btn btn-outline-secondary border-secondary btn-md rounded-1">{{ localize('Continue Shopping') }}</a>

                            <a href="{{ route('checkout.proceed') }}" type="submit"
                                class="btn btn-primary btn-md rounded-1">{{ localize('Checkout') }}</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!--cart section end-->
@endsection
