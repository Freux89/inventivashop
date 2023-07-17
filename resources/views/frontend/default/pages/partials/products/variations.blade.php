@if (count(generateVariationOptions($product->variation_combinations)) > 0)
    @foreach (generateVariationOptions($product->variation_combinations) as $variation)
        <input type="hidden" name="variation_id[]" value="{{ $variation['id'] }}" class="variation-for-cart">
        <input type="hidden" name="product_id" value="{{ $product->id }}">

        <div class="d-flex align-items-center justify-content-between">
            <div class="fs-sm">
                <span class="heading-font fw-medium me-1">{{ $variation['name'] }}
            </div>
        </div>

        <ul
            class="product-radio-btn mt-1 mb-3 d-flex align-items-center gap-2 @if ($loop->last) mb-6 @endif">
            @if ($variation['id'] != 2)
                @foreach ($variation['values'] as $value)
                    <li>
                        <input type="radio" name="variation_value_for_variation_{{ $variation['id'] }}"
                            value="{{ $value['id'] }}" id="val-{{ $value['id'] }}">
                        <label for="val-{{ $value['id'] }}">{{ $value['name'] }}</label>
                    </li>
                @endforeach
            @else
                <!-- color -> id=2 -->
                <div class="position-relative me-n4">
                    @foreach ($variation['values'] as $value)
                        <li>
                            <input type="radio" name="variation_value_for_variation_{{ $variation['id'] }}"
                                value="{{ $value['id'] }}" id="val-{{ $value['id'] }}">
                            <label for="val-{{ $value['id'] }}" class="px-1 py-2">
                                <span class="px-3 py-2 rounded" style="background-color:{{ $value['code'] }}">
                                </span>
                            </label>

                        </li>
                    @endforeach
                </div>
                <!-- color -> id=2 -->
            @endif
        </ul>
    @endforeach
@endif
