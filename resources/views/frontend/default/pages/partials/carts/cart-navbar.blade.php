@forelse ($carts as $cart)
@php
$firstVariation = $cart->product_variations->first();
@endphp


<li class="d-flex align-items-center pb-3 @if (!$loop->first) pt-3 @endif">
    <div class="thumb-wrapper">
       
        <a href="{{ route('products.show', $cart->product->slug) }}">
            <img src="{{ uploadedAsset($cart->product->thumbnail_image) }}" alt="products" class="img-fluid rounded-circle">
        </a>
       
    </div>
    <div class="items-content ms-3">
       
        <a href="{{ route('products.show', $cart->product->slug) }}">
            <h6 class="mb-0">{{ $cart->product->collectLocalization('name') }}</h6>
        </a>

        @foreach ($cart->product_variations as $product_variation)
        <!-- Adesso visualizza le informazioni per ogni variante del prodotto. -->
        <!-- Qui puoi mostrare i dettagli delle varianti. Ad esempio, potresti avere un metodo nella tua ProductVariation model che restituisce i dettagli delle varianti. -->
        @endforeach

      

        <div class="products_meta mt-1 d-flex align-items-center">
            @if($firstVariation && $cart->product && $cart->product->deleted_at == null)

            <span class="price text-primary fw-semibold">{{ formatPrice(variationDiscountedPrice($cart->product, $cart->product_variations, true ,$cart->qty)) }}</span>
            @else
            <span>Prodotto non disponibile</span>
            @endif
            <span class="count fs-semibold">x {{ $cart->qty }}</span>
            <button class="remove_cart_btn ms-2" onclick="handleCartItem('delete', {{ $cart->id }})"><i class="fa-solid fa-trash-can"></i></button>
        </div>
    </div>
</li>
@empty
<li>
    <img src="{{ staticAsset('frontend/default/assets/img/empty-cart.svg') }}" alt="" srcset="" class="img-fluid">
</li>
@endforelse