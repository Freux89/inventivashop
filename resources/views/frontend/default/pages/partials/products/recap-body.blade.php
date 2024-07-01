<div class="recap-body">
    <div class="recap-body-upper pb-2 mb-2">

        <!-- Quantità -->
        <div class="line quantity">
            <div class="label">Quantità</div>
            <div class="value"><span>{{ isset($quantity) ? $quantity : 1 }}</span></div>
        </div>

        <!-- Consegna Indicativa -->
        <div class="line indicative-delivery">
            <div class="label">Consegna Indicativa</div>
            <div class="value">
                <span>{{ $indicativeDeliveryDays }} giorni lavorativi</span>
            </div>
        </div>

        <!-- Prezzo netto lavorazione -->
        <div class="line net-price">
            <div class="label">Netto lavorazione</div>
            <div class="value">
                <span class="fw-bold">{{ $netPrice }}</span>
            </div>
        </div>

        <!-- Unità -->
        @if ($unit)
            <div class="line unit">
                <div class="label">Unità</div>
                <div class="value">
                    <small>/{{ $unit }}</small>
                </div>
            </div>
        @endif

        <!-- IVA -->
        <div class="line tax">
            <div class="label">IVA 22%</div>
            <div class="value"><span>{{ $tax }}</span></div>
        </div>

    </div>

    <!-- Totale preventivo -->
    <div class="line total">
        <span class="label total-label text-secondary">Totale preventivo</span>
        <div class="value total-price h4 text-secondary">
            @if ($basePrice == $discountedBasePrice)
                @if ($basePrice == $maxPrice)
                    <span class="fw-bold h5">{{ formatPrice($basePrice) }}</span>
                @else
                    <span class="fw-bold h5">{{ formatPrice($basePrice) }}</span>
                @endif
            @else
                @if ($discountedBasePrice == $discountedMaxPrice)
                    <span class="fw-bold h5">{{ formatPrice($discountedBasePrice) }}</span>
                @else
                    <span class="fw-bold h5">{{ formatPrice($discountedBasePrice) }}</span>
                @endif

                @if (!isset($onlyPrice) || $onlyPrice == false)
                    @if ($basePrice == $maxPrice)
                        <span class="fw-bold h5 deleted text-muted">{{ formatPrice($basePrice) }}</span>
                    @else
                        <span class="fw-bold h5 deleted text-muted">{{ formatPrice($basePrice) }}</span>
                    @endif
                @endif
            @endif
        </div>
    </div>
</div>
