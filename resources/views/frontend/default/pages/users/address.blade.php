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
                            <a href="javascript:void(0);" onclick="addNewAddress()" class="fw-semibold"><i
                                    class="fas fa-plus me-1"></i> {{ localize('Add Address') }}</a>
                        </div>
                        <div class="row g-4">
                            @forelse ($addresses as $address)
                                <div class="col-md-6">
                                    <div
                                        class="tt-address-content border p-3 rounded address-book-content pe-md-4 position-relative">
                                        <div class="address tt-address-info position-relative">
                                            <!-- address -->
                                            @include('frontend.default.inc.address', [
                                                'address' => $address,
                                            ])
                                            <!-- address -->

                                            <div class="tt-edit-address position-absolute">
                                                <a href="javascript:void(0);" onclick="editAddress({{ $address->id }})"
                                                    class="pe-1">{{ localize('Edit') }}</a>

                                                <a href="javascript:void(0);"
                                                    data-url="{{ route('address.delete', $address->id) }}"
                                                    onclick="deleteAddress(this)"
                                                    class="text-danger">{{ localize('Delete') }}</a>
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


        <!--add address modal start-->
        @include('frontend.default.inc.addressForm', ['countries' => $countries])
        <!--add address modal end-->

    </section>
@endsection
