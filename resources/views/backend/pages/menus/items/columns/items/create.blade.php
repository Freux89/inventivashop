@extends('backend.layouts.master')

@section('title')
{{ localize('Aggiungi Item alla Colonna') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
<section class="tt-section pt-4">
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">

                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">{{ localize('Aggiungi Item alla Colonna') }}</h2>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.menu-columns.edit', $menuColumn->id) }}" class="btn btn-link">
                                <i class="fas fa-arrow-left"></i> {{ localize('Torna alla Colonna') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-4">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="{{ route('admin.menu-column-items.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="menu_column_id" value="{{ $menuColumn->id }}">

                            <div class="mb-3">
                                <label for="title" class="form-label">{{ localize('Titolo') }}</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}">
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Campo per la Grandezza del Font -->
                            <div class="mb-3">
                                <label for="font_size" class="form-label">{{ localize('Grandezza del Font') }}</label>
                                <input type="number" class="form-control @error('font_size') is-invalid @enderror" id="font_size" name="font_size" value="{{ old('font_size', 14) }}" min="1">
                                @error('font_size')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Campo per il Colore del Titolo -->
                            <div class="mb-3">
                                <x-color-picker
                                    id="title_color"
                                    name="title_color"
                                    value="{{ old('title_color') }}"
                                    label="{{ localize('Colore del Titolo') }}" />
                            </div>

                            <!-- Campo per il Grassetto -->
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="is_bold" name="is_bold" value="1" {{ old('is_bold') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_bold">{{ localize('Testo in Grassetto') }}</label>
                            </div>

                            <!-- Campo per il Margine Superiore -->
                            <div class="mb-3">
                                <label for="margin_top" class="form-label">{{ localize('Margine Superiore') }}</label>
                                <select class="form-select @error('margin_top') is-invalid @enderror" id="margin_top" name="margin_top">
                                    @for ($i = 0; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ old('margin_top', 0) == $i ? 'selected' : '' }}>mt-{{ $i }}</option>
                                    @endfor
                                </select>
                                @error('margin_top')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Campo per il Margine Inferiore -->
                            <div class="mb-3">
                                <label for="margin_bottom" class="form-label">{{ localize('Margine Inferiore') }}</label>
                                <select class="form-select @error('margin_bottom') is-invalid @enderror" id="margin_bottom" name="margin_bottom">
                                    @for ($i = 0; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ old('margin_bottom', 0) == $i ? 'selected' : '' }}>mb-{{ $i }}</option>
                                    @endfor
                                </select>
                                @error('margin_bottom')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Campo Tipo di Collegamento -->
                            <div class="mb-3">
                                <label class="form-label">{{ localize('Tipo di Collegamento') }}</label>
                                <select class="form-select @error('link_type') is-invalid @enderror" id="link_type" name="link_type">
                                    <option value="">{{ localize('Seleziona un tipo di collegamento') }}</option>
                                    <option value="url" {{ old('link_type') == 'url' ? 'selected' : '' }}>{{ localize('URL Personalizzato') }}</option>
                                    <option value="product" {{ old('link_type') == 'product' ? 'selected' : '' }}>{{ localize('Prodotto') }}</option>
                                    <option value="category" {{ old('link_type') == 'category' ? 'selected' : '' }}>{{ localize('Categoria') }}</option>
                                </select>
                                @error('link_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Campo URL -->
                            <div class="mb-3 link-type-field" id="url_field" style="display: none;">
                                <label for="url" class="form-label">{{ localize('URL') }}</label>
                                <input type="text" class="form-control @error('url') is-invalid @enderror" id="url" name="url" value="{{ old('url') }}">
                                @error('url')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Campo Prodotto -->
                            <div class="mb-3 link-type-field" id="product_field" style="display: none;">
                                <label for="product_id" class="form-label">{{ localize('Collega a Prodotto') }}</label>
                                <select class="form-select @error('product_id') is-invalid @enderror" id="product_id" name="product_id">
                                    <option value="">{{ localize('Seleziona un prodotto') }}</option>
                                    @foreach ($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Campo Categoria -->
                            <div class="mb-3 link-type-field" id="category_field" style="display: none;">
                                <label for="category_id" class="form-label">{{ localize('Collega a Categoria') }}</label>
                                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                                    <option value="">{{ localize('Seleziona una categoria') }}</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Campo Titolo del Link -->
                            <div class="mb-3">
                                <label for="link_title" class="form-label">{{ localize('Titolo del Link') }}</label>
                                <input type="text" class="form-control @error('link_title') is-invalid @enderror" id="link_title" name="link_title" value="{{ old('link_title') }}">
                                @error('link_title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Campo Immagine -->
                            <div class="mb-4">
                                <label class="form-label">{{ localize('Immagine') }}</label>
                                <div class="tt-image-drop rounded">
                                    <span class="fw-semibold">{{ localize('Seleziona un immagine') }}</span>
                                    <!-- choose media -->
                                    <div class="tt-product-thumb show-selected-files mt-3">
                                        <div class="avatar avatar-xl cursor-pointer choose-media"
                                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
                                            onclick="showMediaManager(this)" data-selection="single">
                                            <input type="hidden" name="image_id"
                                                value="">
                                            <div class="no-avatar rounded-circle">
                                                <span><i data-feather="plus"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- choose media -->
                                </div>
                            </div>
<!-- Campo per decidere se applicare il link anche all'immagine -->
<div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="apply_link_to_image" name="apply_link_to_image" value="1" {{ old('apply_link_to_image') ? 'checked' : '' }}>
    <label class="form-check-label" for="apply_link_to_image">{{ localize('Applica il link anche all\'immagine') }}</label>
</div>
                            <!-- Campo Descrizione -->
                            <div class="mb-3">
                                <label for="description" class="form-label">{{ localize('Descrizione') }}</label>
                                <textarea class="form-control editor @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">{{ localize('Salva Item') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const linkTypeField = document.getElementById('link_type');
        const urlField = document.getElementById('url_field');
        const productField = document.getElementById('product_field');
        const categoryField = document.getElementById('category_field');

        function toggleFields() {
            urlField.style.display = linkTypeField.value === 'url' ? 'block' : 'none';
            productField.style.display = linkTypeField.value === 'product' ? 'block' : 'none';
            categoryField.style.display = linkTypeField.value === 'category' ? 'block' : 'none';
        }

        linkTypeField.addEventListener('change', toggleFields);
        toggleFields(); // Call once on page load to set correct visibility
    });
</script>
@endsection

@endsection
