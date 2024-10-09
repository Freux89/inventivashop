@extends('backend.layouts.master')

@section('title')
Modifica Avviso {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
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
                                <h2 class="h5 mb-lg-0">Modifica Avviso</h2>
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.alerts.index') }}" class="btn btn-link">
                                <i class="fas fa-arrow-left"></i> Torna all'elenco
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-4">
            <div class="col-xl-12">
                <form action="{{ route('admin.alerts.update', $alert->id) }}" method="POST" class="pb-650" id="alert-form">
                    @csrf
                    @method('PUT')
                    <!-- Informazioni di base dell'avviso -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="mb-4">Titolo dell'Avviso</h5>
                            <div class="mb-3">
                                <input type="text" name="title" value="{{ old('title', $alert->title) }}" placeholder="Inserisci il titolo dell'avviso..." class="form-control" required>
                            </div>
                            <h5 class="mb-4">Testo dell'Avviso</h5>
                            <div class="mb-3">
                                <textarea name="text" placeholder="Inserisci il testo dell'avviso..." class="form-control" required>{{ old('text', $alert->text) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <x-color-picker
                                    id="background_color"
                                    name="background_color"
                                    value="{{ old('background_color', $alert->background_color) }}"
                                    label="Colore di Sfondo" />
                            </div>
                            <div class="mb-3">
                            <x-color-picker
                                id="text_color"
                                name="text_color"
                                value="{{ old('text_color', $alert->text_color) }}"
                                label="Colore del Testo" />
                        </div>
                    </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="mb-4">Impostazioni dell'Avviso</h5>
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Data di Inizio</label>
                        <input type="datetime-local" name="start_date" id="start_date" class="form-control" value="{{ old('start_date', $alert->start_date->format('Y-m-d\TH:i')) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Data di Fine</label>
                        <input type="datetime-local" name="end_date" id="end_date" class="form-control" value="{{ old('end_date', $alert->end_date->format('Y-m-d\TH:i')) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="display_location" class="form-label">Posizione di Visualizzazione</label>
                        <select name="display_location" id="display_location" class="form-select" required>
                            <option value="all_pages" {{ $alert->display_location == 'all_pages' ? 'selected' : '' }}>Tutte le Pagine</option>
                            <option value="homepage" {{ $alert->display_location == 'homepage' ? 'selected' : '' }}>Home Page</option>
                            <option value="all_categories" {{ $alert->display_location == 'all_categories' ? 'selected' : '' }}>Tutte le Categorie</option>
                            <option value="specific_categories" {{ $alert->display_location == 'specific_categories' ? 'selected' : '' }}>Categorie Specifiche</option>
                            <option value="all_products" {{ $alert->display_location == 'all_products' ? 'selected' : '' }}>Tutti i Prodotti</option>
                            <option value="specific_products" {{ $alert->display_location == 'specific_products' ? 'selected' : '' }}>Prodotti Specifici</option>
                        </select>
                    </div>
                    <div id="specific_selection" style="display: none;">
                        <div class="mb-3" id="category_selection" style="display: none;">
                            <label for="categories" class="form-label">Seleziona Categorie</label>
                            <select name="categories[]" id="categories" class="form-select select2" multiple>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ in_array($category->id, old('categories', explode(',', $alert->category_ids) ?? [])) ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="form-check mt-2">
                                <input type="checkbox" class="form-check-input" id="include_products" name="include_products" {{ $alert->include_products ? 'checked' : '' }}>
                                <label class="form-check-label" for="include_products">Includi Categorie figlio e Prodotti della Categorie Selezionate</label>
                            </div>
                        </div>
                        <div class="mb-3" id="product_selection" style="display: none;">
                            <label for="products" class="form-label">Seleziona Prodotti</label>
                            <select name="products[]" id="products" class="form-select select2" multiple>
                                @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ in_array($product->id, explode(',', $alert->product_ids)) ? 'selected' : '' }}>{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="mb-4">
                        <button class="btn btn-primary" type="submit">
                            <i data-feather="save" class="me-1"></i> Salva
                        </button>
                    </div>
                </div>
            </div>
            <!-- Pulsante di submit -->
            </form>
        </div>
    </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestione della selezione della posizione di visualizzazione
        const displayLocation = document.getElementById('display_location');
        const specificSelection = document.getElementById('specific_selection');
        const categorySelection = document.getElementById('category_selection');
        const productSelection = document.getElementById('product_selection');

        const setDisplayOptions = () => {
            if (displayLocation.value === 'specific_categories') {
                specificSelection.style.display = 'block';
                categorySelection.style.display = 'block';
                productSelection.style.display = 'none';
            } else if (displayLocation.value === 'specific_products') {
                specificSelection.style.display = 'block';
                categorySelection.style.display = 'none';
                productSelection.style.display = 'block';
            } else {
                specificSelection.style.display = 'none';
                categorySelection.style.display = 'none';
                productSelection.style.display = 'none';
            }
        };

        displayLocation.addEventListener('change', setDisplayOptions);
        setDisplayOptions();
    });
</script>
@endsection