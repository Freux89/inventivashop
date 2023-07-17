@php
    $itemPrefix = null;
    for ($i = 0; $i < $subCategory->level; $i++) {
        $itemPrefix .= '▸';
    }
@endphp
<option value="{{ $subCategory->id }}" {{ $subCategory->id == $category->parent_id ? 'selected' : '' }}
    @isset($navbar_categories)
    {{ in_array($subCategory->id, $navbar_categories) ? 'selected' : '' }}
    @endisset>
    {{ $itemPrefix . ' ' . $subCategory->collectLocalization('name') }}</option>

@if ($subCategory->categories)
    @foreach ($subCategory->categories()->orderBy('sorting_order_level', 'desc')->where('id', '!=', $category->id)->get() as $childCategory)
        @include('backend.pages.products.categories.subCategory', ['subCategory' => $childCategory])
    @endforeach
@endif
