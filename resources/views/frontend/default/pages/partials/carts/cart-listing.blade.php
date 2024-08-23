@forelse ($carts as $cart)
<tr>
    <td class="h-100px">
    @if($cart->product_variations->first() && $cart->product && $cart->product->deleted_at == null)

        <img src="{{ uploadedAsset($cart->product->thumbnail_image) }}" alt="{{ $cart->product->collectLocalization('name') }}" class="img-fluid" width="100">
    @endif
    </td>
    <td class="text-start product-title">
    @if($cart->product_variations->first() && $cart->product)

        <h6 class="mb-0">{{ $cart->product->collectLocalization('name') }}</h6>
        <ul style="margin: 0; padding-left: 0; list-style-type: none;">
      
            @foreach ($cart->product_variations as $product_variation)
            <li style="margin: 0; padding: 0; font-size: 0.85em;">
                {{ $product_variation->variation_name }}: {{ $product_variation->variation_value_name }}
            </li>
            @endforeach
        </ul>
    @else
    <span>Prodotto non disponibile</span>
    @endif
    </td>
    <td>
        <span class="text-dark fw-bold me-2 d-lg-none">{{ localize('Unit Price') }}:</span>
        <span class="text-dark fw-bold">
        @if($cart->product_variations->first() && $cart->product )

            {{ formatPrice(variationDiscountedPrice($cart->product, $cart->product_variations,true,$cart->qty )) }}
            @endif
        </span>
    </td>
    <td>
        <div class="product-qty d-inline-flex align-items-center">
            <button class="decrese" onclick="handleCartItem('decrease',{{ $cart->id }})">-</button>
            <input type="text" readonly value="{{ $cart->qty }}">
            <button class="increase" onclick="handleCartItem('increase', {{ $cart->id }})">+</button>
        </div>
    </td>
    <td>
        <span class="text-dark fw-bold me-2 d-lg-none">{{ localize('Total Price') }}:</span>
        <span class="text-dark fw-bold">
        @if($cart->product_variations->first() && $cart->product && $cart->product->deleted_at == null)

            {{ formatPrice(variationDiscountedPrice($cart->product, $cart->product_variations,true,$cart->qty) * $cart->qty) }}
        </span>
        @endif
    </td>
    <td>
        <span class="text-dark fw-bold me-2 d-lg-none">{{ localize('Delete') }}:</span>
        <span class="text-dark fw-bold">
            <button type="button" class="close-btn ms-3" onclick="handleCartItem('delete', {{ $cart->id }})">
                <i class="fas fa-close"></i>
            </button>
        </span>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="py-4">{{ localize('No data found') }}</td>
</tr>
@endforelse