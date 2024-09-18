@extends('backend.layouts.master')

@section('title')
{{ localize('Aggiungi Item Menu') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
<section class="tt-section pt-4">
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">

                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">{{ localize('Aggiungi Item Menu') }}</h2>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.menus.edit', $menu_id) }}" class="btn btn-link">
                                <i class="fas fa-arrow-left"></i> Torna al menu
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
                        <form action="{{ route('admin.menu-items.store') }}" method="POST">
                            @csrf

                            <input type="hidden" name="menu_id" value="{{ $menu_id }}">

                            <div class="mb-3">
                                <label for="title" class="form-label">{{ localize('Titolo Item') }}</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

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