@if ($product->has_variation)
    <div class="border bg-light-subtle rounded p-2">
        <table class="table tt-footable tt-footable-border-0">
            <thead>
                <tr>
                    <th>
                        <label for="" class="control-label">{{ localize('Variation') }}</label>
                    </th>
                    <th data-breakpoints="xs sm">
                        <label for="" class="control-label">{{ localize('Stock') }}</label>
                    </th>
                </tr>
            </thead>

            <tbody>
                @foreach ($product->variations as $key => $variation)
                    @php
                        $name = '';
                        $code_array = array_filter(explode('/', $variation->variation_key));
                        $lstKey = array_key_last($code_array);
                        
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
                            <input type="hidden" value="{{ $variation->id }}" name="variationsIds[]">
                        </td>
                        <td>
                            @php
                                $stock = $variation
                                    ->product_variation_stock_without_location()
                                    ->where('location_id', $location_id)
                                    ->first();
                            @endphp

                            <input type="number" name="variationStocks[]" value="{{ $stock ? $stock->stock_qty : 0 }}"
                                value="0" min="0" class="form-control" required>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="mb-3">
        @php
            $first_variation = $product->variations->first();
            $first_variation_stock = $first_variation
                ->product_variation_stock_without_location()
                ->where('location_id', $location_id)
                ->first();
            
            $price = $first_variation->price;
            $stock_qty = 0;
            if ($first_variation_stock) {
                $stock_qty = $first_variation_stock->stock_qty;
            }
            $sku = $first_variation->sku;
        @endphp

        <div class="row g-3">
            <input type="hidden" name="product_variation_id" value="{{ $first_variation->id }}">
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="stock" class="form-label">{{ localize('Stock') }}</label>
                    <input type="number" id="stock" placeholder="{{ localize('Stock qty') }}" name="stock"
                        class="form-control" value="{{ $stock_qty }}" required>
                </div>
            </div>
        </div>
    </div>
@endif
