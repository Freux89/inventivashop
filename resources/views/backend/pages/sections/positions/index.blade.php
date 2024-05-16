@extends('backend.layouts.master')

@section('title')
{{ localize('Posizioni delle Sezioni') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection
@section('extra-head')



<style>
    tr.no-positions td:not(:first-child) {
        display: none !important;
    }
</style>
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
                            <h2 class="h5 mb-lg-0">{{ localize('Posizioni delle Sezioni') }}</h2>
                        </div>
                        <div class="tt-action">

                            <a href="{{ route('admin.section_positions.create') }}" class="btn btn-primary"><i data-feather="plus"></i> {{ localize('Posiziona Sezione') }}</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-4">
            <!--left sidebar-->
            <div class="col-xl-12 order-2 order-md-2 order-lg-2 order-xl-1 ">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4" id="section-1">
                            <form class="app-search" action="{{ Request::fullUrl() }}" method="GET">
                                <div class="card-header border-bottom-0">
                                    <div class="row justify-content-between g-3">
                                        <div class="col-auto flex-grow-1">
                                            <div class="tt-search-box">
                                                <div class="input-group">
                                                    <span class="position-absolute top-50 start-0 translate-middle-y ms-2"> <i data-feather="search"></i></span>
                                                    <input class="form-control rounded-start w-100" type="text" id="search" name="search" placeholder="{{ localize('Cerca per nome sezione') }}" @isset($searchKey) value="{{ $searchKey }}" @endisset>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-secondary">
                                                <i data-feather="search" width="18"></i>
                                                {{ localize('Search') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            @foreach ($positions as $positionableType => $hooks)
                            <div class="col-12 bg-white p-5">
                                <h5>{{ localize($positionableType) }}</h5>
                                @foreach ($hooks as $hookName => $sectionPositions)
                                <h6>{{ localize($hookName) }}</h6>
                                <table class="table tt-footable border-top" data-use-parent-width="true">
                                    <thead>
                                        <tr>
                                        <th style="width:5%"></th>
                <th style="width:5%">{{ localize('ID') }}</th>
                <th class="col-5">{{ localize('Section Name') }}</th>
                <th class="col-3">{{ localize('Tipologia pagina') }}</th>
                <th class="col-1 text-end">{{ localize('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($sectionPositions as $position)
                                        <tr data-id="{{ $position->id }}">
                                            <td class="handle"><i class="fa-solid fa-bars"></i></td>
                                            <td>{{ $position->id }}</td>
                                            <td><strong>{{ $position->section->name }}</strong></td>
                                            <td>
    @if($positionableType !== 'Home')
        @php
            $entities = $position->positionableEntities;
            $typeNames = [
                'Category' => ['plural' => 'Categorie', 'singular' => 'Categoria', 'all' => 'Tutte le categorie'],
                'Product' => ['plural' => 'Prodotti', 'singular' => 'Prodotto', 'all' => 'Tutti i prodotti'],
                'Page' => ['plural' => 'Pagine', 'singular' => 'Pagina', 'all' => 'Tutte le pagine']
            ];
            $displayName = $typeNames[$positionableType] ?? ['plural' => 'Elementi', 'singular' => 'Elemento', 'all' => 'Tutti gli elementi'];
        @endphp
        @if($entities->count() > 0)
            <span style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-html="true" title="
                {{ $displayName['plural'] }} Selezionate:<br>
                @foreach($entities as $entity)
                    {{ $entity->name }}<br>
                @endforeach
            ">
                {{ $entities->count() }} {{ $displayName['plural'] }} Selezionate
            </span>
        @else
            {{ $displayName['all'] }}
        @endif
    @else
        {{ localize('N/A') }}
    @endif
</td>





                                            <td class="text-end">
                                                <div class="dropdown tt-tb-dropdown">
                                                    <button type="button" class="btn p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i data-feather="more-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow">
                                                        <a class="dropdown-item" href="{{ route('admin.section_positions.edit', $position->id) }}">
                                                            <i data-feather="edit-3" class="me-2"></i>{{ localize('Edit') }}
                                                        </a>
                                                        <a href="#" class="dropdown-item confirm-delete" data-href="{{ route('admin.section_positions.delete', $position->id) }}" title="{{ localize('Delete') }}">
                                                            <i data-feather="trash" class="me-2"></i>{{ localize('Delete') }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr class="no-positions">
                                            <td colspan="5" class="text-center">{{ localize('No positions available') }}</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                @endforeach
                            </div>
                            @endforeach





                        </div>
                    </div>
                </div>


            </div>

        </div>

    </div>
</section>
@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Seleziona tutte le tabelle che devono essere ordinabili
        const tables = document.querySelectorAll('.table');

        tables.forEach(table => {
            const tableBody = table.querySelector('tbody');
            if (tableBody) {
                const sortable = new Sortable(tableBody, {
                    handle: '.handle',  // Class name of the handle
                    animation: 150,  // Animation speed when sorting
                    onUpdate() {
                        const order = this.toArray();
                        // Send the new order to the server
                        fetch('{{ route("admin.section_positions.positions") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure CSRF token is correctly handled
                            },
                            body: JSON.stringify({
                                positions: order,
                                tableId: table.dataset.tableId // Assuming each table has a unique data attribute
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                console.log('Positions updated successfully');
                            } else {
                                console.error('Failed to update positions');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                    }
                });
            }
        });
    });
</script>


@endsection