<div class="col-6 shutdown-value-select-div">
    
    <select class="form-control shutdown-variant-value-select" name="condition[{{ $conditionIndex }}][action][{{ $actionIndex }}][shutdownVariantValue][]" multiple required>
    <option value="All"  {{ isset($applyToAll) && $applyToAll ? 'selected' : '' }}>Tutti i valori</option>

        @foreach($values as $value)
        <option value="{{ $value['variation_value_id'] }}" {{ isset($selectedValuesId) && in_array($value['variation_value_id'], $selectedValuesId->toArray()) ? 'selected' : '' }}>
            {{ $value['value_name'] }}
        </option>
        @endforeach
    </select>
    <!-- Checkbox per specificare il comportamento di disabilitazione -->
<div class="col-12 mt-3">
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="disableVariationValuesCheck_{{ $conditionIndex }}_{{ $actionIndex }}" name="condition[{{ $conditionIndex }}][action][{{ $actionIndex }}][disableVariationValues]" value="1" {{ isset($disableVariationValues) && $disableVariationValues ? 'checked' : '' }}>
        <label class="form-check-label" for="disableVariationValuesCheck_{{ $conditionIndex }}_{{ $actionIndex }}">
            {{ localize('Disabilita i valori varianti invece di renderli opachi') }}
        </label>
    </div>
    <small class="text-muted">{{ localize('Se "Tutti i valori" è selezionato, l\'intera variante sarà disabilitata.') }}</small>
</div>

</div>