@if (count(generateVariationOptions($product->ordered_variation_combinations)) > 0)
@foreach (generateVariationOptions($product->ordered_variation_combinations) as $variation)

@php
    // Determina se tutti i valori sono disabilitati
    $allDisabled = true;
    foreach ($variation['values'] as $value) {
        if (!in_array($value['id'], $conditionEffects ?? [])) {
            $allDisabled = false;
            break;
        }
    }
@endphp

<input type="hidden" name="variation_id[]" value="{{ $variation['id'] }}" class="variation-for-cart">
<input type="hidden" name="product_id" value="{{ $product->id }}">

<div class="d-flex align-items-center justify-content-between">
    <div class="fs-sm">
        <span class="heading-font fw-medium me-1">{{ $variation['name'] }}
    </div>
</div>

@if ($variation['display_type'] == 'image')
<ul class="product-radio-btn mt-1 mb-3 d-flex align-items-center gap-2 @if ($loop->last) mb-6 @endif">
    @foreach ($variation['values'] as $value)
    <li>
        <input type="radio" name="variation_value_for_variation_{{ $variation['id'] }}" value="{{ $value['id'] }}" id="val-{{ $value['id'] }}" {{ in_array($value['id'], $variation_value_ids ?? []) ? 'checked' : '' }} {{ in_array($value['id'], $conditionEffects ?? []) ? 'disabled' : '' }}>
        <label for="val-{{ $value['id'] }}">{{ $value['name'] }}</label>
    </li>
    @endforeach
</ul>
@elseif ($variation['display_type'] == 'select')
<select name="variation_value_for_variation_{{ $variation['id'] }}" class="product-select form-control" {{ $allDisabled ? '' : 'required' }}>
<option value="">Seleziona</option>
    @foreach ($variation['values'] as $value)
    
    <option value="{{ $value['id'] }}" {{ in_array($value['id'], $variation_value_ids ?? []) ? 'selected' : '' }} {{ in_array($value['id'], $conditionEffects ?? []) ? 'disabled' : '' }}>{{ $value['name'] }}</option>
    @endforeach
</select>
@elseif ($variation['display_type'] == 'color')
<ul class="product-radio-btn mt-1 mb-3 d-flex align-items-center gap-2 @if ($loop->last) mb-6 @endif">
    <div class="position-relative me-n4">
        @foreach ($variation['values'] as $value)
        <li>
            <input type="radio" name="variation_value_for_variation_{{ $variation['id'] }}" value="{{ $value['id'] }}" id="val-{{ $value['id'] }}" {{ in_array($value['id'], $variation_value_ids ?? []) ? 'checked' : '' }} {{ in_array($value['id'], $conditionEffects ?? []) ? 'disabled' : '' }}>
            <label for="val-{{ $value['id'] }}" class="px-1 py-2">
                <span class="px-3 py-2 rounded" style="background-color:{{ $value['code'] }}">
                </span>
            </label>
        </li>
        @endforeach
    </div>
</ul>
@endif
@endforeach
@endif