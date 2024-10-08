@if (productBasePrice($product) == discountedProductBasePrice($product))
    @if (productBasePrice($product) == productMaxPrice($product))
        <span class="fw-bold h4">{{ formatPrice(productBasePrice($product)) }}</span>
    @else
        <span class="fw-bold h4">{{ formatPrice(productBasePrice($product)) }}</span>
        <!-- -
        <span class="fw-bold h4 ">{{ formatPrice(productMaxPrice($product)) }}</span> -->
    @endif
@else
    @if (discountedProductBasePrice($product) == discountedProductMaxPrice($product))
        <span class="fw-bold h4 ">{{ formatPrice(discountedProductBasePrice($product)) }}</span>
    @else
        <span class="fw-bold h4 ">{{ formatPrice(discountedProductBasePrice($product)) }}</span>
        <!-- -
        <span class="fw-bold h4 ">{{ formatPrice(discountedProductMaxPrice($product)) }}</span> -->
    @endif

    @if (isset($br))
        <br>
    @endif

    @if (!isset($onlyPrice) || $onlyPrice == false)
        @if (productBasePrice($product) == productMaxPrice($product))
            <span
                class="fw-bold h4 deleted text-muted {{ isset($br) ? '' : 'ms-1' }}">{{ formatPrice(productBasePrice($product)) }}</span>
        @else
            <span
                class="fw-bold h4 deleted text-muted {{ isset($br) ? '' : 'ms-1' }}">{{ formatPrice(productBasePrice($product)) }}</span>
            <!-- -
            <span class="fw-bold h4 deleted text-muted ms-1">{{ formatPrice(productMaxPrice($product)) }}</span> -->
        @endif
    @endif
@endif

@if ($product->unit)
    <small>/{{ $product->unit->collectLocalization('name') }}</small>
@endif

<!-- Aggiungi qui il blocco per il tempo di consegna indicativo -->
@isset($indicativeDeliveryDays)
<div class="mt-2">
    <span class="fw-bold text-muted">Consegna Indicativa:</span>
    @if($indicativeDeliveryDays > 0)
        <span>{{ $indicativeDeliveryDays }} giorni lavorativi</span>
    @endif
</div>
@endisset