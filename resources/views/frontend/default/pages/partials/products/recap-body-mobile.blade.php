<div class="align-items-center my-3">
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
