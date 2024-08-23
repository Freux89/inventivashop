
@if (count($combinations) > 0)
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
            $lastOptionId = null;
            @endphp
            @foreach ($combinations as $key => $combination)
            @php
            $name = '';
            $variation_key = '';
            $lstKey = array_key_last($combination);

            foreach ($combination as $option_id => $choice_id) {
            if ($option_id === "data") {
            continue; // Salta questa iterazione se la chiave è "data"
            }

            if ($lastOptionId !== $option_id) {
            // Stampa il nome della variante
            $option_name = \App\Models\Variation::find($option_id)->collectLocalization('name');
            echo "<tr><td colspan='4'><strong>" . $option_name . "</strong></td></tr>";
            $lastOptionId = $option_id; // Aggiorna l'ultimo ID della variante
        }
            $choice_name = \App\Models\VariationValue::find($choice_id)->collectLocalization('name');

            $name .= $choice_name;
            $variation_key .= $option_id . ':' . $choice_id . '/';


            }
            $existing_data = $combination['data'] ?? null;
            @endphp
            <tr class="variant">
                <td>
                    <input type="text" value="{{ $name }}" class="form-control" disabled>
                    <input type="hidden" value="{{ $variation_key }}" name="variations[{{ $key }}][variation_key]">
                </td>
                <td>
                    <input type="number" step="0.01" name="variations[{{ $key }}][price]" value="{{ $existing_data['price'] ?? 0 }}" min="0" class="form-control" required>
                </td>
                 <td>
                    <input style="display:none;" type="number" name="variations[{{ $key }}][stock]" value="{{ $existing_data['stock'] ?? 0 }}" min="0" class="form-control" required>
                
                    <select name="variations[{{ $key }}][price_change_type]" class="form-control">
                        <option value="amount" {{ ($existing_data['price_change_type'] ?? '') == 'amount' ? 'selected' : '' }}>{{ localize('Amount on price') }}</option>
                        <option value="replace" {{ ($existing_data['price_change_type'] ?? '') == 'replace' ? 'selected' : '' }}>{{ localize('Replace') }}</option>
                        <option value="percent" {{ ($existing_data['price_change_type'] ?? '') == 'percent' ? 'selected' : '' }}>{{ localize('Percentage') }}</option>
                    </select>
                    <input type="text" name="variations[{{ $key }}][sku]" value="{{ $existing_data['sku'] ?? $name }}" class="form-control" style="display:none;">
                </td>
                <td>
                    <input type="text" name="variations[{{ $key }}][code]" value="{{ $existing_data['code'] ?? $name }}" class="form-control text-lowercase" style="display:none;">
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif