<div class="row align-items-center g-4 mt-3">
<div id="editAddressForm-{{ $address->id }}">
        @csrf
        <input type="hidden" name="id" value="{{ $address->id }}">
        <div class="col my-5 billing-field">
        <label class="d-block mb-3">{{ localize('Tipo di fatturazione') }}</label>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="billing_type" id="billingTypeCompany" value="company" @if($address->document_type == 1) checked @endif onclick="toggleBillingFields('company')">
            <label class="form-check-label" >{{ localize('Azienda') }}</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="billing_type" id="billingTypePrivate" value="private" @if($address->document_type == 2) checked @endif onclick="toggleBillingFields('private')">
            <label class="form-check-label" >{{ localize('Privato') }}</label>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6 shipping-field">
            <div class="label-input-field">
                <label>{{ localize('Nome indirizzo') }}</label>
                <input type="text" name="address_name" placeholder="{{ localize('Nome indirizzo') }}" value="{{ $address->address_name }}" required>
            </div>
        </div>

        <div class="col-md-6 common-field">
            <div class="label-input-field">
                <label>{{ localize('Nazione') }}</label>
                <select name="country_id" class="select2Address" required>
                    <option value="">{{ localize('Select Country') }}</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}" @if($address->country_id == $country->id) selected @endif>{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-6 common-field private-field">
            <div class="label-input-field">
                <label>{{ localize('Nome') }}</label>
                <input type="text" name="first_name" placeholder="{{ localize('Nome') }}" value="{{ $address->first_name }}" required>
            </div>
        </div>

        <div class="col-md-6 common-field private-field">
            <div class="label-input-field">
                <label>{{ localize('Cognome') }}</label>
                <input type="text" name="last_name" placeholder="{{ localize('Cognome') }}" value="{{ $address->last_name }}" required>
            </div>
        </div>

        <div class="col-md-6 billing-field private-field" style="display: none;">
            <div class="label-input-field">
                <label>{{ localize('CF') }}</label>
                <input type="text" name="fiscal_code" placeholder="{{ localize('CF') }}" value="{{ $address->fiscal_code }}" required>
            </div>
        </div>

        <div class="col-md-6 billing-field company-field" style="display: none;">
            <div class="label-input-field">
                <label>{{ localize('Partita IVA') }}</label>
                <input type="text" name="vat_id" placeholder="{{ localize('Partita IVA') }}" value="{{ $address->vat_id }}" required>
            </div>
        </div>

        <div class="col-md-6 billing-field company-field" style="display: none;">
            <div class="label-input-field">
                <label>{{ localize('Nome azienda') }}</label>
                <input type="text" name="company_name" placeholder="{{ localize('Nome azienda') }}" value="{{ $address->company_name }}" required>
            </div>
        </div>

        <div class="col-md-6 billing-field company-field" style="display: none;">
            <div class="label-input-field">
                <label>{{ localize('Codice SDI') }}</label>
                <input type="text" name="sdi_code" placeholder="{{ localize('Codice SDI') }}" value="{{ $address->sdi_code }}">
            </div>
        </div>

        <div class="col-md-6 billing-field company-field" style="display: none;">
            <div class="label-input-field">
                <label>{{ localize('PEC') }}</label>
                <input type="email" name="pec" placeholder="{{ localize('PEC') }}" value="{{ $address->pec }}">
            </div>
        </div>

        <div class="col-md-6 common-field">
            <div class="label-input-field">
                <label>{{ localize('Indirizzo') }}</label>
                <input type="text" name="address" placeholder="{{ localize('Indirizzo') }}" value="{{ $address->address }}" required>
            </div>
        </div>

        <div class="col-md-6 common-field">
            <div class="label-input-field">
                <label>{{ localize('CAP') }}</label>
                <input type="text" name="postal_code" placeholder="{{ localize('CAP') }}" value="{{ $address->postal_code }}" required>
            </div>
        </div>

        <div class="col-md-6 common-field">
            <div class="label-input-field">
                <label>{{ localize('Città') }}</label>
                <input type="text" name="city" placeholder="{{ localize('Città') }}" value="{{ $address->city }}" required>
            </div>
        </div>

        <div class="col-md-6 common-field">
            <div class="label-input-field">
                <label>{{ localize('Provincia') }}</label>
                <select name="state_id" required>
                    @foreach ($states as $state)
                        <option value="{{ $state->id }}" @if($address->state_id == $state->id) selected @endif>{{ $state->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-6 common-field">
            <div class="label-input-field">
                <label>{{ localize('Telefono') }}</label>
                <input type="text" name="phone" placeholder="{{ localize('Telefono') }}" value="{{ $address->phone }}">
            </div>
        </div>
        <div class="mt-6 d-flex">
    <!-- Pulsante per annullare e chiudere l'accordion -->
    <button type="button" class="btn btn-secondary btn-md me-3" onclick="closeAccordion({{ $address->id }})">{{ localize('Annulla') }}</button>

    <!-- Pulsante per salvare l'indirizzo -->
    <button type="button" class="btn btn-primary btn-md px-6" onclick="submitDivAsForm({{ $address->id }})">{{ localize('Usa questo indirizzo') }}</button>
</div>
    </form>
</div>
