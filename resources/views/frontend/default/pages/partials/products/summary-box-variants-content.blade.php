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
    <strong>{{$variation['name']}}</strong>
    <div>{{$variation['values'][0]['name']}}</div>
    @endforeach
    @endisset
</div>
@endif