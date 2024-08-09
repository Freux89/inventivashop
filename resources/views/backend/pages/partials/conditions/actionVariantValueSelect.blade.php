<div class="col-6 shutdown-value-select-div">
    
    <select class="form-control shutdown-variant-value-select" name="condition[{{ $conditionIndex }}][action][{{ $actionIndex }}][shutdownVariantValue][]" multiple required>
    <option value="All"  {{ isset($applyToAll) && $applyToAll ? 'selected' : '' }}>Tutti i valori</option>

        @foreach($values as $value)
        <option value="{{ $value['variation_value_id'] }}" {{ isset($selectedValuesId) && in_array($value['variation_value_id'], $selectedValuesId->toArray()) ? 'selected' : '' }}>
            {{ $value['value_name'] }}
        </option>
        @endforeach
    </select>
</div>