<div class="border bg-light-subtle rounded p-2">
    <table class="table tt-footable tt-footable-border-0">
        <thead>
            <tr>
                <th>
                    <label for="" class="control-label">{{ localize('Variation') }}</label>
                </th>
                <th data-breakpoints="xs sm">
                    <label for="" class="control-label">{{ localize('Price') }}</label>
                </th>
                <!-- <th data-breakpoints="xs sm" style="display:none;">
                    <label for="" class="control-label">{{ localize('Quantity') }}</label>
                </th> -->
                <th data-breakpoints="xs sm">
                    <label for="" class="control-label">{{ localize('Effetto sul Prezzo') }}</label>
                </th>

            </tr>
        </thead>

        <tbody>
            @php
            $currentVariationId = null;
            @endphp
            @foreach ($variations as $key => $variation)
            @php
            $name = '';
            $code_array = array_filter(explode('/', $variation->variation_key));
            $lstKey = array_key_last($code_array);


            $newVariationId = explode(':', $code_array[0])[0];

            if ($newVariationId != $currentVariationId) {
            $currentVariationId = $newVariationId;
            $option_name = \App\Models\Variation::find($currentVariationId)->collectLocalization('name');
            echo "<tr>
                <td colspan='5'><strong>{$option_name}</strong></td>
            </tr>";
            }

            foreach ($code_array as $key2 => $comb) {
            $comb = explode(':', $comb);

            $option_name = \App\Models\Variation::find($comb[0])->collectLocalization('name');
            $choice_name = \App\Models\VariationValue::find($comb[1])->collectLocalization('name');

            $name .= $choice_name;

            if ($lstKey != $key2) {
            $name .= '-';
            }
            }
            @endphp

            <tr class="variant">
                <td>
                    <input type="text" value="{{ $name }}" class="form-control" disabled>
                    <input type="hidden" value="{{ $variation->variation_key }}" name="variations[{{ $key }}][variation_key]">
                </td>
                <td>
                    <input type="number" step="0.01" name="variations[{{ $key }}][price]" min="0" class="form-control" value="{{ $variation->price }}" required>
                </td>
                <td>
                    <input style="display:none;" type="number" name="variations[{{ $key }}][stock]" value="{{ $variation->product_variation_stock ? $variation->product_variation_stock->stock_qty : 0 }}" min="0" class="form-control" required>
                
                    <select name="variations[{{ $key }}][price_change_type]" class="form-control">
                        <option value="replace" {{ $variation->price_change_type == 'replace' ? 'selected' : '' }}>{{ localize('Replace') }}</option>
                        <option value="amount" {{ $variation->price_change_type == 'amount' ? 'selected' : '' }}>{{ localize('Amount on price') }}</option>
                        <option value="percent" {{ $variation->price_change_type == 'percent' ? 'selected' : '' }}>{{ localize('Percentage') }}</option>
                    </select>
                    <input type="text" name="variations[{{ $key }}][sku]" value="{{ $variation->sku }}" value="SKU" class="form-control" style="display:none">
                </td>
                <td>
                    <input type="text" name="variations[{{ $key }}][code]" value="{{ $variation->code }}" value="code" class="form-control" style="display:none">
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>