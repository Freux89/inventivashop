@if (count($combinations[0]) > 0)
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
                    <th data-breakpoints="xs sm">
                        <label for="" class="control-label">{{ localize('Stock') }} <small
                                class="text-warning">({{ localize('Default Location') }})</small></label>
                    </th>
                    <th data-breakpoints="xs sm">
                        <label for="" class="control-label">{{ localize('SKU') }}</label>
                    </th>
                    <th data-breakpoints="xs sm">
                        <label for="" class="control-label">{{ localize('Code') }}</label>
                    </th>
                </tr>
            </thead>

            <tbody>
                @foreach ($combinations as $key => $combination)
                    @php
                        $name = '';
                        $variation_key = '';
                        $lstKey = array_key_last($combination);
                        
                        foreach ($combination as $option_id => $choice_id) {
                            $option_name = \App\Models\Variation::find($option_id)->collectLocalization('name');
                            $choice_name = \App\Models\VariationValue::find($choice_id)->collectLocalization('name');
                        
                            $name .= $choice_name;
                            $variation_key .= $option_id . ':' . $choice_id . '/';
                        
                            if ($lstKey != $option_id) {
                                $name .= '-';
                            }
                        }
                    @endphp
                    <tr class="variant">
                        <td>
                            <input type="text" value="{{ $name }}" class="form-control" disabled>

                            <input type="hidden" value="{{ $variation_key }}"
                                name="variations[{{ $key }}][variation_key]">
                        </td>
                        <td>
                            <input type="number" step="0.01" name="variations[{{ $key }}][price]"
                                value="0" min="0" class="form-control" required>
                        </td>
                        <td>
                            <input type="number" name="variations[{{ $key }}][stock]" value="0"
                                min="0" class="form-control" required>
                        </td>
                        <td>
                            <input type="text" name="variations[{{ $key }}][sku]"
                                value="{{ $name }}" class="form-control">
                        </td>

                        <td>
                            <input type="text" name="variations[{{ $key }}][code]"
                                value="{{ $name }}" class="form-control text-lowercase">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
