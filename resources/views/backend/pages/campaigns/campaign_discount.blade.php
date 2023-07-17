@foreach ($product_ids as $key => $id)
    @php
        $product = \App\Models\Product::findOrFail($id);
    @endphp
    <tr>
        <td class="align-middle">
            <div class="from-group d-flex align-items-center">
                <div class="avatar avatar-sm">
                    <img class="rounded-circle" src="{{ uploadedAsset($product->thumbnail_image) }}" alt="avatar" />
                </div>
                <h6 class="fs-sm mb-0 ms-2">{{ $product->collectLocalization('name') }}
                </h6>
            </div>
        </td>
        <td class="align-middle">
            <span>{{ formatPrice($product->min_price) }}</span>
        </td>
        <td class="align-middle">
            <input type="number" lang="en" name="discount_{{ $id }}"
                value="{{ $product->discount_value }}" min="0" step="0.001" class="form-control" required>
        </td>
        <td class="align-middle">
            <select class="form-control select2" name="discount_type_{{ $id }}" data-toggle="select2">
                <option value="percent">{{ localize('Percent %') }}</option>
                <option value="flat">{{ localize('Fixed') }}</option>
            </select>
        </td>
    </tr>
@endforeach
