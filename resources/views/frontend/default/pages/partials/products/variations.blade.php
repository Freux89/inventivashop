
@php
if(!isset($variations)){
    $variations = generateVariationOptions($product->ordered_variation_combinations);
}

@endphp

@if (count($variations) > 0)
<div class="loading-overlay d-none"></div>

<div class="h3 start-conf py-3 mb-9">
    Inizia la configurazione
</div>
@foreach ($variations as $variation)

@php
// Determina se tutti i valori sono disabilitati
$allDisabled = true;
foreach ($variation['values'] as $value) {
    if (!in_array($value['id'], $conditionEffects ?? [])) {
        $allDisabled = false;
        break;
    }
}

// Ordina i valori in modo che quelli disabilitati siano alla fine
if (isset($conditionEffects)) {
usort($variation['values'], function ($a, $b) use ($conditionEffects) {
    $aDisabled = in_array($a['id'], $conditionEffects ?? []);
    $bDisabled = in_array($b['id'], $conditionEffects ?? []);
    return $aDisabled <=> $bDisabled;
});
}
@endphp

@if (!$allDisabled)
<input type="hidden" name="variation_id[]" value="{{ $variation['id'] }}" class="variation-for-cart">
<input type="hidden" name="product_id" value="{{ $product->id }}">

<div class="variant-block" data-variation-id="{{ $variation['id'] }}">
<div class="d-flex align-items-center justify-content-between my-5">
<div class="variant-name">
            {{ $variation['name'] }}
        </div>
        @if ($variation['display_type'] == 'image')
        <div class="toggle-buttons" data-variation-id="{{ $variation['id'] }}">
    <button class="btn btn-link toggle-view d-flex align-items-center" type="button" data-action="show" data-variation-id="{{ $variation['id'] }}">
        Mostra tutti 
        <svg width="17" class="ms-2" id="f91a913a-7ce6-4238-be62-40c6cb9aeb7f" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80"><title>grid-variant</title><rect width="35.45" height="35.45" style="fill:#404647"/><rect x="44.55" width="35.45" height="35.45" style="fill:#404647"/><rect y="44.55" width="35.45" height="35.45" style="fill:#404647"/><rect x="44.55" y="44.55" width="35.45" height="35.45" style="fill:#404647"/></svg>
    </button>
    <button class="btn btn-link toggle-view d-flex align-items-center d-none" type="button" data-action="hide" data-variation-id="{{ $variation['id'] }}">
        Nascondi
        <svg width="17" class="ms-2" id="ad941f12-1f76-45af-aba9-f8aa061814de" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 35.45"><title>Senza titolo-1</title><rect width="35.45" height="35.45" style="fill:#404647"/><rect x="44.55" width="35.45" height="35.45" style="fill:#404647"/></svg>
    </button>
</div>
        @endif
</div>

@if ($variation['display_type'] == 'image')
<div class="swiper-container gallery-slider-block" data-variation-id="{{ $variation['id'] }}">
    <div class="swiper-wrapper">
    @foreach ($variation['values'] as $key => $value)
    @php
        $isDisabled = in_array($value['id'], $conditionEffects ?? []);
        $message = $motivationalMessages[$value['id']] ?? '';
        
    @endphp
    <div class="swiper-slide">
        <div class="gallery-item-block @if (in_array($value['id'], $variation_value_ids ?? []) || ($key === 0 && empty($variation_value_ids))) selected @endif @if ($isDisabled) disabled @endif" data-value-id="{{ $value['id'] }}" @if ($isDisabled && $message) data-bs-toggle="tooltip" title="{{ $message }}" @endif>
            <div class="picture-box" data-test="select-Substrate-{{ $value['name'] }}">
                <div class="inner">
                    @if($value['image'])
                    <img src="{{ uploadedAsset($value['image']) }}" class="img-fluid variant-image" alt="{{ $value['name'] }}">
                    @else
                    <img src="default-image-path.jpg" class="img-fluid variant-image" alt="{{ $value['name'] }}">
                    @endif
                </div>
            </div>
            <div class="product-radio-btn">
            <input type="radio" name="variation_value_for_variation_{{ $variation['id'] }}" value="{{ $value['id'] }}" id="val-{{ $value['id'] }}" {{ in_array($value['id'], $variation_value_ids ?? []) || ($key === 0 && empty($variation_value_ids)) ? 'checked' : '' }} {{ $isDisabled  ? 'disabled' : '' }}>

            </div>
            <label class="variant-label">{{ $value['name'] }}</label>
            @if($value['info_description'])
            <span class="info-icon" data-value-id="{{ $value['id'] }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="info-svg" viewBox="0 0 32 32" width="32px" height="32px">
                    <path d="M 16 3 C 8.832031 3 3 8.832031 3 16 C 3 23.167969 8.832031 29 16 29 C 23.167969 29 29 23.167969 29 16 C 29 8.832031 23.167969 3 16 3 Z M 16 5 C 22.085938 5 27 9.914063 27 16 C 27 22.085938 22.085938 27 16 27 C 9.914063 27 5 22.085938 5 16 C 5 9.914063 9.914063 5 16 5 Z M 15 10 L 15 12 L 17 12 L 17 10 Z M 15 14 L 15 22 L 17 22 L 17 14 Z"/>
                </svg>
            </span>
            @endif
        </div>
    </div>
    @endforeach
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>




