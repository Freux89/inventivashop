<div class="vertical-product-card rounded-2 position-relative d-md-flex align-items-center bg-white hr-product">

    @php
        $discountPercentage = discountPercentage($product);
    @endphp

    @if ($discountPercentage > 0)
        <span class="offer-badge text-white fw-bold fs-xxs bg-danger position-absolute start-0 top-0">
            -{{ discountPercentage($product) }}% <span class="text-uppercase">{{ localize('Off') }}</span>
        </span>
    @endif


    <div class="thumbnail position-relative text-center p-4 flex-shrink-0">
        <img src="{{ uploadedAsset($product->thumbnail_image) }}" alt="{{ $product->collectLocalization('name') }}"
            class="img-fluid">
    </div>
    <div class="card-content w-100">

        @if (getSetting('enable_reward_points') == 1)
            <span class="fs-xxs fw-bold" data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-title="{{ localize('Reward Points') }}">
                <i class="fas fa-medal"></i> {{ $product->reward_points }}
            </span>
        @endif

        <!--product category start-->
        <div class="mb-2 tt-category tt-line-clamp tt-clamp-1">
            @if ($product->categories()->count() > 0)
                @foreach ($product->categories as $category)
                    <a href="{{ route('products.index') }}?&category_id={{ $category->id }}"
                        class="d-inline-block text-muted fs-xxs">{{ $category->collectLocalization('name') }}
                        @if (!$loop->last)
                            ,
                        @endif
                    </a>
                @endforeach
            @endif
        </div>
        <!--product category end-->

        <h3 class="h5 mb-2">
            <a href="{{ route('products.show', $product->slug) }}"
                class="card-title fw-semibold mb-2 tt-line-clamp tt-clamp-1">{{ $product->collectLocalization('name') }}
            </a>
        </h3>

        <h6 class="price">
            @include('frontend.default.pages.partials.products.pricing', [
                'product' => $product,
                'br' => true,
            ])
        </h6>


        {{-- @isset($showSold) --}}
        <div class="card-progressbar mt-3 mb-2 rounded-pill">
            <span class="card-progress bg-primary" data-progress="{{ sellCountPercentage($product) }}%"
                style="width: {{ sellCountPercentage($product) }}%;"></span>
        </div>
        <p class="mb-0 fw-semibold">{{ localize('Total Sold') }}: <span
                class="fw-bold text-secondary">{{ $product->total_sale_count }}/{{ $product->sell_target }}</span></p>
        {{-- @endisset --}}

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
            <a href="javascript:void(0);" class="btn btn-outline-secondary btn-sm border-secondary mt-4"
                onclick="showProductDetailsModal({{ $product->id }})">{{ localize('Add to Cart') }}</a>
        @else
            <form action="" class="direct-add-to-cart-form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="product_variation_id" value="{{ $product->variations[0]->id }}">
                <input type="hidden" value="1" name="quantity">

                @if (!$isVariantProduct && $stock < 1)
                    <a href="javascript:void(0);" class="btn btn-outline-secondary btn-sm border-secondary mt-4">
                        {{ localize('Out of Stock') }}</a>
                @else
                    <a href="javascript:void(0);" onclick="directAddToCartFormSubmit(this)"
                        class="btn btn-outline-secondary btn-sm border-secondary mt-4 direct-add-to-cart-btn add-to-cart-text">{{ localize('Add to Cart') }}</a>
                @endif
            </form>
        @endif


    </div>
</div>
