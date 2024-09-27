@extends('backend.layouts.master')

@section('title')
{{ localize('Modifica Item Menu') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection
@section('extra-head')
<script src="{{ staticAsset('backend/assets/js/vendors/Sortable.min.js') }}"></script>
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
                            <h2 class="h5 mb-lg-0">{{ localize('Modifica Item Menu') }}</h2>
                        </div>
</div>
                        <div class="col-auto">
                            <a href="{{ route('admin.menus.edit', $menuItem->menu->id) }}" class="btn btn-link">
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
                        <form action="{{ route('admin.menu-items.update', $menuItem->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="menu_id" value="{{ $menuItem->menu_id }}">

                            <div class="mb-3">
                                <label for="title" class="form-label">{{ localize('Titolo Item') }}</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $menuItem->title) }}" required>
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
                                <button type="submit" class="btn btn-primary">{{ localize('Salva Modifiche') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @include('backend.pages.menus.items.columns.index')
    </div>
</section>

@section('scripts')

<!-- Script per Ordinamento Drag & Drop -->
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const tableBody = document.querySelector('.table tbody');
        const sortable = new Sortable(tableBody, {
            handle: '.handle',  // Classe del handle
            animation: 150,  // Velocità dell'animazione durante l'ordinamento
            onUpdate() {
                const order = Array.from(tableBody.querySelectorAll('tr')).map(row => row.dataset.id);
                // Invia il nuovo ordine al server
                fetch('{{ route("admin.menu-columns.positions") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Token CSRF per Laravel
                    },
                    body: JSON.stringify({ positions: order })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        console.log('Posizioni aggiornate con successo');
                    } else {
                        console.error('Aggiornamento delle posizioni fallito');
                    }
                })
                .catch(error => console.error('Errore:', error));
            }
        });
    });
</script>

@endsection

@endsection
