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
                    <a href="{{ route('category.show', ['categorySlug' => $category->slug]) }}"
                        class="d-inline-block text-muted fs-xxs">{{ $category->collectLocalization('name') }}
                        @if (!$loop->last)
                            ,
                        @endif
                    </a>
                @endforeach
            @endif
        </div>
        <!--product category end-->

        <div class="h5 mb-2">
            <a href="{{ route('products.show', $product->slug) }}"
                class="card-title fw-semibold mb-2 tt-line-clamp tt-clamp-1">{{ $product->collectLocalization('name') }}
            </a>
        </div>
        <div class="card-description">
{{$product->collectLocalization('short_description') }}
</div>
        <h6 class="price">
            @include('frontend.default.pages.partials.products.pricing', [
                'product' => $product,
                'br' => true,
            ])
        </h6>

        @php
            $isVariantProduct = 0;
            $stock = 0;
            if ($product->variations()->count() > 1) {
                $isVariantProduct = 1;
            } else {
                $stock = $product->variations[0]->product_variation_stock ? $product->variations[0]->product_variation_stock->stock_qty : 0;
            }
        @endphp

       
            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-secondary btn-sm border-secondary mt-4"
                >{{ localize('Apri') }}</a>


    </div>
</div>
