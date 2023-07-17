@extends('frontend.default.layouts.master')

@section('title')
    {{ localize('Checkout') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('breadcrumb-contents')
    <div class="breadcrumb-content">
        <h2 class="mb-2 text-center">{{ localize('Check Out') }}</h2>
        <nav>
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item fw-bold" aria-current="page"><a
                        href="{{ route('home') }}">{{ localize('Home') }}</a></li>
                <li class="breadcrumb-item fw-bold" aria-current="page">{{ localize('Checkout') }}</li>
            </ol>
        </nav>
    </div>
@endsection

@section('contents')
    <!--breadcrumb-->
    @include('frontend.default.inc.breadcrumb')
    <!--breadcrumb-->

    <!--checkout form start-->
    <form class="checkout-form" action="{{ route('checkout.complete') }}" method="POST">
        @csrf
        <div class="checkout-section ptb-120">
            <div class="container">
                <div class="row g-4">
                    <!-- form data -->
                    <div class="col-xl-8">
                        <div class="checkout-steps">
                            <!-- shipping address -->
                            <div class="d-flex justify-content-between">
                                <h4 class="mb-3">{{ localize('Shipping Address') }}</h4>
                                <a href="javascript:void(0);" onclick="addNewAddress()" class="fw-semibold"><i
                                        class="fas fa-plus me-1"></i> {{ localize('Add Address') }}</a>
                            </div>
                            <div class="row g-4">
                                @forelse ($addresses as $address)
                                    <div class="col-lg-6 col-sm-6">
                                        <div class="tt-address-content">
                                            <input type="radio" class="tt-custom-radio" name="shipping_address_id"
                                                id="shipping-{{ $address->id }}" value="{{ $address->id }}"
                                                onchange="getLogistics({{ $address->city_id }})"
                                                @if ($address->is_default) checked @endif
                                                data-city_id="{{ $address->city_id }}">

                                            <label for="shipping-{{ $address->id }}"
                                                class="tt-address-info bg-white rounded p-4 position-relative">
                                                <!-- address -->
                                                @include('frontend.default.inc.address', [
                                                    'address' => $address,
                                                ])
                                                <!-- address -->
                                                <a href="javascript:void(0);" onclick="editAddress({{ $address->id }})"
                                                    class="tt-edit-address checkout-radio-link position-absolute">{{ localize('Edit') }}</a>
                                            </label>

                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12 mt-5">
                                        <div class="tt-address-content">
                                            <div class="alert alert-secondary text-center">
                                                {{ localize('Add your address to checkout') }}
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                            <!-- shipping address -->

                            <!-- checkout-logistics -->
                            <div class="checkout-logistics"></div>
                            <!-- checkout-logistics -->

                            <!-- billing address -->
                            @if (count($addresses) > 0)
                                <h4 class="mb-3 mt-7">{{ localize('Billing Address') }}</h4>
                                <div class="row g-4">
                                    @foreach ($addresses as $address)
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="tt-address-content">
                                                <input type="radio" class="tt-custom-radio" name="billing_address_id"
                                                    id="billing-{{ $address->id }}" value="{{ $address->id }}"
                                                    @if ($address->is_default) checked @endif>

                                                <label for="billing-{{ $address->id }}"
                                                    class="tt-address-info bg-white rounded p-4 position-relative">
                                                    <!-- address -->
                                                    @include('frontend.default.inc.address', [
                                                        'address' => $address,
                                                    ])
                                                    <!-- address -->
                                                    <a href="javascript:void(0);"
                                                        onclick="editAddress({{ $address->id }})"
                                                        class="tt-edit-address checkout-radio-link position-absolute">{{ localize('Edit') }}</a>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            <!-- billing address -->

                            <!-- Delivery Time -->
                            <h4 class="mt-7 mb-3">{{ localize('Preferred Delivery Time') }}</h4>
                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="tt-address-content">
                                        <input type="radio" class="tt-custom-radio" name="shipping_delivery_type"
                                            id="regular-shipping" value="regular" checked>
                                        <label for="regular-shipping"
                                            class="tt-address-info bg-white rounded p-4 position-relative">
                                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                                <span class=""><i class="fas fa-truck me-1"></i>
                                                    {{ localize('Regular Delivery') }}
                                                </span>
                                                <p class="mb-0 fs-sm">
                                                    {{ localize('We will deliver your products soon.') }}
                                                </p>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                @if (getSetting('enable_scheduled_order') == 1)
                                    <div class="col-12">
                                        <div class="tt-address-content">
                                            <input type="radio" class="tt-custom-radio" name="shipping_delivery_type"
                                                id="scheduled-shipping" value="scheduled">

                                            <label for="scheduled-shipping"
                                                class="tt-address-info bg-white rounded p-4 position-relative">
                                                <div class="row flex-wrap justify-content-between align-items-center">
                                                    <div class="col-12 col-md-4 mb-2 mb-md-0">
                                                        <i class="fas fa-clock me-1"></i>
                                                        {{ localize('Scheduled Delivery') }}
                                                    </div>

                                                    <div
                                                        class="col-auto d-flex flex-grow-1 align-items-center justify-content-between">

                                                        @php
                                                            $date = date('Y-m-d');
                                                            $dateCount = 7;
                                                            if (getSetting('allowed_order_days') != null) {
                                                                $dateCount = getSetting('allowed_order_days');
                                                            }
                                                        @endphp

                                                        <select class="form-select py-1 me-3" name="scheduled_date">
                                                            @for ($i = 1; $i <= $dateCount; $i++)
                                                                @php
                                                                    $addDay = strtotime($date . '+' . $i . ' days');
                                                                @endphp
                                                                <option
                                                                    value="{{ strtotime($date . '+' . $i . ' days') }}">
                                                                    {{ date('d F', $addDay) }}</option>
                                                            @endfor
                                                        </select>

                                                        @php
                                                            $timeSlots = \App\Models\ScheduledDeliveryTimeList::orderBy('sorting_order', 'ASC')->get();
                                                        @endphp

                                                        <select class="form-select py-1" name="timeslot">
                                                            @foreach ($timeSlots as $slot)
                                                                <option value="{{ $slot->id }}">
                                                                    {{ $slot->timeline }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                @endif
                                <!-- Delivery Time -->

                            </div>

                            <!-- personal information -->
                            <h4 class="mt-7">{{ localize('Personal Information') }}</h4>
                            <div class="checkout-form mt-3 p-5 bg-white rounded-2">
                                <div class="row g-4">
                                    <div class="col-sm-6">
                                        <div class="label-input-field">
                                            <label>{{ localize('Phone') }}</label>
                                            <input type="text" name="phone"
                                                placeholder="{{ localize('Phone Number') }}" value="{{ $user->phone }}"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="label-input-field">
                                            <label>{{ localize('Alternative Phone') }}</label>
                                            <input type="text" name="alternative_phone"
                                                placeholder="{{ localize('Your Alternative Phone') }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="label-input-field">
                                            <label>{{ localize('Additional Info') }}</label>
                                            <textarea rows="3" type="text" name="additional_info"
                                                placeholder="{{ localize('Type your additional informations here') }}"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- personal information -->

                            <!-- payment methods -->
                            <h4 class="mt-7">{{ localize('Payment Method') }}</h4>
                            @include('frontend.default.pages.checkout.inc.paymentMethods')
                            <!-- payment methods -->
                        </div>
                    </div>
                    <!-- form data -->

                    <!-- order summary -->
                    <div class="col-xl-4">
                        <div class="checkout-sidebar">
                            @include('frontend.default.pages.partials.checkout.orderSummary', [
                                'carts' => $carts,
                            ])
                        </div>
                    </div>
                    <!-- order summary -->
                </div>
            </div>
        </div>
    </form>
    <!--checkout form end-->


    <!--add address modal start-->
    @include('frontend.default.inc.addressForm', ['countries' => $countries])
    <!--add address modal end-->
@endsection
