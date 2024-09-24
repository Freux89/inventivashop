@extends('backend.layouts.master')

@section('title')
{{ localize('Crea Nuovo Materiale') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
<section class="tt-section pt-4">
    <div class="container">

        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                        <div class="col-auto">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-lg-0">{{ localize('Crea Nuovo Materiale') }}</h2>
                            </div>
                        </div>

                        <div class="col-auto">
                            <a href="{{ route('admin.materials.index') }}" class="btn btn-link">
                                <i class="fas fa-arrow-left"></i> Torna all'elenco
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-4">

            <!--left sidebar-->
            <div class="col-xl-12 order-2 order-md-2 order-lg-2 order-xl-1">
                <form action="{{ route('admin.materials.store') }}" method="POST" class="pb-650" id="material-form">
                    @csrf

                    <!--basic information start-->
                    <div class="card mb-4" id="section-1">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Informazioni di Base') }}</h5>

                            <div class="mb-4">
                                <label for="name" class="form-label">{{ localize('Nome materiale') }}</label>
                                <input class="form-control" type="text" id="name" placeholder="{{ localize('Digita il nome del materiale') }}" name="name" value="{{ old('name') }}" required>
                                <span class="fs-sm text-muted">
                                    {{ localize('Il nome del materiale è obbligatorio e si consiglia di renderlo unico.') }}
                                </span>
                            </div>

                            <!-- <div class="mb-4">
                                <label for="description" class="form-label">{{ localize('Descrizione') }}</label>
                                <textarea id="description" class="editor" name="description">{{ old('description') }}</textarea>
                            </div> -->

                        </div>
                    </div>
                    <!--basic information end-->

                    <!--material price and type price-->
                    <div class="card mb-4" id="section-5">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-4">{{ localize('Prezzo') }}</h5>
                            </div>

                            <div class="row g-3">
                                <div class="col-lg-12">
                                <div class="mb-3">
    <label for="purchase_price" class="form-label">{{ localize('Prezzo di Acquisto') }}</label>
    <input type="number" min="0" step="0.0001" id="purchase_price" name="purchase_price" placeholder="{{ localize('Prezzo di acquisto') }}" class="form-control" value="{{ old('purchase_price') }}">
</div>

                                </div>
                            <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="processing_price" class="form-label">{{ localize('Prezzo Lavorazione') }}</label>
                                        <input type="number" min="0" step="0.0001" id="processing_price" name="processing_price" placeholder="{{ localize('Prezzo lavorazione') }}" class="form-control" value="{{ old('processing_price') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">{{ localize('Prezzo') }}</label>
                                        <input type="number" min="0" step="0.0001" id="price" name="price" placeholder="{{ localize('Prezzo materiale') }}" class="form-control" value="{{ old('price') }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="price_type" class="form-label">{{ localize('Tipo di calcolo') }}</label>
                                        <select class="select2 form-control" id="price_type" name="price_type">
                                            <option value="mq" {{ old('price_type') == 'mq' ? 'selected' : '' }}>{{ localize('mq') }}</option>
                                            <option value="linear" {{ old('price_type') == 'linear' ? 'selected' : '' }}>{{ localize('Metro lineare') }}</option>
                                            <option value="fixed" {{ old('price_type') == 'fixed' ? 'selected' : '' }}>{{ localize('fixed') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4" id="section-price-tiers">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Scaglioni di Prezzo') }}</h5>

                            <div id="price-tier-container">
                               
                            </div>

                            <button type="button" class="btn btn-secondary" id="add-price-tier">{{ localize('Aggiungi Scaglione') }}</button>
                        </div>
                    </div>
                    <div class="card mb-4" id="section-6">
    <div class="card-body">
        <h5 class="mb-4">{{ localize('Definisci le condizioni di attivazione del materiale') }}</h5>
        <span class="text-muted">
            Imposta gruppi di condizioni per attivare questo materiale in base ai valori variante selezionati dal cliente.
        </span>

        <div id="condition-groups">
            <!-- Qui verranno inseriti i gruppi di condizioni aggiunti -->
        </div>

        <button type="button" class="btn btn-primary d-flex align-items-center mt-3" id="add-condition-group">Aggiungi Gruppo</button>
    </div>
</div>


                    <div class="row mt-7">
                        <div class="col-12">
                            <div class="mb-4">
                                <button class="btn btn-primary" type="submit">
                                    <i data-feather="save" class="me-1"></i> {{ localize('Salva') }}
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
    document.getElementById('add-price-tier').addEventListener('click', function() {
        let container = document.getElementById('price-tier-container');
        let index = container.children.length;
        let html = `
            <div class="row g-3 align-items-center mb-2">
                <div class="col-lg-4">
                    <input type="number" name="price_tiers[${index}][min_quantity]" class="form-control" placeholder="{{ localize('Quantità minima (mq o metri lineari)') }}" min="0" step="0.0001">
                </div>
                <div class="col-lg-4">
                    <input type="number" name="price_tiers[${index}][price]" class="form-control" placeholder="{{ localize('Prezzo per la quantità minima') }}" min="0" step="0.0001">
                </div>
                <div class="col-lg-4">
                    <button type="button" class="btn btn-danger remove-price-tier">{{ localize('Rimuovi') }}</button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
    });

    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-price-tier')) {
            event.target.closest('.row').remove();
        }
    });
</script>

<script>
    document.getElementById('add-condition-group').addEventListener('click', function() {
    let groupIndex = document.querySelectorAll('.condition-group').length;
    let newGroupHtml = `
    <div class="condition-group my-3" data-group="${groupIndex}">
        <h6>Gruppo Condizioni #${groupIndex + 1}</h6>
        <div class="row">
            <div class="col-md-8">
                <label for="variation_values_${groupIndex}">Valori Varianti</label>
                <select class="form-select select2" name="variation_values[${groupIndex}][]" multiple>
                    @foreach ($variations as $variation)
                        <optgroup label="{{ $variation->name }}">
                            @foreach ($variation->variationValues as $value)
                                <option value="{{ $value->id }}">
                                    {{ $variation->name }}: {{ $value->name }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="condition_operator_${groupIndex}">Operatore Condizione</label>
                <select class="form-select" name="condition_operator[${groupIndex}]">
                    <option value="AND">AND</option>
                    <option value="OR">OR</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-center">
                <button type="button" class="btn btn-danger mt-2 remove-group">Rimuovi Gruppo</button>
            </div>
        </div>
        <hr class="mt-2">
    </div>
    `;

    document.getElementById('condition-groups').insertAdjacentHTML('beforeend', newGroupHtml);

    // Inizializza Select2 per la nuova select
    $('.select2').select2();
});

document.getElementById('condition-groups').addEventListener('click', function(event) {
    if (event.target.classList.contains('remove-group')) {
        event.target.closest('.condition-group').remove();
    }
});

</script>
@endsection
@include('backend.inc.product-scripts')
