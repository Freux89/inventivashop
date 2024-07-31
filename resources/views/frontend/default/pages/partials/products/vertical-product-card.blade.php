
<div class="vertical-product-card rounded-2 position-relative swiper-slide {{ isset($bgClass) ? $bgClass : '' }}">
@php
    // Genera l'URL del prodotto
    $productUrl = empty($breadcrumbPath)
        ? route('products.show', ['slug' => $product->slug])
        : route('products.breadcrumb.show', ['any' => $breadcrumbPath, 'slug' => $product->slug]);
@endphp
    @php
        $discountPercentage = discountPercentage($product);
    @endphp

    @if ($discountPercentage > 0)
        <span class="offer-badge text-white fw-bold fs-xxs bg-danger position-absolute start-0 top-0">
            -{{ discountPercentage($product) }}% <span class="text-uppercase">{{ localize('Off') }}</span>
        </span>
    @endif

    <div class="thumbnail position-relative text-center p-4">
        <img src="{{ uploadedAsset($product->thumbnail_image) }}" alt="{{ $product->collectLocalization('name') }}"
            class="img-fluid">
        <div class="product-btns position-absolute d-flex gap-2 flex-column">
            @if (Auth::check() && Auth::user()->user_type == 'customer')
                <a href="javascript:void(0);" class="rounded-btn"><i class="fa-regular fa-heart"
                        onclick="addToWishlist({{ $product->id }})"></i></a>
            @elseif(!Auth::check())
                <a href="javascript:void(0);" class="rounded-btn"><i class="fa-regular fa-heart"
                        onclick="addToWishlist({{ $product->id }})"></i></a>
            @endif


            <a href="{{ $productUrl  }}" class="rounded-btn"><i
                    class="fa-regular fa-eye"></i></a>
        </div>
    </div>
    <div class="card-content">
        @if (getSetting('enable_reward_points') == 1)
            <span class="fs-xxs fw-bold" data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-title="{{ localize('Reward Points') }}">
                <i class="fas fa-medal"></i> {{ $product->reward_points }}
            </span>
        @endif
        

        <a href="{{ $productUrl  }}"
            class="card-title fw-semibold mb-2 tt-line-clamp tt-clamp-1">{{ $product->collectLocalization('name') }}
        </a>
        <ul class="star-rating fs-sm d-inline-flex justify-content-center text-warning">
                        {{ renderStarRatingFront(4, 5) }}
                    </ul>

        <div class="price mt-3">
            {{localize('da')}}
            <strong class="big-price">
            @include('frontend.default.pages.partials.products.pricing', [
                'product' => $product,
                'onlyPrice' => true,
            ])
            </strong>
          
        </div>


        @isset($showSold)
            <div class="card-progressbar mb-2 mt-3 rounded-pill">
                <span class="card-progress bg-primary" data-progress="{{ sellCountPercentage($product) }}%"
                    style="width: {{ sellCountPercentage($product) }}%;"></span>
            </div>
            <p class="mb-0 fw-semibold">{{ localize('Total Sold') }}: <span
                    class="fw-bold text-secondary">{{ $product->total_sale_count }}/{{ $product->sell_target }}</span>
            </p>
        @endisset


        @php
            $isVariantProduct = 0;
            $stock = 0;
            if ($product->variations()->count() > 1) {
                $isVariantProduct = 1;
            } else {
                $stock = $product->variations[0]->product_variation_stock ? $product->variations[0]->product_variation_stock->stock_qty : 0;
            }
        @endphp

        
            
        

    </div>
</div>
