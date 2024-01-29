@extends('frontend.default.layouts.master')

@section('title')
{{ localize('Customer Addresses') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
<section class="my-account pt-6 pb-120">
    <div class="container">

        @include('frontend.default.pages.users.partials.customerHero')

        <div class="row g-4">
            <div class="col-xl-3">
                @include('frontend.default.pages.users.partials.customerSidebar')
            </div>

            <div class="col-xl-9">
                <div class="address-book bg-white rounded p-5">

                    <div class="d-flex justify-content-between">
                        <h4 class="mb-5">{{ localize('Address Book') }}</h4>
                    </div>
                    <div class="row g-4">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" id="addressTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="shipping-tab" data-bs-toggle="tab" href="#shipping" role="tab" aria-controls="shipping" aria-selected="true">{{ localize('Indirizzi di spedizione') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="billing-tab" data-bs-toggle="tab" href="#billing" role="tab" aria-controls="billing" aria-selected="false">{{ localize('Indirizzi di fatturazione') }}</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                                <!-- Qui inserisci il contenuto per gli indirizzi di spedizione -->
                                <div class="row g-4">
                                <a href="javascript:void(0);" onclick="addNewAddress('shipping')" class="fw-semibold text-end"><i class="fas fa-plus me-1"></i> {{ localize('Aggiungi indirizzo di spedizione') }}</a>

                                    @forelse ($addresses->filter(function ($address) {
                                    return $address->document_type == 0;
                                    }) as $address)
                                    <div class="col-md-6">
                                        <div class="tt-address-content border p-3 rounded address-book-content pe-md-4 position-relative">
                                            <div class="address tt-address-info position-relative">
                                                <!-- address -->
                                                @include('frontend.default.inc.address', [
                                                'address' => $address,
                                                ])
                                                <!-- address -->

                                                <div class="tt-edit-address position-absolute">
                                                    <a href="javascript:void(0);" onclick="editAddress({{ $address->id }})" class="tt-edit-address checkout-radio-link position-absolute feather-icon" style="top: 10px; right: 34px;">
                                                        <i data-feather="edit-3" class="me-2"></i>
                                                    </a>
                                                    <!-- delete icon -->
                                                    <a href="javascript:void(0);" onclick="deleteAddress(this)" data-url="{{ route('address.delete', $address->id) }}" class="tt-delete-address checkout-radio-link position-absolute feather-icon" style="top: 10px; right: 10px;">
                                                        <i data-feather="trash" class="me-2"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <p>{{ localize('No shipping addresses found.') }}</p>
                                    @endforelse
                                </div>
                            </div>
                            <div class="tab-pane fade" id="billing" role="tabpanel" aria-labelledby="billing-tab">
                                <!-- Qui inserisci il contenuto per gli indirizzi di fatturazione -->
                                <div class="row g-4">
                                <a href="javascript:void(0);" onclick="addNewAddress('billing')" class="fw-semibold text-end"><i class="fas fa-plus me-1"></i> {{ localize('Aggiungi indirizzo di fatturazione') }}</a>

                                @forelse ($addresses->filter(function ($address) {
                                    return $address->document_type > 0;
                                    }) as $address)
                                    <div class="col-md-6">
                                        <div class="tt-address-content border p-3 rounded address-book-content pe-md-4 position-relative">
                                            <div class="address tt-address-info position-relative">
                                                <!-- address -->
                                                @include('frontend.default.inc.address', [
                                                'address' => $address,
                                                ])
                                                <!-- address -->

                                                <div class="tt-edit-address position-absolute">

                                                    <a href="javascript:void(0);" onclick="editAddress({{ $address->id }})" class="tt-edit-address checkout-radio-link position-absolute feather-icon" style="top: 10px; right: 34px;">
                                                        <i data-feather="edit-3" class="me-2"></i>
                                                    </a>
                                                    <!-- delete icon -->
                                                    <a href="javascript:void(0);" onclick="deleteAddress(this)" data-url="{{ route('address.delete', $address->id) }}" class="tt-delete-address checkout-radio-link position-absolute feather-icon" style="top: 10px; right: 10px;">
                                                        <i data-feather="trash" class="me-2"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--add address modal start-->
    @include('frontend.default.inc.addressForm', ['countries' => $countries])
    <!--add address modal end-->

</section>
@endsection