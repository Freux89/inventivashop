@extends('backend.layouts.master')

@section('title')
{{ localize('Modifica Menu') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
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
                            <h2 class="h5 mb-lg-0">{{ localize('Modifica Menu') }}</h2>
                        </div>
</div>
                        <div class="col-auto">
                            <a href="{{ route('admin.menus.index') }}" class="btn btn-link">
                                <i class="fas fa-arrow-left"></i> Torna all'elenco
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
                        <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">{{ localize('Nome Menu') }}</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $menu->name) }}" required>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="is_main" name="is_main" value="1" {{ $menu->is_main ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_main">{{ localize('Imposta come Menu Principale') }}</label>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">{{ localize('Salva Modifiche') }}</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabella degli Items del Menu -->
            
               @include('backend.pages.menus.items.index')
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<!-- Aggiungi script personalizzati se necessario -->
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
                fetch('{{ route("admin.menu-items.positions") }}', {
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