<header class="gheader py-6">
    <div class="content-wrapper-small">
        <div class="gshop-navbar">
            <div class="row m-0 align-items-center">
                <div class="col-12 col-md-6 p-0 text-center text-md-start">
                    <a href="{{ route('home') }}" class="logo">
                        <img src="{{ uploadedAsset(getSetting('navbar_logo')) }}" alt="logo" class="img-fluid logo-light">
                    </a>
                </div>

                <div class="col-12 col-md-6 text-center text-md-end mt-6 mt-md-0">
                    <div class="checkout-steps d-flex align-items-center justify-content-center justify-content-md-end">
                        <!-- Step 1: Cart -->
                        <div class="step completed d-flex align-items-center mx-3 mx-md-0">
                            <a href="{{ route('carts.index') }}" class="d-flex align-items-center text-decoration-none">
                                <div class="step-icon rounded-circle d-flex justify-content-center align-items-center">
                                    &#10004;
                                </div>
                                <span class="ms-3">Carrello</span>
                            </a>
                        </div>
                        <!-- Line connecting steps -->
                        <div class="line mx-4 d-none d-md-block"></div>
                        <!-- Step 2: Checkout -->
                        <div class="step current d-flex align-items-center mx-3 mx-md-0">
                            <div class="step-icon rounded-circle d-flex justify-content-center align-items-center">
                                2
                            </div>
                            <span class="ms-3">Checkout</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
