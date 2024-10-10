@extends('frontend.default.layouts.masterCheckout')

@section('title')
{{ localize('Checkout') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection



@section('contents')
<!--breadcrumb-->

<!--breadcrumb-->

<!--checkout form start-->
<div class="content-wrapper-small">
    <form class="checkout-form" action="{{ route('checkout.complete') }}" method="POST">
        @csrf
        <div class="checkout-section ptb-120">
            <div class="container">
                <div class="row g-4">
                    <!-- form data -->
                    <div class="col-xl-7">
                        <div class="checkout-steps">
                            <div class="d-flex flex-row align-items-start gap-4 mb-8">

                                <x-radio-input
                                    name="delivery_method"
                                    id="shipping"
                                    value="shipping"
                                    label="{{ localize('Spediamo noi') }}"
                                    :checked="true" />
                                 <x-radio-input
                                    name="delivery_method"
                                    id="pickup"
                                    value="pickup"
                                    label="{{ localize('Ritiro in sede') }}"
                                    mutedText="{{ getSetting('site_address') }}"
                                    :checked="false" />

                            </div>

                            <div id="shipping-address">
    <div class="d-flex justify-content-between">
        <h3 class="mb-3">{{ localize('Shipping Address') }}</h3>
        <a href="javascript:void(0);" onclick="addNewAddress('shipping')" class="fw-semibold">
            <i class="fas fa-plus me-1"></i> {{ localize('Add Address') }}
        </a>
    </div>
    <div class="accordion" id="shippingAddressAccordion">
        <div class="row g-4">
            @php
            $defaultAddress = $addresses->where('is_default', true)->first();
            $defaultAddressId = old('shipping_address_id', $defaultAddress ? $defaultAddress->id : ($addresses->isNotEmpty() ? $addresses->first()->id : null));

            $filteredAddresses = $addresses->filter(function ($address) {
                return $address->document_type == 0;
            })->values();
            @endphp

            @forelse ($filteredAddresses as $key => $address)
                <div class="col-12">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-{{ $address->id }}">
                            <div class="tt-address-content d-flex align-items-center justify-content-between bg-white rounded px-4 py-4 position-relative">
                                <!-- Radio Button -->
                                <x-radio-input 
                                    name="shipping_address_id" 
                                    id="shipping-{{ $address->id }}" 
                                    value="{{ $address->id }}" 
                                    onchange="getLogistics({{ $address->country_id }})"
                                    data-country_id="{{ $address->country_id }}"
                                    :checked="old('shipping_address_id') == $address->id ? true : ($defaultAddressId == $address->id ? true : ($key === 0 ? true : false))"
                                    :countryId="$address->country_id" />

                                <!-- Address Information -->
                                <div class="ms-3 d-flex flex-grow-1">
                                    @include('frontend.default.inc.address', ['address' => $address])
                                </div>

                                <!-- Edit and Delete Icons -->
                                <div class="d-flex align-items-center">
                                    <a href="javascript:void(0);" 
                                        class="tt-edit-address checkout-radio-link feather-icon me-3 p-0" 
                                        
                                        onclick="openAccordionForEditAddress({{ $address->id }})">
                                        <i data-feather="edit-3"></i>
                                    </a>
                                    <a href="javascript:void(0);" onclick="deleteAddress(this)" data-url="{{ route('address.delete', $address->id) }}" class="tt-delete-address checkout-radio-link feather-icon p-0">
                                        <i data-feather="trash"></i>
                                    </a>
                                </div>
                            </div>
                        </h2>
                        <div id="collapse-{{ $address->id }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $address->id }}" data-bs-parent="#shippingAddressAccordion">
                            <div class="accordion-body">
                               
                                 <!-- Il contenuto del form sarà caricato qui tramite AJAX -->
                              
                            </div>
                        </div>
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
    </div>
</div>



                            <!-- checkout-logistics -->
                            <div class="checkout-logistics"></div>
                            <!-- checkout-logistics -->

                            <!-- Selezionare se si vuole l'imballo inventivashop oppure anonimo con radio -->
                            <div class="d-flex justify-content-between mt-7">
                                <h4 class="mb-3">{{ localize('Mittente') }}</h4>
                            </div>
                            <!-- 2 Radio input tra inventivashop oppure anonimo -->
                            <input type="radio" class="tt-custom-radio" name="packaging_type" id="packaging-1" value="Inventivashop" checked>
                            <label for="packaging-1"> {{ localize('InventivaShop') }}</label>
                            <input type="radio" class="tt-custom-radio" name="packaging_type" id="packaging-2" value="Anonimo">
                            <label for="packaging-2"> {{ localize('Anonimo') }}</label>



                            <!-- billing address -->

                            <div class="d-flex justify-content-between align-items-center mb-3 mt-7">

                                <h4>{{ localize('Billing Address') }}</h4>
                                <div class="invoice-request">
                                    <span class="me-2">{{ localize('Desideri ricevere la fattura?') }}</span>
                                    <input type="radio" id="invoice-yes" name="invoice_request" value="1" class="tt-custom-radio" onclick="toggleBillingAddresses(true);saveInvoicePreference('1')">
                                    <label for="invoice-yes" class="me-2">{{ localize('Si') }}</label>
                                    <input type="radio" id="invoice-no" name="invoice_request" value="0" class="tt-custom-radio" checked onclick="toggleBillingAddresses(false);saveInvoicePreference('0')">
                                    <label for="invoice-no">{{ localize('No') }}</label>
                                </div>

                            </div>
                            <div id="billing-addresses-container" class="row g-4" style="display: none;">
                                <div class="col-12 text-end">
                                    <a href="javascript:void(0);" onclick="addNewAddress('billing')" class="fw-semibold mt-2"><i class="fas fa-plus me-1"></i> {{ localize('Add Address') }}</a>

                                </div>
                                <div class="row g-4">
                                    @forelse ($addresses->filter(function ($address) {
                                    return $address->document_type > 0;
                                    }) as $address)
                                    <div class="col-lg-6 col-sm-6">
                                        <div class="tt-address-content">
                                            <input type="radio" class="tt-custom-radio" name="billing_address_id" id="billing-{{ $address->id }}" value="{{ $address->id }}" @if ($address->is_default) checked @endif>

                                            <label for="billing-{{ $address->id }}" class="tt-address-info bg-white rounded p-4 position-relative">
                                                <!-- address -->
                                                @include('frontend.default.inc.address', [
                                                'address' => $address,
                                                ])
                                                <!-- address -->
                                                <a href="javascript:void(0);" onclick="editAddress({{ $address->id }})" class="tt-edit-address checkout-radio-link position-absolute feather-icon" style="top: 10px; right: 34px;">
                                                    <i data-feather="edit-3" class="me-2"></i>
                                                </a>
                                                <!-- delete icon -->
                                                <a href="javascript:void(0);" onclick="deleteAddress(this)" data-url="{{ route('address.delete', $address->id) }}" class="tt-delete-address checkout-radio-link position-absolute feather-icon" style="top: 10px; right: 10px;">
                                                    <i data-feather="trash" class="me-2"></i>
                                                </a>
                                            </label>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="col-12 mt-5">
                                        <div class="tt-address-content">
                                            <div class="alert alert-secondary text-center">
                                                {{ localize('Aggiungi il tuo indirizzo di fatturazione') }}
                                            </div>
                                        </div>
                                    </div>
                                    @endforelse
                                </div>

                            </div>

                            <!-- billing address -->

                            <!-- Delivery Time -->
                            @if (getSetting('enable_scheduled_order') == 1)
                            <h4 class="mt-7 mb-3">{{ localize('Preferred Delivery Time') }}</h4>
                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="tt-address-content">
                                        <input type="radio" class="tt-custom-radio" name="shipping_delivery_type" id="regular-shipping" value="regular" checked>
                                        <label for="regular-shipping" class="tt-address-info bg-white rounded p-4 position-relative">
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
                                        <input type="radio" class="tt-custom-radio" name="shipping_delivery_type" id="scheduled-shipping" value="scheduled">

                                        <label for="scheduled-shipping" class="tt-address-info bg-white rounded p-4 position-relative">
                                            <div class="row flex-wrap justify-content-between align-items-center">
                                                <div class="col-12 col-md-4 mb-2 mb-md-0">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ localize('Scheduled Delivery') }}
                                                </div>

                                                <div class="col-auto d-flex flex-grow-1 align-items-center justify-content-between">

                                                    @php
                                                    $date = date('Y-m-d');
                                                    $dateCount = 7;
                                                    if (getSetting('allowed_order_days') != null) {
                                                    $dateCount = getSetting('allowed_order_days');
                                                    }
                                                    @endphp

                                                    <select class="form-select py-1 me-3" name="scheduled_date">
                                                        @for ($i = 1; $i <= $dateCount; $i++) @php $addDay=strtotime($date . '+' . $i . ' days' ); @endphp <option value="{{ strtotime($date . '+' . $i . ' days') }}">
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
                            @else
                            <input type="hidden" class="tt-custom-radio" name="shipping_delivery_type" id="regular-shipping" value="regular" checked>
                            @endif
                            <!-- personal information -->
                            <h4 class="mt-7">{{ localize('Personal Information') }}</h4>
                            <div class="checkout-form mt-3 p-5 bg-white rounded-2">
                                <div class="row g-4">
                                    <div class="col-sm-6">
                                        <div class="label-input-field">
                                            <label>{{ localize('Phone') }}</label>
                                            <input type="text" name="phone" placeholder="{{ localize('Phone Number') }}" value="{{ $user->phone }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="label-input-field">
                                            <label>{{ localize('Alternative Phone') }}</label>
                                            <input type="text" name="alternative_phone" placeholder="{{ localize('Your Alternative Phone') }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="label-input-field">
                                            <label>{{ localize('Additional Info') }}</label>
                                            <textarea rows="3" type="text" name="additional_info" placeholder="{{ localize('Type your additional informations here') }}"></textarea>
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
                    <div class="col-xl-5">
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
</div>



<!--add address modal start-->
@include('frontend.default.inc.addressForm', ['countries' => $countries])
<!--add address modal end-->

@endsection