@extends('backend.layouts.master')

@section('title')
{{ localize('Lavorazioni') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
<section class="tt-section pt-4">
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">{{ localize('Lavorazioni') }}</h2>
                        </div>
                        <div class="tt-action">

                            <a href="{{ route('admin.workflows.create') }}" class="btn btn-primary"><i data-feather="plus"></i> {{ localize('Aggiungi lavorazione') }}</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-4">
            <!--left sidebar-->
            <div class="col-xl-12 order-2 order-md-2 order-lg-2 order-xl-1">
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
                                                    <input class="form-control rounded-start w-100" type="text" id="search" name="search" placeholder="{{ localize('Cerca per lavorazione,variante o prodotto') }}" @isset($searchKey) value="{{ $searchKey }}" @endisset>
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
                            <table class="table tt-footable border-top" data-use-parent-width="true">
                                <thead>
                                    <tr>
                                        <th class="text-start">{{ localize('Name') }}</th>
                                        <th>{{ localize('Durata') }}</th>
                                        <th>{{localize('Associazione')}}</th>
                                        <th>{{localize('Creato il')}}</th>
                                        <th>{{localize('Modificato il')}}</th>
                                        <!-- <th data-breakpoints="xs sm">{{ localize('Active') }}</th> -->
                                        <th data-breakpoints="xs sm" class="text-end">
                                            {{ localize('Action') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($workflows as $key => $workflow)
                                    <tr data-id="{{ $workflow->id }}">
                                        <td class="text-start">

                                            <a href="{{ route('admin.workflows.edit', ['id' => $workflow->id, 'lang_key' => env('DEFAULT_LANGUAGE')]) }}" class="d-inline-block">

                                                <h6 class="fs-sm mb-0">
                                                    {{ $workflow->name }}
                                                </h6>
                                            </a>
                                        </td>
                                        <td>{{ $workflow->duration }} {{localize('giorni')}}</td>
                                        <td> <span style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-html="true" title="
                                        @if($workflow->categories->isNotEmpty())
        Categorie:<br>
        @foreach($workflow->categories as $category)
            {{ $category->name }}<br>
        @endforeach
    @endif                                    
    @if($workflow->products->isNotEmpty())
        Prodotti:<br>
        @foreach($workflow->products as $product)
            {{ $product->name }}<br>
        @endforeach
    @endif
    @if($workflow->variationValues->isNotEmpty())
        Varianti:<br>
        @foreach($workflow->variationValues as $variationValue)
            {{ $variationValue->name }}<br>
        @endforeach
    @endif
    ">
                                                {{ $workflow->categories->count() + $workflow->products->count() + $workflow->variationValues->count() }}
                                            </span></td>
                                        <td>{{ optional($workflow->created_at)->format('d/m/Y H:i') }}</td>
                                        <td>{{ optional($workflow->updated_at)->format('d/m/Y H:i') }}</td>
                                        <!-- <td>
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input" onchange="updateStatus(this)" @if ($workflow->is_active) checked @endif
                                                value="{{ $workflow->id }}">
                                            </div>
                                        </td> -->
                                        <td class="text-end">
                                            <div class="dropdown tt-tb-dropdown">
                                                <button type="button" class="btn p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i data-feather="more-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end shadow">

                                                    <a class="dropdown-item" href="{{ route('admin.workflows.edit', ['id' => $workflow->id, 'lang_key' => env('DEFAULT_LANGUAGE')]) }}&localize">
                                                        <i data-feather="edit-3" class="me-2"></i>{{ localize('Edit') }}
                                                    </a>

                                                    <a href="#" class="dropdown-item confirm-delete" data-href="{{ route('admin.workflows.delete', $workflow->id) }}" title="{{ localize('Delete') }}">
                                                        <i data-feather="trash" class="me-2"></i>{{ localize('Delete') }}
                                                    </a>

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!--pagination start-->
                            <div class="d-flex align-items-center justify-content-between px-4 pb-4">
                                <span>{{ localize('Showing') }}
                                    {{ $workflows->firstItem() }}-{{ $workflows->lastItem() }} {{ localize('of') }}
                                    {{ $workflows->total() }} {{ localize('results') }}</span>
                                <nav>
                                    {{ $workflows->appends(request()->input())->links() }}
                                </nav>
                            </div>
                            <!--pagination end-->

                        </div>
                    </div>
                </div>

                @can('add_workflows')
                <form action="{{ route('admin.workflows.store') }}" class="pb-650" method="POST">
                    <!-- ... (Rest of the form remains unchanged, just replace "variation" with "material") ... -->
                </form>
                @endcan
            </div>

        </div>

    </div>
</section>
@endsection

@section('scripts')
<!-- <script>
    'use strict';

    function updateStatus(el) {
        if (el.checked) {
            var is_active = 1;
        } else {
            var is_active = 0;
        }
        $.post('{{ route("admin.workflows.updateStatus") }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                is_active: is_active
            },
            function(data) {
                if (data == 1) {
                    notifyMe('success', '{{ localize("Status updated successfully") }}');
                } else {
                    notifyMe('danger', '{{ localize("Something went wrong") }}');
                }
            });
    }
</script> -->

@endsection