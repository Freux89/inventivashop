@extends('backend.layouts.master')

@section('title')
{{ localize('Indirizzo') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
<section class="tt-section pt-4">
    <div class="container">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ localize($error) }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">{{ localize('Crea Indirizzo') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-4">
            <div class="col-xl-12">
                <!-- Form per modificare i dati dell'utente -->
                <form action="{{ route('admin.address.store', $user_id) }}" method="POST" id="address-form">
                    @csrf
                    @method('POST')
                    <div class="card mb-4" id="section-address-info">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Informazioni Base') }}</h5>

                            <!-- Nome -->
                            @if($type=='shipping')
                            <div class="mb-4">
                                <label for="address_name" class="form-label">{{ localize('Dai un nome a questo indirizzo') }}</label>
                                <input class="form-control" type="text" id="address_name" name="address_name" value="" placeholder="Casa">
                            </div>
                            <div class="mb-4">
                                <label for="first_name" class="form-label">{{ localize('Nome') }}</label>
                                <input class="form-control" type="text" id="first_name" name="first_name" required>
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label for="last_name" class="form-label">{{ localize('Cognome') }}</label>
                                <input class="form-control" type="text" id="last_name" name="last_name" required>
                            </div>
                            @else
                            <div class="mb-4">
                                <label class="d-block mb-3">Tipo di fatturazione</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="billing_type" id="billingTypeCompany" value="company" checked="" onclick="toggleBillingFields('company')" required="">
                                    <label class="form-check-label" for="billingTypeCompany">Azienda</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="billing_type" id="billingTypePrivate" value="private" onclick="toggleBillingFields('private')" required="">
                                    <label class="form-check-label" for="billingTypePrivate">Privato</label>
                                </div>
                            </div>
                            <div class="mb-4 private-field">
                                <label for="first_name" class="form-label">{{ localize('Nome') }}</label>
                                <input class="form-control" type="text" id="first_name" name="first_name" required>
                            </div>

                            <!-- Email -->
                            <div class="mb-4 private-field">
                                <label for="last_name" class="form-label">{{ localize('Cognome') }}</label>
                                <input class="form-control" type="text" id="last_name" name="last_name" required>
                            </div>
                            @endif
                           

                            <!-- Telefono -->


                            <!-- Password (opzionale) -->
                            <div class="mb-4">
                                <label for="country_id" class="form-label">{{ localize('Stato') }}</label>
                                <select class="form-control" id="country_id" name="country_id" data-states-url="{{ route('admin.states.get') }}">
                                    <option value="">{{ localize('Select Country') }}</option>
                                    @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">
                                        {{ $country->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="country_id" class="form-label">{{ localize('Provincia') }}</label>
                                <select class="form-control" id="state_id" name="state_id">
                                    @foreach ($states as $state)
                                    <option value="{{ $state->id }}">
                                        {{ $state->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="city" class="form-label">{{ localize('Città') }}</label>
                                <input class="form-control" type="text" id="city" name="city" required>
                            </div>
                            <div class="mb-4">
                                <label for="address" class="form-label">{{ localize('Indirizzo') }}</label>
                                <input class="form-control" type="text" id="address" name="address" required>
                            </div>
                            <div class="mb-4">
                                <label for="postal_code" class="form-label">{{ localize('Cap') }}</label>
                                <input class="form-control" type="text" id="postal_code" name="postal_code" required>
                            </div>
                            @if($type=='billing')
                            <div class="mb-4 company-field" id="company_name_field">
                                <label for="company_name">Nome Azienda</label>
                                <input type="text" id="company_name" name="company_name" class="form-control">
                            </div>
                            <div class="mb-4 company-field" id="vat_id_field">
                                <label for="vat_id">P.iva</label>
                                <input type="text" id="vat_id" name="vat_id" class="form-control">
                            </div>
                            <div class="mb-4 private-field" id="fiscal_code_field">
                                <label for="fiscal_code">Codice fiscale</label>
                                <input type="text" id="fiscal_code" name="fiscal_code" class="form-control">
                            </div>
                            <div class="mb-4 company-field" id="pec_field">
                                <label for="pec">PEC</label>
                                <input type="email" id="pec" name="pec" class="form-control" oninput="updateRequiredFields()">
                            </div>
                            <div class="mb-4 company-field" id="sdi_code_field">
                                <label for="sdi_code">Codice SDI</label>
                                <input type="text" id="sdi_code" name="sdi_code" class="form-control" oninput="updateRequiredFields()">
                            </div>

                            @endif
                            <div class="mb-4">
                                <label for="phone" class="form-label">{{ localize('Telefono') }}</label>
                                <input class="form-control" type="tel" id="phone" name="phone">
                            </div>
                            <!-- Pulsante di invio -->
                            <div class="mb-4">
                                <button class="btn btn-primary" type="submit">
                                    <i data-feather="save" class="me-1"></i> {{ localize('Crea') }}
                                </button>
                            </div>

                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')

<script>
    toggleBillingFields('company');

    document.getElementById('country_id').addEventListener('change', function() {
        var countryId = this.value;
        var statesUrl = this.getAttribute('data-states-url');

        fetch(statesUrl + '?country_id=' + countryId)
            .then(response => response.json())
            .then(states => {
                var statesSelect = document.getElementById('state_id');
                statesSelect.innerHTML = '<option value="">Select State</option>';
                states.forEach(function(state) {
                    statesSelect.innerHTML += '<option value="' + state.id + '">' + state.name + '</option>';
                });
            });
    });

    function toggleBillingFields(type) {
        var companyFields = document.querySelectorAll('.company-field');
        var privateFields = document.querySelectorAll('.private-field');

        if (type === 'company') {
            companyFields.forEach(field => {
                field.style.display = 'block';
                field.querySelectorAll('input, select, textarea').forEach(input => input.required = true);
            });
            privateFields.forEach(field => {
                field.style.display = 'none';
                field.querySelectorAll('input, select, textarea').forEach(input => input.required = false);
            });
        } else {
            companyFields.forEach(field => {
                field.style.display = 'none';
                field.querySelectorAll('input, select, textarea').forEach(input => input.required = false);
            });
            privateFields.forEach(field => {
                field.style.display = 'block';
                field.querySelectorAll('input, select, textarea').forEach(input => input.required = true);
            });
        }
    }

    function updateRequiredFields() {
        const pecInput = document.getElementById('pec');
        const sdiCodeInput = document.getElementById('sdi_code');

        if (pecInput.value.trim() !== '') {
            sdiCodeInput.removeAttribute('required');
        } else {
            sdiCodeInput.setAttribute('required', 'required');
        }

        if (sdiCodeInput.value.trim() !== '') {
            pecInput.removeAttribute('required');
        } else {
            pecInput.setAttribute('required', 'required');
        }
    }

    // Initial check in case of pre-filled values
    document.addEventListener('DOMContentLoaded', updateRequiredFields);
</script>



@endsection