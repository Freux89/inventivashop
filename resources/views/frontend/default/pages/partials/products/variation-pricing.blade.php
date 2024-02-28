@if ($price == $discounted_price)
    <span class="fw-bold h4 text-danger">{{ formatPrice($price) }}</span>
@else
    <span class="fw-bold h4 text-danger">{{ formatPrice($discounted_price) }}</span>
    <span class="fw-bold h4 deleted ms-1">{{ formatPrice($price) }}</span>
@endif

@if ($product->unit)
    <small>/{{ $product->unit->collectLocalization('name') }}</small>
@endif

<div class="mt-2">
    <span class="fw-bold text-muted">Consegna Indicativa:</span>
    @if($indicativeDeliveryDays > 0)
        <span>{{ $indicativeDeliveryDays }} giorni lavorativi</span>
    @endif
</div>