@extends('backend.layouts.master')

@section('title')
{{ localize('Aggiorna Materiale') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
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
                                <h2 class="h5 mb-lg-0">{{ localize('Modifica materiale') }}</h2>
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
                <form action="{{ route('admin.materials.update', $material->id) }}" method="POST" class="pb-650" id="material-form">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $material->id }}">
                    <!--basic information start-->
                    <div class="card mb-4" id="section-1">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Basic Information') }}</h5>

                            <div class="mb-4">
                                <label for="name" class="form-label">{{ localize('Nome materiale') }}</label>
                                <input class="form-control" type="text" id="name" placeholder="{{ localize('Digita il nome del materiale') }}" name="name" value="{{ $material->collectLocalization('name') }}" required>
                                <span class="fs-sm text-muted">
                                    {{ localize('Il nome del materiale è obbligatorio e si consiglia di renderlo unico.') }}
                                </span>
                            </div>

                            <!-- <div class="mb-4">
                                <label for="description" class="form-label">{{ localize('Description') }}</label>
                                <textarea id="description" class="editor" name="description">{{ $material->collectLocalization('description') }}</textarea>
                            </div> -->

                        </div>
                    </div>
                    <!--basic information end-->

                    <!--material image and texture-->
                    <!-- <div class="card mb-4" id="section-2">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Images') }}</h5>
                            <div class="mb-4">
                                <label class="form-label">{{ localize('Thumbnail') }} (592x592)</label>
                                <div class="tt-image-drop rounded">
                                    <span class="fw-semibold">{{ localize('Scegli la miniatura del materiale') }}</span>
                                   
                                    <div class="tt-product-thumb show-selected-files mt-3">
                                        <div class="avatar avatar-xl cursor-pointer choose-media" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" onclick="showMediaManager(this)" data-selection="single">
                                            <input type="hidden" name="thumbnail_image" value="{{ $material->thumbnail_image }}">
                                            <div class="no-avatar rounded-circle">
                                                <span><i data-feather="plus"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                
                                </div>
                            </div>

                        </div>
                    </div> -->



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
    <input type="number" min="0" step="0.0001" id="purchase_price" name="purchase_price" placeholder="{{ localize('Prezzo di acquisto') }}" class="form-control" value="{{ old('purchase_price', $material->purchase_price ?? '') }}">
</div>

                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="processing_price" class="form-label">{{ localize('Prezzo Lavorazione') }}</label>
                                        <input type="number" min="0" step="0.0001" id="processing_price" name="processing_price" placeholder="{{ localize('Prezzo lavorazione') }}" class="form-control" value="{{ old('processing_price', $material->processing_price ?? '') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">{{ localize('Price') }}</label>
                                        <input type="number" min="0" step="0.0001" id="price" name="price" placeholder="{{ localize('Prezzo materiale') }}" class="form-control" value="{{$material->price}}" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="stock" class="form-label">{{ localize('Tipo di calcolo') }}</label>

                                        <select class="select2 form-control" id="price_type" name="price_type">
                                            <option value="mq" {{ $material->price_type == 'mq' ? 'selected' : '' }}>{{ localize('mq') }}</option>
                                            <option value="linear" {{ $material->price_type == 'linear' ? 'selected' : '' }}>{{ localize('Metro lineare') }}</option>
                                            <option value="fixed" {{ $material->price_type == 'fixed' ? 'selected' : '' }}>{{ localize('fixed') }}</option>
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
                                @if(old('price_tiers') || isset($material))
                                @foreach(old('price_tiers', $material->priceTiers ?? []) as $index => $tier)
                                <div class="row g-3 align-items-center mb-2">
                                    <div class="col-lg-4">
                                        <input type="number" name="price_tiers[{{ $index }}][min_quantity]" class="form-control" placeholder="{{ localize('Quantità minima (mq o metri lineari)') }}" value="{{ old('price_tiers.'.$index.'.min_quantity', $tier['min_quantity'] ?? '') }}" min="0" step="0.0001">
                                    </div>
                                    <div class="col-lg-4">
                                        <input type="number" name="price_tiers[{{ $index }}][price]" class="form-control" placeholder="{{ localize('Prezzo per la quantità minima') }}" value="{{ old('price_tiers.'.$index.'.price', $tier['price'] ?? '') }}" min="0" step="0.0001">
                                    </div>
                                    <div class="col-lg-4">
                                        <button type="button" class="btn btn-danger remove-price-tier">{{ localize('Rimuovi') }}</button>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>

                            <button type="button" class="btn btn-secondary" id="add-price-tier">{{ localize('Aggiungi Scaglione') }}</button>
                        </div>
                    </div>

                    <div class="card mb-4" id="section-6">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Seleziona uno o più valori variante che vuoi collegare a questo materiale') }}</h5>
                            <span class="text-muted">
                                Se uno dei valori variante associati a questo materiale viene selezionato dal cliente durante la configurazione del prodotto, le regole di prezzo definite per questo materiale avranno la precedenza su tutte le altre regole di prezzo associate ai valori variante, al template del prodotto o alle varianti specifiche.
                            </span>
                            <div class="row g-3 mt-1">
                                <div class="col-lg-12">
                                    <select class="form-select select2" name="variation_values[]" id="variation_value-select" multiple>
                                        @foreach ($variations as $variation)
                                        <optgroup label="{{ $variation->name }}">
                                            @foreach ($variation->variationValues as $value)
                                            <option value="{{ $value->id }}"
                                                @if (in_array($value->id, $material->variationValues->pluck('id')->toArray())) selected @endif>
                                                {{ $variation->name }}: {{ $value->name }}
                                            </option>
                                            @endforeach
                                        </optgroup>
                                        @endforeach
                                    </select>


                                </div>


                            </div>
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

            <!--right sidebar-->
            <!-- <div class="col-xl-3 order-1 order-md-1 order-lg-1 order-xl-2">
                <div class="card tt-sticky-sidebar">
                    <div class="card-body">
                        <h5 class="mb-4">{{ localize('Informazioni materiale') }}</h5>
                        <div class="tt-vertical-step">
                            <ul class="list-unstyled">
                                <li>
                                    <a href="#section-1" class="active">{{ localize('Basic Information') }}</a>
                                </li>
                                <li>
                                    <a href="#section-2">{{ localize('Miniatura immagine') }}</a>
                                </li>
                                <li>
                                    <a href="#section-5">{{ localize('Prezzo') }}</a>
                                </li>
                                <li>
                                    <a href="#section-6">{{ localize('Valori variante') }}</a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div> -->
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
@endsection

@include('backend.inc.product-scripts')