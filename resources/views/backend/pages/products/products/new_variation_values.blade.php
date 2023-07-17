<select class="form-control select2" name="option_{{ $variation_id }}_choices[]" multiple required
    onchange="generateVariationCombinations()" data-placeholder="Select variation values">
    @foreach ($variation_values as $key => $variation_value)
        <option value="{{ $variation_value->id }}">{{ $variation_value->collectLocalization('name') }}</option>
    @endforeach
</select>
