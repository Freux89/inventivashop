@extends('backend.layouts.master')

@section('title')
{{ localize('Condizioni') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
<section class="tt-section pt-4">
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">{{ localize('Condizioni') }}</h2>
                        </div>
                        <div class="tt-action">

                            <a href="{{ route('admin.conditions.create') }}" class="btn btn-primary"><i data-feather="plus"></i> {{ localize('Aggiungi Condizioni') }}</a>

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
                                                    <input class="form-control rounded-start w-100" type="text" id="search" name="search" placeholder="{{ localize('Cerca per nome condizione') }}" @isset($searchKey) value="{{ $searchKey }}" @endisset>
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
            <th class="text-start">{{ localize('Nome Condizione Gruppo') }}</th>
            <th class="text-start">{{ localize('Collegamento') }}</th>
            <th data-breakpoints="xs sm" class="text-end">{{ localize('Action') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($conditionGroups as $conditionGroup)
        <tr data-id="{{ $conditionGroup->id }}">
            <td class="text-start">
                <a href="{{ route('admin.conditions.edit', ['id' => $conditionGroup->id, 'lang_key' => config('app.locale')]) }}" class="d-inline-block">
                    <h6 class="fs-sm mb-0">
                        {{ $conditionGroup->name }}
                    </h6>
                </a>
            </td>

            <td class="text-start">
    @if($conditionGroup->product_id)
        <span class="badge bg-primary">{{ localize('Prodotto') }}</span>
        
        @else
        <span class="badge bg-warning">{{ localize('Template') }}</span>
        
    
       
    @endif
</td>

            <td class="text-end">
                <div class="dropdown tt-tb-dropdown">
                    <button type="button" class="btn p-0" data-bs-toggle="dropdown" aria-expanded="false">
                        <i data-feather="more-vertical"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end shadow">
                        <a class="dropdown-item" href="{{ route('admin.conditions.edit', ['id' => $conditionGroup->id, 'lang_key' => env('DEFAULT_LANGUAGE')]) }}&localize">
                            <i data-feather="edit-3" class="me-2"></i>{{ localize('Edit') }}
                        </a>

                        <a href="#" class="dropdown-item confirm-delete" data-href="{{ route('admin.conditions.delete', $conditionGroup->id) }}" title="{{ localize('Delete') }}">
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
                            {{ $conditionGroups->firstItem() }}-{{ $conditionGroups->lastItem() }} {{ localize('of') }}
                            {{ $conditionGroups->total() }} {{ localize('results') }}</span>
                        <nav>
                            {{ $conditionGroups->appends(request()->input())->links() }}
                        </nav>
                    </div>
                    <!--pagination end-->

                        </div>
                    </div>
                </div>

                @can('add_workflows')
                <form action="{{ route('admin.conditions.store') }}" class="pb-650" method="POST">
                    <!-- ... (Rest of the form remains unchanged, just replace "variation" with "material") ... -->
                </form>
                @endcan
            </div>

        </div>

    </div>
</section>
@endsection

@section('scripts')

@endsection