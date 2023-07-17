@foreach ($carts as $cart)
    <tr class="pos-cart-tr">
        <input type="hidden" name="product_variation_ids[]" value="{{ $cart->product_variation_id }}">
        <input type="hidden" name="quantities[]" class="pos-cart-qty" value="{{ $cart->qty }}">
        <td>
            <a class="d-flex align-items-center">
                <div class="avatar avatar-md">
                    <img class="rounded" src="{{ uploadedAsset($cart->product_variation->product->thumbnail_image) }}"
                        alt="" />
                </div>
                <div class="ms-2">
                    <h6 class="fs-sm mb-0 tt-line-clamp tt-clamp-1">
                        {{ $cart->product_variation->product->collectLocalization('name') }}
                    </h6>
                    @foreach (generateVariationOptions($cart->product_variation->combinations) as $variation)
                        <small class="text-muted">
                            @foreach ($variation['values'] as $value)
                                {{ $value['name'] }}
                            @endforeach
                            @if (!$loop->last)
                                ,
                            @endif
                        </small>
                    @endforeach
                </div>
            </a>
        </td>

        <td class="text-center">
            <div class="tt-num-block">
                <div class="tt-num-input">
                    <span class="tt-minus tt-dis"
                        onclick="handleQty({{ $cart->product_variation_id }}, 'decrease')"></span>
                    <input type="text" class="tt-in-num" value="{{ $cart->qty }}" readonly="">
                    <span class="tt-plus" onclick="handleQty({{ $cart->product_variation_id }}, 'increase')"></span>
                </div>
            </div>
        </td>

        <td>
            <div class="tt-tb-price fs-sm fw-semibold">
                <span
                    class="text-accent">{{ formatPrice(variationDiscountedPrice($cart->product_variation->product, $cart->product_variation) * $cart->qty) }}</span>
            </div>
        </td>

        <td class="text-end">
            <div class="d-flex align-items-center justify-content-end tt-pos-table-action">
                <button type="button" class="tt-deleat p-0 ms-2">
                    <i data-feather="trash-2" width="16"
                        onclick="deleteFromCart({{ $cart->product_variation_id }})"></i>
                </button>
            </div>
        </td>
    </tr>
@endforeach
