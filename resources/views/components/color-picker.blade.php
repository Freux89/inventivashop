<div>
    <label for="{{ $id }}">{{ $label }}</label>
    <div class="color-picker-button" data-id="{{ $id }}" style="background-color: {{ $value }}"></div>
    <input type="hidden" id="{{ $id }}" name="{{ $name }}" value="{{ $value }}">
</div>

<style>
    .pcr-button {
        width: 36px;
        height: 36px;
        border-radius: 4px;
        cursor: pointer;
        border: 1px solid #ddd;
    }
</style>