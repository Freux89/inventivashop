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

                            <x-link-input
    name="link"
    label="Collega a"
    :value="[
        'type' => $menuItem->link_type ?? '', 
        'url' => $menuItem->url ?? '', 
        'product_id' => $menuItem->product_id ?? '', 
        'category_id' => $menuItem->category_id ?? ''
    ]"
    :products="$products"
    :categories="$categories"
/>

                            

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