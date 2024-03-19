
<div class="col-6">
    <label class="value-label">Ha come valore:</label>
    <select class="form-control variant-value-select" name="condition[{{ $conditionIndex }}][variantValue]" required>
        <option value="">Seleziona valore:</option>
        @foreach($values as $value)
        <option value="{{ $value['product_variation_id'] }}"  @if( $value['product_variation_id'] == $selectedValueId) selected @endif >{{ $value['value_name'] }}</option>
        @endforeach
    </select>
</div>

