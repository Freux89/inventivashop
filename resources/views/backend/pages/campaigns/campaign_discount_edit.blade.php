@if (count($product_ids) > 0)
    <div class="border bg-light-subtle rounded p-2 mb-2">

        <table class="table tt-footable">
            <thead>
                <tr>
                    <td width="40%" class="align-middle">
                        <span>{{ localize('Product') }}</span>
                    </td>
                    <td data-breakpoints="xs sm md" width="10%" class="align-middle">
                        <span>{{ localize('Base Price') }}</span>
                    </td>
                    <td data-breakpoints="xs sm md" class="align-middle">
                        <span>{{ localize('Discount') }}</span>
                    </td>
                    <td data-breakpoints="xs sm md" class="align-middle">
                        <span>{{ localize('Discount Type') }}</span>
                    </td>
                </tr>
            </thead>
            <tbody>
                @foreach ($product_ids as $key => $id)
                    @php
                        $product = \App\Models\Product::findOrFail($id);
                        $campaign_product = \App\Models\CampaignProduct::where('campaign_id', $campaign_id)
                            ->where('product_id', $product->id)
                            ->first();
                    @endphp
                    <tr>
                        <td>
                            <div class="form-group d-flex align-items-center">
                                <div class="avatar avatar-sm">
                                    <img class="rounded-circle" src="{{ uploadedAsset($product->thumbnail_image) }}"
                                        alt="avatar" />
                                </div>
                                <h6 class="fs-sm mb-0 ms-2">{{ $product->collectLocalization('name') }}
                                </h6>
                            </div>
                        </td>
                        <td>
                            <span>{{ formatPrice($product->min_price) }}</span>
                        </td>
                        <td>
                            <input type="number" lang="en" name="discount_{{ $id }}"
                                value="{{ $product->discount_value }}" min="0" step="0.001"
                                class="form-control" required>
                        </td>
                        <td>
                            <select class="form-control select2" data-toggle="select2"
                                name="discount_type_{{ $id }}">
                                <option value="percent" <?php if ($product->discount_type == 'percent') {
                                    echo 'selected';
                                } ?>>{{ localize('Percent %') }}</option>
                                <option value="flat" <?php if ($product->discount_type == 'flat') {
                                    echo 'selected';
                                } ?>>{{ localize('Fixed') }}</option>
                            </select>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
