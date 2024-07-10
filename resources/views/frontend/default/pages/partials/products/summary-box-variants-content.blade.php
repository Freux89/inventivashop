@if(isset($productVariations) && $productVariations->isNotEmpty())
    @foreach($productVariations as $variation)
        <div class="variant">
            <strong>{{ $variation->variation_name }}</strong>
            <div>{{ $variation->variation_value_name }}</div>
        </div>
    @endforeach
@else
    <div class="variant">
        Nessuna variante selezionata.
    </div>
@endif
