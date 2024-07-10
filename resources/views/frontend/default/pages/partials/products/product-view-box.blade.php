<div class="gstore-product-quick-view bg-white rounded-3 py-6 px-4">
    @include('frontend.default.pages.products.inc.breadcrumb')
    <div class="row g-4">
        <div class="col-xl-6 position-relative">
            <div class="product-info pe-md-4">

                <h1 class="mt-80 mb-3">{{ $product->collectLocalization('name') }}</h1>
                <div class="mb-3 description-short">
                    {{ $product->collectLocalization('short_description') }}
                </div>
            </div>

        </div>
        <div class="col-xl-6 align-self-end">
            <!-- sliders -->
            @include('frontend.default.pages.partials.products.sliders', compact('product'))
            <!-- sliders -->
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="line-below-title mt-0 mb-5"></div>



            <form action="" class="add-to-cart-form" id="addToCartForm">
                @php
                $isVariantProduct = 0;
                $stock = 0;
                if ($product->variations()->count() > 1) {
                $isVariantProduct = 1;
                } else {
                $stock = $product->variations[0]->product_variation_stock ? $product->variations[0]->product_variation_stock->stock_qty : 0;
                }
                @endphp

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="indicativeDeliveryDays" value="{{$indicativeDeliveryDays}}">
                <input type="hidden" name="product_variation_id" @if (!$isVariantProduct) value="{{ $product->variations[0]->id }}" @endif>

                <!-- variations -->
                <div id="variants-container">
                    @include('frontend.default.pages.partials.products.variations', compact('product'))
                </div>

                <!-- variations -->

                <div class="d-flex align-items-center gap-3 flex-wrap mt-5">
                    <div class="product-qty qty-increase-decrease d-flex align-items-center">
                        <button type="button" class="decrease">-</button>
                        <input type="text" readonly value="1" name="quantity" min="1" @if (!$isVariantProduct) max="{{ $stock }}" @endif>
                        <button type="button" class="increase">+</button>
                    </div>

                    <!-- <button type="submit" class="btn btn-secondary btn-md add-to-cart-btn" @if (!$isVariantProduct && $stock < 1) disabled @endif>
                        <span class="me-2">
                            <i class="fa-solid fa-bag-shopping"></i>
                        </span>
                        <span class="add-to-cart-text">
                            @if (!$isVariantProduct && $stock < 1) {{ localize('Out of Stock') }} @else {{ localize('Add to Cart') }} @endif </span>
                    </button>

                    <button type="button" class="btn btn-primary btn-md" onclick="addToWishlist({{ $product->id }})">
                        <i class="fa-solid fa-heart"></i>
                    </button> -->

                    <div class="flex-grow-1"></div>
                    @if (getSetting('enable_reward_points') == 1)
                    <span class="fw-bold" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ localize('Reward Points') }}">
                        <i class="fas fa-medal"></i> {{ $product->reward_points }}
                    </span>
                    @endif
                </div>

                <!--product category start-->
                @if ($product->categories()->count() > 0)
                <div class="tt-category-tag mt-4">
                    @foreach ($product->categories as $category)
                    <a href="{{ route('category.show', ['categorySlug' => $category->slug]) }}" class="text-muted fs-xxs">{{ $category->collectLocalization('name') }}</a>
                    @endforeach
                </div>
                @endif
                <!--product category end-->
            </form>
        </div>
        <div class="col-4">
            <div class="summary-box mt-5 d-none d-lg-block">
                <div class="h3 title py-3 px-4">{{localize('Preventivo')}}</div>

                <div class="box-pricing">
                    <!-- pricing -->
                    <div class="pricing all-pricing">
                        @php
                        $stock = productStock($product);
                        $indicativeDeliveryDays = isset($indicativeDeliveryDays) ? $indicativeDeliveryDays : 0;
                        $netPrice = formatPrice(productNetPrice($product));
                        $unit = $product->unit ? $product->unit->collectLocalization('name') : '';
                        $tax = formatPrice(productNetPrice($product) * 0.22);
                        $basePrice = productBasePrice($product);
                        $discountedBasePrice = discountedProductBasePrice($product);
                        $maxPrice = productMaxPrice($product);
                        $discountedMaxPrice = discountedProductMaxPrice($product);
                        @endphp

                        @include('frontend.default.pages.partials.products.recap-body', [
                        'stock' => $stock,
                        'indicativeDeliveryDays' => $indicativeDeliveryDays,
                        'netPrice' => $netPrice,
                        'unit' => $unit,
                        'tax' => $tax,
                        'basePrice' => $basePrice,
                        'discountedBasePrice' => $discountedBasePrice,
                        'maxPrice' => $maxPrice,
                        'discountedMaxPrice' => $discountedMaxPrice,
                        ])

                    </div>

                    <!-- selected variation pricing -->
                    <div class="pricing variation-pricing mt-2 d-none">

                    </div>
                    <!-- selected variation pricing -->
                </div>
                <div class="d-flex justify-content-centerpb-4 px-4 pb-6">
                    <button type="button" onclick="document.getElementById('addToCartForm').requestSubmit();" class="btn btn-primary btn-md add-to-cart-btn w-100">
                        <span class="me-2">
                            <i class="fa-solid fa-bag-shopping"></i>
                        </span>
                        <span class="add-to-cart-text">
                            Aggiungi al Carrello
                        </span>
                    </button>
                </div>

            </div>
            <div class="summary-box-variants d-none d-lg-block pb-4">
                @include('frontend.default.pages.partials.products.summary-box-variants')
            </div>
        </div>
    </div>


</div>