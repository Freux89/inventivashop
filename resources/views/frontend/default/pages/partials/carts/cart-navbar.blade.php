@forelse ($carts as $cart)
<li class="d-flex align-items-center pb-3 @if (!$loop->first) pt-3 @endif">
    <div class="thumb-wrapper">
        @if ($cart->product_variation && $cart->product_variation->product)
        <a href="{{ route('products.show', $cart->product_variation->product->slug) }}">
            <img src="{{ uploadedAsset($cart->product_variation->product->thumbnail_image) }}" alt="products" class="img-fluid rounded-circle">
        </a>
        @else
        <!-- Mostra qualcosa d'altro, o niente, quando il prodotto o la variante del prodotto non esiste -->
        @endif
    </div>
    <div class="items-content ms-3">
        @if ($cart->product_variation && $cart->product_variation->product)
        <a href="{{ route('products.show', $cart->product_variation->product->slug) }}">
            <h6 class="mb-0">{{ $cart->product_variation->product->collectLocalization('name') }}</h6>
        </a>
        @else
        <!-- Mostra qualcosa d'altro, o niente, quando il prodotto o la variante del prodotto non esiste -->
        @endif


        @if ($cart->product_variation && $cart->product_variation->product && $cart->product_variation->combinations)
        @foreach (generateVariationOptions($cart->product_variation->combinations) as $variation)
        <span class="fs-xs text-muted">
            @foreach ($variation['values'] as $value)
            {{ $value['name'] }}
            @endforeach
            @if (!$loop->last)
            ,
            @endif
        </span>
        @endforeach
        @else
        <!-- Mostra qualcosa d'altro, o niente, quando il prodotto, la variante del prodotto, o le combinazioni non esistono -->
        @endif


        <div class="products_meta mt-1 d-flex align-items-center">
            <div>
                @if ($cart->product_variation && $cart->product_variation->product)
                <span class="price text-primary fw-semibold">{{ formatPrice(variationDiscountedPrice($cart->product_variation->product, $cart->product_variation)) }}</span>
                @else
                <!-- Mostra qualcosa d'altro, o niente, quando il prodotto o la variante del prodotto non esiste -->
                @endif
                <span class="count fs-semibold">x {{ $cart->qty }}</span>
            </div>
            <button class="remove_cart_btn ms-2" onclick="handleCartItem('delete', {{ $cart->id }})"><i class="fa-solid fa-trash-can"></i></button>
        </div>
    </div>
</li>
@empty
<li>
    <img src="{{ staticAsset('frontend/default/assets/img/empty-cart.svg') }}" alt="" srcset="" class="img-fluid">
</li>
@endforelse