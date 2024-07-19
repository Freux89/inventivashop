<div class="quote-details-container align-items-center my-3">
<div class="d-flex justify-content-end mb-2">
        <i class="fa-solid fa-arrow-up toggle-quote-details" style="cursor: pointer;"></i>
    </div>
    <div class="recap-body-upper pb-2 mb-2" id="quote-details" style="display: none;">
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

    <div class="total d-flex justify-content-between align-items-center">
        <span class="label total-label text-secondary">{{localize('Totale preventivo')}}</span>
        <div class="value total-price text-secondary">
            @if ($basePrice == $discountedBasePrice)
                @if ($basePrice == $maxPrice)
                    <span class="fw-bold ">{{ formatPrice($basePrice) }}</span>
                @else
                    <span class="fw-bold ">{{ formatPrice($basePrice) }}</span>
                @endif
            @else
                @if ($discountedBasePrice == $discountedMaxPrice)
                    <span class="fw-bold ">{{ formatPrice($discountedBasePrice) }}</span>
                @else
                    <span class="fw-bold ">{{ formatPrice($discountedBasePrice) }}</span>
                @endif
                @if (!isset($onlyPrice) || $onlyPrice == false)
                    @if ($basePrice == $maxPrice)
                        <span class="fw-bold  deleted text-muted">{{ formatPrice($basePrice) }}</span>
                    @else
                        <span class="fw-bold  deleted text-muted">{{ formatPrice($basePrice) }}</span>
                    @endif
                @endif
            @endif
        </div>
    </div>
</div>
<div class="d-flex justify-content-center mt-2">
    <button type="button" onclick="document.getElementById('addToCartForm').requestSubmit();" class="btn btn-primary btn-md add-to-cart-btn w-100">
        <span class="me-2">
            <i class="fa-solid fa-bag-shopping"></i>
        </span>
        <span class="add-to-cart-text">{{localize('Aggiungi al Carrello')}}</span>
    </button>
</div>
