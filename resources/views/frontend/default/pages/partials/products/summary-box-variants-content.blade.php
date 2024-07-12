@if(isset($productVariations) && $productVariations->isNotEmpty())
@foreach($productVariations as $variation)
<div class="variant">
    <strong>{{ $variation->variation_name }}</strong>
    <div>{{ $variation->variation_value_name }}</div>
</div>
@endforeach
@else
<div class="variant">
@isset($variations)
    @foreach ($variations as $variation)
        @php
            // Filtra i valori delle varianti
            $filteredValues = array_filter($variation['values'], function ($value) use ($conditionEffects) {
                return !in_array($value['id'], $conditionEffects);
            });
        @endphp

        @if(!empty($filteredValues))
            <strong>{{ $variation['name'] }}</strong>
             <div>{{ $filteredValues['0']['name'] }}</div>
        @endif
    @endforeach
@endisset
</div>
@endif