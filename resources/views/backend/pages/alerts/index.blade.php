@extends('backend.layouts.master')

@section('title')
{{ localize('Avvisi') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
<section class="tt-section pt-4">
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">{{ localize('Avvisi') }}</h2>
                        </div>
                        <div class="tt-action">
                            <a href="{{ route('admin.alerts.create') }}" class="btn btn-primary">
                                <i data-feather="plus"></i> {{ localize('Aggiungi Avviso') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-4">
            <div class="col-xl-12">
                <div class="card mb-4" id="section-1">
                    <form class="app-search" action="{{ Request::fullUrl() }}" method="GET">
                        <div class="card-header border-bottom-0">
                            <div class="row justify-content-between g-3">
                                <div class="col-auto flex-grow-1">
                                    <div class="tt-search-box">
                                        <div class="input-group">
                                            <span class="position-absolute top-50 start-0 translate-middle-y ms-2">
                                                <i data-feather="search"></i>
                                            </span>
                                            <input class="form-control rounded-start w-100" type="text" id="search" name="search" placeholder="Cerca per testo avviso o posizione" @isset($searchKey) value="{{ $searchKey }}" @endisset>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <button type="submit" class="btn btn-secondary">
                                        <i data-feather="search" width="18"></i>
                                        Cerca
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <table class="table tt-footable border-top" data-use-parent-width="true">
                        <thead>
                            <tr>
                                <th class="text-start">Titolo</th>
                                <th>Data di Inizio</th>
                                <th>Data di Fine</th>
                                <th>Posizione</th>
                                <th>Attivo</th>
                                <th class="text-end">Azione</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alerts as $key => $alert)
                            <tr data-id="{{ $alert->id }}">
                                <td class="text-start">{{ $alert->title }}</td>
                                <td>{{ optional($alert->start_date)->format('d/m/Y H:i') }}</td>
                                <td>{{ optional($alert->end_date)->format('d/m/Y H:i') }}</td>
                                <td>
                                    @php
                                        $locationText = '';
                                        switch ($alert->display_location) {
                                            case 'all_pages':
                                                $locationText = 'Tutte le Pagine';
                                                break;
                                            case 'homepage':
                                                $locationText = 'Home Page';
                                                break;
                                            case 'all_categories':
                                                $locationText = 'Tutte le Categorie';
                                                break;
                                            case 'specific_categories':
                                                $locationText = 'Categorie Specifiche';
                                                break;
                                            case 'all_products':
                                                $locationText = 'Tutti i Prodotti';
                                                break;
                                            case 'specific_products':
                                                $locationText = 'Prodotti Specifici';
                                                break;
                                        }
                                    @endphp
                                    <span @if(in_array($alert->display_location, ['specific_categories', 'specific_products'])) data-bs-toggle="tooltip" data-bs-html="true" title="
    @if($alert->display_location == 'specific_categories' && $alert->category_ids)
        Categorie Specifiche:<br>
        @foreach(explode(',', $alert->category_ids) as $categoryId)
            - {{ $categories->firstWhere('id', $categoryId)->name ?? 'Categoria non trovata' }}<br>
        @endforeach
    @endif
    @if($alert->display_location == 'specific_products' && $alert->product_ids)
        Prodotti Specifici:<br>
        @foreach(explode(',', $alert->product_ids) as $productId)
            - {{ $products->firstWhere('id', $productId)->name ?? 'Prodotto non trovato' }}<br>
        @endforeach
    @endif
" @endif>{{ $locationText }}</span>

                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" onchange="updateStatus(this)" @if ($alert->is_active) checked @endif value="{{ $alert->id }}">
                                    </div>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown tt-tb-dropdown">
                                        <button type="button" class="btn p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i data-feather="more-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end shadow">
                                            <a class="dropdown-item" href="{{ route('admin.alerts.edit', ['id' => $alert->id]) }}">
                                                <i data-feather="edit-3" class="me-2"></i>Modifica
                                            </a>
                                            <a href="#" class="dropdown-item confirm-delete" data-href="{{ route('admin.alerts.delete', $alert->id) }}" title="Elimina">
                                                <i data-feather="trash" class="me-2"></i>Elimina
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    'use strict';
    function updateStatus(el) {
        var is_active = el.checked ? 1 : 0;
        $.post('{{ route("admin.alerts.updateStatus") }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                is_active: is_active
            },
            function(data) {
                if (data == 1) {
                    notifyMe('success', 'Stato aggiornato con successo');
                } else {
                    notifyMe('danger', 'Qualcosa è andato storto');
                }
            });
    }
</script>
@endsection