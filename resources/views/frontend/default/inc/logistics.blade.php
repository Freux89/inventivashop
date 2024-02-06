<h4 class="mt-7">{{ localize('Available Logistics') }}</h4>
@forelse ($logisticZoneCountries as $zoneCountry)
<div class="checkout-radio d-flex align-items-center justify-content-between gap-3 bg-white rounded p-4 mt-3">
    <div class="radio-left d-inline-flex align-items-center">
        <div class="theme-radio">
            <input type="radio" name="chosen_logistic_zone_id" id="logistic-{{ $zoneCountry->logistic_zone_id }}" value="{{ $zoneCountry->logistic_zone_id }}">
            <span class="custom-radio"></span>
        </div>
        <div>
            <label for="logistic-{{ $zoneCountry->logistic_zone_id }}" class="ms-3 mb-0">
                <div class="h6 mb-0">{{ $zoneCountry->logistic->name }}</div>
                <div> {{ localize('Shipping Charge') }}
                    {{ formatPrice($zoneCountry->logisticZone->standard_delivery_charge) }}
                </div>
                @if($zoneCountry->logisticZone->packing_cost)
                <p>Costo dell'imballo: {{ $zoneCountry->logisticZone->packing_cost }}€</p>
                @endif

                <!-- Costo della spedizione assicurata -->
                @if($zoneCountry->logisticZone->insured_shipping_cost)
        <div class="mb-4">
            <p>Vuoi assicurare la tua spedizione? Il costo è di {{ $zoneCountry->logisticZone->insured_shipping_cost }}€</p>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="insured_shipping" id="insured_shipping_{{ $zoneCountry->logistic_zone_id }}" disabled>
                <label class="form-check-label" for="insured_shipping_{{ $zoneCountry->logistic_zone_id }}">
                    Attiva spedizione assicurata
                </label>
            </div>
        </div>
        @endif

            </label>
        </div>
    </div>
    <div class="radio-right text-end">
        <img src="{{ uploadedAsset($zoneCountry->logistic->thumbnail_image) }}" alt="{{ $zoneCountry->logistic->name }}" class="img-fluid" width="100" heoght="100">
    </div>
</div>
@empty
<div class="col-12 mt-5">
    <div class="tt-address-content">
        <div class="alert alert-danger text-center">
            {{ localize('We are not shipping to your city now.') }}
        </div>
    </div>
</div>
@endforelse