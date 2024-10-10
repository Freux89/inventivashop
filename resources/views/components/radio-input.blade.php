
<div class="checkout-radio d-flex bg-white rounded pe-4">
    <div class="theme-radio">
        <input type="radio" name="{{ $name }}" id="{{ $id }}" value="{{ $value }}" @if(isset($countryId)) data-country_id="{{ $countryId }}" @endif @if(isset($onchange)) onchange="{{ $onchange }}" @endif @if(isset($onload)) onload="{{ $onload }}" @endif {{ $checked ? 'checked' : '' }}>
        <span class="custom-radio me-2"></span>
    </div>
    <div class="ms-3">
    @if(isset($label) && $label)
            <label for="{{ $id }}" class="mb-0 align-self-center">
                {{ $label }}
            </label>
        @endif
        @if(isset($mutedText))
            <small class="text-muted d-block">
                {{ $mutedText }}
            </small>
        @endif
    </div>
</div>
