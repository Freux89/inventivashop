@forelse ($carts as $cart)
<tr>
    <td class="h-100px">
        <img src="{{ uploadedAsset($cart->product_variations->first()->product->thumbnail_image) }}" alt="{{ $cart->product_variations->first()->product->collectLocalization('name') }}" class="img-fluid" width="100">
    </td>
    <td class="text-start product-title">
        <h6 class="mb-0">{{ $cart->product_variations->first()->product->collectLocalization('name') }}</h6>
        <ul style="margin: 0; padding-left: 0; list-style-type: none;">
            @foreach ($cart->product_variations as $product_variation)
            <li style="margin: 0; padding: 0; font-size: 0.85em;">
                {{ $product_variation->variation_name }}: {{ $product_variation->variation_value_name }}
            </li>
            @endforeach
        </ul>
    </td>
    <td>
        <span class="text-dark fw-bold me-2 d-lg-none">{{ localize('Unit Price') }}:</span>
        <span class="text-dark fw-bold">
            {{ formatPrice(variationDiscountedPrice($cart->product_variations->first()->product, $cart->product_variations)) }}
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
            {{ formatPrice(variationDiscountedPrice($cart->product_variations->first()->product, $cart->product_variations) * $cart->qty) }}
        </span>
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