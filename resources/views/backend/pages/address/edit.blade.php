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
                            <h2 class="h5 mb-lg-0">{{ localize('Modifica Indirizzo') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-4">
            <div class="col-xl-12">
                <!-- Form per modificare i dati dell'utente -->
                <form action="{{ route('admin.address.update', $address->id) }}" method="POST" id="address-form">
                    @csrf
                    @method('PUT')
                    <div class="card mb-4" id="section-address-info">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Informazioni Base') }}</h5>

                            <!-- Nome -->
                            <div class="mb-4">
                                <label for="address_name" class="form-label">{{ localize('Dai un nome a questo indirizzo') }}</label>
                                <input class="form-control" type="text" id="address_name" name="address_name" value="{{ $address->address_name }}" placeholder="Casa">
                            </div>

                            <div class="mb-4">
                                <label for="first_name" class="form-label">{{ localize('Nome') }}</label>
                                <input class="form-control" type="text" id="first_name" name="first_name" value="{{ $address->first_name }}" required>
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label for="last_name" class="form-label">{{ localize('Cognome') }}</label>
                                <input class="form-control" type="text" id="last_name" name="last_name" value="{{ $address->last_name }}" required>
                            </div>

                            <!-- Telefono -->
                            <div class="mb-4">
                                <label for="phone" class="form-label">{{ localize('Telefono') }}</label>
                                <input class="form-control" type="tel" id="phone" name="phone" value="{{ $address->phone }}">
                            </div>

                            <!-- Password (opzionale) -->
                            <div class="mb-4">
                                <label for="country_id" class="form-label">{{ localize('Stato') }}</label>
                                <select class="form-control" id="country_id" name="country_id" data-states-url="{{ route('admin.states.get') }}">
                                    <option value="">{{ localize('Select Country') }}</option>
                                    @foreach ($countries as $country)
                                    <option value="{{ $country->id }}" @if ($address->country_id == $country->id) selected @endif>
                                        {{ $country->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="country_id" class="form-label">{{ localize('Provincia') }}</label>
                                <select class="form-control" id="state_id" name="state_id">
                                    @foreach ($states as $state)
                                    <option value="{{ $state->id }}" @if ($address->state_id == $state->id) selected @endif>
                                        {{ $state->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="city" class="form-label">{{ localize('Città') }}</label>
                                <input class="form-control" type="text" id="city" name="city" value="{{ $address->city }}" required>
                            </div>
                            <div class="mb-4">
                                <label for="address" class="form-label">{{ localize('Indirizzo') }}</label>
                                <input class="form-control" type="text" id="address" name="address" value="{{ $address->address }}" required>
                            </div>
                            <div class="mb-4">
                                <label for="postal_code" class="form-label">{{ localize('Cap') }}</label>
                                <input class="form-control" type="text" id="postal_code" name="postal_code" value="{{ $address->postal_code }}" required>
                            </div>
                            <div class="mb-4">
                                <label for="postal_code" class="form-label">{{ localize('Tipo documento') }}</label>
                                <select name="document_type" id="document_type" class="form-control">
                                    <option value="0" {{ $address->document_type == 0 ? 'selected' : '' }}>Nessun documento</option>
                                    <option value="1" {{ $address->document_type == 1 ? 'selected' : '' }}>Ricevuta</option>
                                    <option value="2" {{ $address->document_type == 2 ? 'selected' : '' }}>Fattura</option>
                                </select>

                            </div>
                            <div class="mb-4 document-field" id="company_name_field" style="display: none;">
                                <label for="company_name">Nome Azienda</label>
                                <input type="text" id="company_name" name="company_name" class="form-control" value="{{ $address->company_name }}">
                            </div>
                            <div class="mb-4 document-field" id="vat_id_field" style="display: none;">
                                <label for="vat_id">P.iva</label>
                                <input type="text" id="vat_id" name="vat_id" class="form-control" value="{{ $address->vat_id }}">
                            </div>
                            <div class="mb-4 document-field" id="fiscal_code_field" style="display: none;">
                                <label for="fiscal_code">Codice fiscale</label>
                                <input type="text" id="fiscal_code" name="fiscal_code" class="form-control" value="{{ $address->fiscal_code }}">
                            </div>
                            <div class="mb-4 document-field" id="pec_field" style="display: none;">
                                <label for="pec">PEC</label>
                                <input type="email" id="pec" name="pec" class="form-control" value="{{ $address->pec }}">
                            </div>
                            <div class="mb-4 document-field" id="exchange_code_field" style="display: none;">
                                <label for="exchange_code">Codice di interscambio</label>
                                <input type="text" id="exchange_code" name="exchange_code" class="form-control" value="{{ $address->exchange_code }}">
                            </div>

                            <!-- Pulsante di invio -->
                            <div class="mb-4">
                                <button class="btn btn-primary" type="submit">
                                    <i data-feather="save" class="me-1"></i> {{ localize('Aggiorna') }}
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
</script>
<script>
    document.getElementById('document_type').addEventListener('change', function() {
        var type = this.value;

        // Nascondi tutti i campi e rimuovi l'attributo 'required'
        document.querySelectorAll('.document-field').forEach(function(field) {
            field.style.display = 'none';
            field.querySelector('input').required = false;  // Rimuovi l'obbligatorietà
        });

        // Logica per mostrare i campi basata sul tipo di documento
        if (type === '1') {
            // Mostra solo il campo Codice fiscale e rendilo obbligatorio
            var fiscalField = document.getElementById('fiscal_code_field');
            fiscalField.style.display = 'block';
            fiscalField.querySelector('input').required = true;  // Rendi obbligatorio
        } else if (type === '2') {
            // Mostra tutti i campi e rendili obbligatori
            document.querySelectorAll('.document-field').forEach(function(field) {
                field.style.display = 'block';
                field.querySelector('input').required = true;  // Rendi obbligatorio
            });
        }
        // Non è necessario fare nulla per il tipo '0' poiché tutti i campi sono già nascosti
    });

    // Inizializza i campi al caricamento della pagina in base al valore preselezionato
    document.getElementById('document_type').dispatchEvent(new Event('change'));
</script>


@endsection