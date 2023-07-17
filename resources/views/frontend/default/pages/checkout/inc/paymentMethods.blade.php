<!--COD-->
@if (getSetting('enable_cod') == 1)
    <div class="checkout-radio d-flex align-items-center justify-content-between gap-3 bg-white rounded p-4 mt-3">
        <div class="radio-left d-inline-flex align-items-center">
            <div class="theme-radio">
                <input type="radio" name="payment_method" id="cod" value="cod" required>
                <span class="custom-radio"></span>
            </div>
            <label for="cod" class="ms-2 h6 mb-0">{{ localize('Cash on delivery') }}
                ({{ localize('COD') }})</label>
        </div>
        <div class="radio-right text-end">
            <img src="{{ staticAsset('frontend/pg/cod.svg') }}" alt="cod" class="img-fluid">
        </div>
    </div>
@endif

<!--wallet-->
@if (getSetting('enable_wallet_checkout') == 1)
    <div class="checkout-radio d-flex align-items-center justify-content-between gap-3 bg-white rounded p-4 mt-3">
        <div class="radio-left d-inline-flex align-items-center">
            <div class="theme-radio">
                <input type="radio" name="payment_method" id="wallet" value="wallet" required>
                <span class="custom-radio"></span>
            </div>
            <label for="wallet" class="ms-2 h6 mb-0">{{ localize('Wallet Payment') }}
                <small>({{ localize('Balance') }}:
                    {{ formatPrice(auth()->user()->user_balance) }})</small></label>
        </div>
        <div class="radio-right text-end">
            <img src="{{ staticAsset('frontend/pg/wallet.svg') }}" alt="wallet" class="img-fluid">
        </div>
    </div>
@endif

<!--Paypal-->
@if (getSetting('enable_paypal') == 1)
    <div class="checkout-radio d-flex align-items-center justify-content-between gap-3 bg-white rounded p-4 mt-3">
        <div class="radio-left d-inline-flex align-items-center">
            <div class="theme-radio">
                <input type="radio" name="payment_method" id="paypal" value="paypal" required>
                <span class="custom-radio"></span>
            </div>
            <label for="paypal" class="ms-2 h6 mb-0">{{ localize('Pay with Paypal') }}</label>
        </div>
        <div class="radio-right text-end">
            <img src="{{ staticAsset('frontend/pg/paypal.svg') }}" alt="paypal" class="img-fluid">
        </div>
    </div>
@endif

<!--Stripe-->
@if (getSetting('enable_stripe') == 1)
    <div class="checkout-radio d-flex align-items-center justify-content-between gap-3 bg-white rounded p-4 mt-3">
        <div class="radio-left d-inline-flex align-items-center">
            <div class="theme-radio">
                <input type="radio" name="payment_method" id="stripe" value="stripe" required>
                <span class="custom-radio"></span>
            </div>
            <label for="stripe" class="ms-2 h6 mb-0">{{ localize('Pay with Stripe') }}</label>
        </div>
        <div class="radio-right text-end">
            <img src="{{ staticAsset('frontend/pg/stripe.svg') }}" alt="stripe" class="img-fluid">
        </div>
    </div>
@endif

<!--PayTm-->
@if (getSetting('enable_paytm') == 1)
    <div class="checkout-radio d-flex align-items-center justify-content-between gap-3 bg-white rounded p-4 mt-3">
        <div class="radio-left d-inline-flex align-items-center">
            <div class="theme-radio">
                <input type="radio" name="payment_method" id="paytm" value="paytm" required>
                <span class="custom-radio"></span>
            </div>
            <label for="paytm" class="ms-2 h6 mb-0">{{ localize('Pay with PayTm') }}</label>
        </div>
        <div class="radio-right text-end">
            <img src="{{ staticAsset('frontend/pg/paytm.svg') }}" alt="paytm" class="img-fluid">
        </div>
    </div>
@endif

<!--Razorpay-->
@if (getSetting('enable_razorpay') == 1)
    <div class="checkout-radio d-flex align-items-center justify-content-between gap-3 bg-white rounded p-4 mt-3">
        <div class="radio-left d-inline-flex align-items-center">
            <div class="theme-radio">
                <input type="radio" name="payment_method" id="razorpay" value="razorpay" required>
                <span class="custom-radio"></span>
            </div>
            <label for="razorpay" class="ms-2 h6 mb-0">{{ localize('Pay with Razorpay') }}</label>
        </div>
        <div class="radio-right text-end">
            <img src="{{ staticAsset('frontend/pg/razorpay.svg') }}" alt="razorpay" class="img-fluid">
        </div>
    </div>
@endif

<!--iyzico-->
@if (getSetting('enable_iyzico') == 1)
    <div class="checkout-radio d-flex align-items-center justify-content-between gap-3 bg-white rounded p-4 mt-3">
        <div class="radio-left d-inline-flex align-items-center">
            <div class="theme-radio">
                <input type="radio" name="payment_method" id="iyzico" value="iyzico" required>
                <span class="custom-radio"></span>
            </div>
            <label for="iyzico" class="ms-2 h6 mb-0">{{ localize('Pay with IyZico') }}</label>
        </div>
        <div class="radio-right text-end">
            <img src="{{ staticAsset('frontend/pg/iyzico.svg') }}" alt="iyzico" class="img-fluid">
        </div>
    </div>
@endif