<div class="grid-container d-none" data-variation-id="{{ $variation['id'] }}">
    @foreach ($variation['values'] as $key => $value)
    @php
        $isDisabled = in_array($value['id'], $conditionEffects ?? []);
        $message = $motivationalMessages[$value['id']] ?? '';
    @endphp
    <div class="grid-item mb-4 @if (in_array($value['id'], $variation_value_ids ?? []) || ($key === 0 && empty($variation_value_ids))) selected @endif @if ($isDisabled) disabled @endif" data-value-id="{{ $value['id'] }}" @if ($isDisabled && $message) data-bs-toggle="tooltip" title="{{ $message }}" @endif>
        <div class="gallery-item-block">
            <div class="picture-box" data-test="select-Substrate-{{ $value['name'] }}">
                <div class="inner">
                    @if($value['image'])
                    <img src="{{ uploadedAsset($value['image']) }}" class="img-fluid variant-image" alt="{{ $value['name'] }}">
                    @else
                    <img src="default-image-path.jpg" class="img-fluid variant-image" alt="{{ $value['name'] }}">
                    @endif
                </div>
            </div>
            <label class="variant-label">{{ $value['name'] }}</label>
            @if($value['info_description'])
            <span class="info-icon" data-value-id="{{ $value['id'] }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="info-svg" viewBox="0 0 32 32" width="32px" height="32px">
                    <path d="M 16 3 C 8.832031 3 3 8.832031 3 16 C 3 23.167969 8.832031 29 16 29 C 23.167969 29 29 23.167969 29 16 C 29 8.832031 23.167969 3 16 3 Z M 16 5 C 22.085938 5 27 9.914063 27 16 C 27 22.085938 22.085938 27 16 27 C 9.914063 27 5 22.085938 5 16 C 5 9.914063 9.914063 5 16 5 Z M 15 10 L 15 12 L 17 12 L 17 10 Z M 15 14 L 15 22 L 17 22 L 17 14 Z"/>
                </svg>
            </span>
            @endif
        </div>
    </div>
    @endforeach
</div>
<div id="grid-info-description">
    <button type="button" id="close-grid-info-description" ><i class="fa-regular fa-circle-xmark"></i></button>
    <div id="grid-info-description-content"></div>
</div>


@elseif ($variation['display_type'] == 'select')
<select name="variation_value_for_variation_{{ $variation['id'] }}" class="product-select form-control" {{ $allDisabled ? '' : 'required' }}>
   
    @foreach ($variation['values'] as $value)
    @php
        $isDisabled = in_array($value['id'], $conditionEffects ?? []);
        $message = $motivationalMessages[$value['id']] ?? '';
    @endphp
    <option value="{{ $value['id'] }}" {{ in_array($value['id'], $variation_value_ids ?? []) ? 'selected' : '' }} {{ $isDisabled  ? 'disabled' : '' }}>{{ $value['name'] }}</option>
    @endforeach
</select>
@endif
</div>
@endif

@endforeach
@endif


