<div class="col-6 shutdown-value-select-div">
    <select class="form-control shutdown-variant-value-select" name="condition[{{ $conditionIndex }}][action][{{ $actionIndex }}][shutdownVariantValue][]" multiple required>
        <option value="">Tutti i valori</option>
        @foreach($values as $value)
        <option value="{{ $value['product_variation_id'] }}" {{ isset($selectedValuesId) && in_array($value['product_variation_id'], $selectedValuesId->toArray()) ? 'selected' : '' }}>
            {{ $value['value_name'] }}
        </option>
        @endforeach
    </select>
</div>