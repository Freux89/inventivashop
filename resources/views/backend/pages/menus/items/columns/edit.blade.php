@extends('backend.layouts.master')

@section('title')
{{ localize('Modifica Colonna del Menu Item') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
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

                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">{{ localize('Modifica Colonna del Menu Item') }}</h2>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.menu-items.edit', $menuColumn->menu_item_id) }}" class="btn btn-link">
                                <i class="fas fa-arrow-left"></i> {{ localize('Torna al Menu Item') }}
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
                        <form action="{{ route('admin.menu-columns.update', $menuColumn->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="menu_item_id" value="{{ $menuColumn->menu_item_id }}">

                            <div class="mb-3">
                                <label for="title" class="form-label">{{ localize('Titolo Colonna') }}</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $menuColumn->title) }}" required>
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="column_width" class="form-label">{{ localize('Larghezza Colonna (1-12)') }}</label>
                                <select class="form-select @error('column_width') is-invalid @enderror" id="column_width" name="column_width">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ old('column_width', $menuColumn->column_width) == $i ? 'selected' : '' }}>col-{{ $i }}</option>
                                    @endfor
                                </select>
                                <small class="form-text text-muted">
                                    {{ localize('Seleziona la larghezza della colonna da 1 a 12. Ad esempio, 1 significa che la colonna occuperà una piccola parte della riga, mentre 12 significa che la colonna occuperà l\'intera riga.') }}
                                </small>
                                @error('column_width')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
<!-- Padding sinistro -->
<div class="mb-3">
        <label for="padding_left" class="form-label">{{ localize('Padding Sinistro (0-9)') }}</label>
        <select class="form-select @error('padding_left') is-invalid @enderror" id="padding_left" name="padding_left">
            @for ($i = 0; $i <= 9; $i++)
                <option value="{{ $i }}" {{ old('padding_left', $menuColumn->padding_left) == $i ? 'selected' : '' }}>ps-{{ $i }}</option>
            @endfor
        </select>
        @error('padding_left')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <!-- Padding destro -->
    <div class="mb-3">
        <label for="padding_right" class="form-label">{{ localize('Padding Destro (0-9)') }}</label>
        <select class="form-select @error('padding_right') is-invalid @enderror" id="padding_right" name="padding_right">
            @for ($i = 0; $i <= 9; $i++)
                <option value="{{ $i }}" {{ old('padding_right', $menuColumn->padding_right) == $i ? 'selected' : '' }}>pe-{{ $i }}</option>
            @endfor
        </select>
        @error('padding_right')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <!-- Bordo sinistro -->
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" id="border_left" name="border_left" {{ old('border_left', $menuColumn->border_left) ? 'checked' : '' }}>
        <label class="form-check-label" for="border_left">{{ localize('Attiva Bordo Sinistro') }}</label>
    </div>

    <!-- Bordo destro -->
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" id="border_right" name="border_right" {{ old('border_right', $menuColumn->border_right) ? 'checked' : '' }}>
        <label class="form-check-label" for="border_right">{{ localize('Attiva Bordo Destro') }}</label>
    </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">{{ localize('Aggiorna Colonna') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @include('backend.pages.menus.items.columns.items.index')
    </div>
</section>
@endsection

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
                fetch('{{ route("admin.menu-column-items.positions") }}', {
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
