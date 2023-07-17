@php
    $itemPrefix = null;
    for ($i = 0; $i < $subCategory->level; $i++) {
        $itemPrefix .= '▸';
    }
@endphp
<option value="{{ $subCategory->id }}"
    @isset($product_categories)
        {{ $product_categories->contains($subCategory->id) ? 'selected' : '' }} @endisset
    @isset($coupon_categories)
        @if (!is_null($coupon_categories)) {{ $coupon_categories->contains($subCategory->id) ? 'selected' : '' }} @endif
        @endisset>
    {{ $itemPrefix . ' ' . $subCategory->collectLocalization('name') }}</option>
@if ($subCategory->categories)
    @foreach ($subCategory->categories as $childCategory)
        @include('backend.pages.products.products.subCategory', ['subCategory' => $childCategory])
    @endforeach
@endif
