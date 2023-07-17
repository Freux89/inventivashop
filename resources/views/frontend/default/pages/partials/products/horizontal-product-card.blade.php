<div class="horizontal-product-card d-sm-flex align-items-center p-3 bg-white rounded-2 border card-md gap-4">
    <div class="thumbnail position-relative rounded-2">
        <a href="javascript:void(0);"><img src="{{ uploadedAsset($product->thumbnail_image) }}" alt="product"
                class="img-fluid"></a>
        <div
            class="product-overlay position-absolute start-0 top-0 w-100 h-100 d-flex align-items-center justify-content-center gap-1 rounded-2">
            @if (Auth::check() && Auth::user()->user_type == 'customer')
                <a href="javascript:void(0);" class="rounded-btn fs-xs" onclick="addToWishlist({{ $product->id }})"><i
                        class="fa-regular fa-heart"></i></a>
            @elseif(!Auth::check())
                <a href="javascript:void(0);" class="rounded-btn fs-xs" onclick="addToWishlist({{ $product->id }})"><i
                        class="fa-regular fa-heart"></i></a>
            @endif

            <a href="javascript:void(0);" class="rounded-btn fs-xs"
                onclick="showProductDetailsModal({{ $product->id }})"><i class="fa-solid fa-eye"></i></a>

        </div>
    </div>
    <div class="card-content mt-4 mt-sm-0 w-100">
        <a href="{{ route('products.show', $product->slug) }}"
            class="fw-bold text-heading title fs-sm tt-line-clamp tt-clamp-1">{{ $product->collectLocalization('name') }}</a>
        <div class="pricing mt-2">
            @include('frontend.default.pages.partials.products.pricing', [
                'product' => $product,
                'onlyPrice' => true,
            ])
        </div>

        @php
            $isVariantProduct = 0;
            $stock = 0;
            if ($product->variations()->count() > 1) {
                $isVariantProduct = 1;
            } else {
                $stock = $product->variations[0]->product_variation_stock ? $product->variations[0]->product_variation_stock->stock_qty : 0;
            }
        @endphp

        @if ($isVariantProduct)
            <div class="d-flex justify-content-between align-items-center mt-10">
                <span class="flex-grow-1">
                    <a href="javascript:void(0);" class="fs-xs fw-bold mt-10 d-inline-block explore-btn"
                        onclick="showProductDetailsModal({{ $product->id }})">{{ localize('Buy Now') }}<span
                            class="ms-1"><i class="fa-solid fa-arrow-right"></i></span></a>
                </span>

                @if (getSetting('enable_reward_points') == 1)
                    <span class="fs-xxs fw-bold" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-title="{{ localize('Reward Points') }}">
                        <i class="fas fa-medal"></i> {{ $product->reward_points }}
                    </span>
                @endif


            </div>
        @else
            <form action="" class="direct-add-to-cart-form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="product_variation_id" value="{{ $product->variations[0]->id }}">
                <input type="hidden" value="1" name="quantity">

                <div class="d-flex justify-content-between align-items-center mt-10">
                    <span class="flex-grow-1">
                        @if (!$isVariantProduct && $stock < 1)
                            <a href="javascript:void(0);" class="fs-xs fw-bold d-inline-block explore-btn">
                                {{ localize('Out of Stock') }}
                                <span class="ms-1"><i class="fa-solid fa-arrow-right"></i></span>
                            </a>
                        @else
                            <a href="javascript:void(0);" onclick="directAddToCartFormSubmit(this)"
                                class="fs-xs fw-bold d-inline-block explore-btn direct-add-to-cart-btn">
                                <span class="add-to-cart-text">{{ localize('Buy Now') }}</span>
                                <span class="ms-1"><i class="fa-solid fa-arrow-right"></i></span>
                            </a>
                        @endif
                    </span>

                    @if (getSetting('enable_reward_points') == 1)
                        <span class="fs-xxs fw-bold" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-title="{{ localize('Reward Points') }}">
                            <i class="fas fa-medal"></i> {{ $product->reward_points }}
                        </span>
                    @endif
                </div>
            </form>
        @endif

    </div>
</div>
