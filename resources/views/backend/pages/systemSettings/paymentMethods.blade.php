@extends('backend.layouts.master')

@section('title')
    {{ localize('Payment Methods Settings') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-lg-0">{{ localize('Payment Methods Settings') }}</h2>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!--left sidebar-->
                <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">
                    <form action="{{ route('admin.settings.updatePaymentMethods') }}" method="POST"
                        enctype="multipart/form-data" class="pb-650">
                        @csrf

                        <!--cod settings-->
                        <div class="card mb-4" id="section-1">
                            <div class="card-body">
                                <h5 class="mb-4">{{ localize('Cash On Delivery') }}</h5>
                                <input type="hidden" name="payment_methods[]" value="cod">
                                <div class="mb-3">
                                    <label class="form-label">{{ localize('Enable COD') }}</label>
                                    <select id="enable_cod" class="form-control select2" name="enable_cod"
                                        data-toggle="select2">
                                        <option value="0" {{ getSetting('enable_cod') == '0' ? 'selected' : '' }}>
                                            {{ localize('Disable') }}</option>
                                        <option value="1" {{ getSetting('enable_cod') == '1' ? 'selected' : '' }}>
                                            {{ localize('Enable') }}</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <!--cod settings-->


                        <!--paypal settings-->
                        <div class="card mb-4" id="section-2">
                            <div class="card-body">
                                <h5 class="mb-4">{{ localize('Paypal Credentials') }}</h5>
                                <input type="hidden" name="payment_methods[]" value="paypal">
                                <div class="mb-3">
                                    <label for="PAYPAL_CLIENT_ID"
                                        class="form-label">{{ localize('Paypal Client ID') }}</label>
                                    <input type="hidden" name="types[]" value="PAYPAL_CLIENT_ID">
                                    <input type="text" id="PAYPAL_CLIENT_ID" name="PAYPAL_CLIENT_ID" class="form-control"
                                        value="{{ env('PAYPAL_CLIENT_ID') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="PAYPAL_CLIENT_SECRET"
                                        class="form-label">{{ localize('Paypal Client Secret') }}</label>
                                    <input type="hidden" name="types[]" value="PAYPAL_CLIENT_SECRET">
                                    <input type="text" id="PAYPAL_CLIENT_SECRET" name="PAYPAL_CLIENT_SECRET"
                                        class="form-control" value="{{ env('PAYPAL_CLIENT_SECRET') }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">{{ localize('Enable Paypal') }}</label>
                                    <select id="enable_paypal" class="form-control select2" name="enable_paypal"
                                        data-toggle="select2">
                                        <option value="0" {{ getSetting('enable_paypal') == '0' ? 'selected' : '' }}>
                                            {{ localize('Disable') }}</option>
                                        <option value="1" {{ getSetting('enable_paypal') == '1' ? 'selected' : '' }}>
                                            {{ localize('Enable') }}</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">{{ localize('Enable Test Sandbox Mode') }}</label>
                                    <select id="paypal_sandbox" class="form-control select2" name="paypal_sandbox"
                                        data-toggle="select2">
                                        <option value="0" {{ getSetting('paypal_sandbox') == '0' ? 'selected' : '' }}>
                                            {{ localize('Disable') }}</option>
                                        <option value="1" {{ getSetting('paypal_sandbox') == '1' ? 'selected' : '' }}>
                                            {{ localize('Enable') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--paypal settings-->


                        <!--stripe settings-->
                        <div class="card mb-4" id="section-3">
                            <div class="card-body">
                                <h5 class="mb-4">{{ localize('Stripe Credentials') }}</h5>
                                <input type="hidden" name="payment_methods[]" value="stripe">
                                <div class="mb-3">
                                    <label for="STRIPE_KEY" class="form-label">{{ localize('Stripe Key') }}</label>
                                    <input type="hidden" name="types[]" value="STRIPE_KEY">
                                    <input type="text" id="STRIPE_KEY" name="STRIPE_KEY" class="form-control"
                                        value="{{ env('STRIPE_KEY') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="STRIPE_SECRET" class="form-label">{{ localize('Stripe Secret') }}</label>
                                    <input type="hidden" name="types[]" value="STRIPE_SECRET">
                                    <input type="text" id="STRIPE_SECRET" name="STRIPE_SECRET" class="form-control"
                                        value="{{ env('STRIPE_SECRET') }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">{{ localize('Enable Stripe') }}</label>
                                    <select id="enable_stripe" class="form-control select2" name="enable_stripe"
                                        data-toggle="select2">
                                        <option value="0" {{ getSetting('enable_stripe') == '0' ? 'selected' : '' }}>
                                            {{ localize('Disable') }}</option>
                                        <option value="1" {{ getSetting('enable_stripe') == '1' ? 'selected' : '' }}>
                                            {{ localize('Enable') }}</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <!--stripe settings-->

                        <!--paytm settings-->
                        <div class="card mb-4" id="section-4">
                            <div class="card-body">
                                <h5 class="mb-4">{{ localize('PayTm Credentials') }}</h5>
                                <input type="hidden" name="payment_methods[]" value="paytm">
                                <div class="mb-3">
                                    <label for="PAYTM_ENVIRONMENT"
                                        class="form-label">{{ localize('PayTm Environment') }}</label>
                                    <input type="hidden" name="types[]" value="PAYTM_ENVIRONMENT">
                                    <input type="text" id="PAYTM_ENVIRONMENT" name="PAYTM_ENVIRONMENT"
                                        class="form-control" value="{{ env('PAYTM_ENVIRONMENT') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="PAYTM_MERCHANT_ID"
                                        class="form-label">{{ localize('PayTm Merchant ID') }}</label>
                                    <input type="hidden" name="types[]" value="PAYTM_MERCHANT_ID">
                                    <input type="text" id="PAYTM_MERCHANT_ID" name="PAYTM_MERCHANT_ID"
                                        class="form-control" value="{{ env('PAYTM_MERCHANT_ID') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="PAYTM_MERCHANT_KEY"
                                        class="form-label">{{ localize('PayTm Merchant Key') }}</label>
                                    <input type="hidden" name="types[]" value="PAYTM_MERCHANT_KEY">
                                    <input type="text" id="PAYTM_MERCHANT_KEY" name="PAYTM_MERCHANT_KEY"
                                        class="form-control" value="{{ env('PAYTM_MERCHANT_KEY') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="PAYTM_MERCHANT_WEBSITE"
                                        class="form-label">{{ localize('PayTm Merchant Website') }}</label>
                                    <input type="hidden" name="types[]" value="PAYTM_MERCHANT_WEBSITE">
                                    <input type="text" id="PAYTM_MERCHANT_WEBSITE" name="PAYTM_MERCHANT_WEBSITE"
                                        class="form-control" value="{{ env('PAYTM_MERCHANT_WEBSITE') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="PAYTM_CHANNEL" class="form-label">{{ localize('PayTm Channel') }}</label>
                                    <input type="hidden" name="types[]" value="PAYTM_CHANNEL">
                                    <input type="text" id="PAYTM_CHANNEL" name="PAYTM_CHANNEL" class="form-control"
                                        value="{{ env('PAYTM_CHANNEL') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="PAYTM_INDUSTRY_TYPE"
                                        class="form-label">{{ localize('PayTm Industry Type') }}</label>
                                    <input type="hidden" name="types[]" value="PAYTM_INDUSTRY_TYPE">
                                    <input type="text" id="PAYTM_INDUSTRY_TYPE" name="PAYTM_INDUSTRY_TYPE"
                                        class="form-control" value="{{ env('PAYTM_INDUSTRY_TYPE') }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">{{ localize('Enable PayTm') }}</label>
                                    <select id="enable_paytm" class="form-control select2" name="enable_paytm"
                                        data-toggle="select2">
                                        <option value="0" {{ getSetting('enable_paytm') == '0' ? 'selected' : '' }}>
                                            {{ localize('Disable') }}</option>
                                        <option value="1" {{ getSetting('enable_paytm') == '1' ? 'selected' : '' }}>
                                            {{ localize('Enable') }}</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <!--paytm settings-->


                        <!--razorpay settings-->
                        <div class="card mb-4" id="section-5">
                            <div class="card-body">
                                <h5 class="mb-4">{{ localize('Razorpay Credentials') }}</h5>
                                <input type="hidden" name="payment_methods[]" value="razorpay">
                                <div class="mb-3">
                                    <label for="RAZORPAY_KEY" class="form-label">{{ localize('Razorpay Key') }}</label>
                                    <input type="hidden" name="types[]" value="RAZORPAY_KEY">
                                    <input type="text" id="RAZORPAY_KEY" name="RAZORPAY_KEY" class="form-control"
                                        value="{{ env('RAZORPAY_KEY') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="RAZORPAY_SECRET"
                                        class="form-label">{{ localize('Razorpay Secret') }}</label>
                                    <input type="hidden" name="types[]" value="RAZORPAY_SECRET">
                                    <input type="text" id="RAZORPAY_SECRET" name="RAZORPAY_SECRET"
                                        class="form-control" value="{{ env('RAZORPAY_SECRET') }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">{{ localize('Enable Razorpay') }}</label>
                                    <select id="enable_razorpay" class="form-control select2" name="enable_razorpay"
                                        data-toggle="select2">
                                        <option value="0"
                                            {{ getSetting('enable_razorpay') == '0' ? 'selected' : '' }}>
                                            {{ localize('Disable') }}</option>
                                        <option value="1"
                                            {{ getSetting('enable_razorpay') == '1' ? 'selected' : '' }}>
                                            {{ localize('Enable') }}</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <!--razorpay settings-->

                        <!--iyzico settings-->
                        <div class="card mb-4" id="section-6">
                            <div class="card-body">
                                <h5 class="mb-4">{{ localize('IyZico Credentials') }}</h5>
                                <input type="hidden" name="payment_methods[]" value="iyzico">
                                <div class="mb-3">
                                    <label for="IYZICO_API_KEY"
                                        class="form-label">{{ localize('IyZico API Key') }}</label>
                                    <input type="hidden" name="types[]" value="IYZICO_API_KEY">
                                    <input type="text" id="IYZICO_API_KEY" name="IYZICO_API_KEY" class="form-control"
                                        value="{{ env('IYZICO_API_KEY') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="IYZICO_SECRET_KEY"
                                        class="form-label">{{ localize('IyZico Secret Key') }}</label>
                                    <input type="hidden" name="types[]" value="IYZICO_SECRET_KEY">
                                    <input type="text" id="IYZICO_SECRET_KEY" name="IYZICO_SECRET_KEY"
                                        class="form-control" value="{{ env('IYZICO_SECRET_KEY') }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">{{ localize('Enable IyZico') }}</label>
                                    <select id="enable_iyzico" class="form-control select2" name="enable_iyzico"
                                        data-toggle="select2">
                                        <option value="0" {{ getSetting('enable_iyzico') == '0' ? 'selected' : '' }}>
                                            {{ localize('Disable') }}</option>
                                        <option value="1" {{ getSetting('enable_iyzico') == '1' ? 'selected' : '' }}>
                                            {{ localize('Enable') }}</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">{{ localize('Enable Test Sandbox Mode') }}</label>
                                    <select id="iyzico_sandbox" class="form-control select2" name="iyzico_sandbox"
                                        data-toggle="select2">
                                        <option value="0"
                                            {{ getSetting('iyzico_sandbox') == '0' ? 'selected' : '' }}>
                                            {{ localize('Disable') }}</option>
                                        <option value="1"
                                            {{ getSetting('iyzico_sandbox') == '1' ? 'selected' : '' }}>
                                            {{ localize('Enable') }}</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <!--iyzico settings-->


                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit">
                                <i data-feather="save" class="me-1"></i> {{ localize('Save Configuration') }}
                            </button>
                        </div>
                    </form>
                </div>

                <!--right sidebar-->
                <div class="col-xl-3 order-1 order-md-1 order-lg-1 order-xl-2">
                    <div class="card tt-sticky-sidebar">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Payment Methods Settings') }}</h5>
                            <div class="tt-vertical-step">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="#section-1" class="active">{{ localize('Cash On Delivery') }}</a>
                                    </li>
                                    <li>
                                        <a href="#section-2">{{ localize('Paypal Credentials') }}</a>
                                    </li>
                                    <li>
                                        <a href="#section-3">{{ localize('Stripe Credentials') }}</a>
                                    </li>
                                    <li>
                                        <a href="#section-4">{{ localize('PayTm Credentials') }}</a>
                                    </li>
                                    <li>
                                        <a href="#section-5">{{ localize('Razorpay Credentials') }}</a>
                                    </li>
                                    <li>
                                        <a href="#section-6">{{ localize('IyZico Credentials') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
