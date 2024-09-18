@extends('backend.layouts.master')

@section('title')
{{ localize('Gestione Menu') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
<section class="tt-section pt-4">
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">{{ localize('Gestione Menu') }}</h2>
                        </div>
                        <div class="tt-action">
                            <a href="{{ route('admin.menus.create') }}" class="btn btn-primary">
                                <i data-feather="plus"></i> {{ localize('Aggiungi Menu') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-4">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4">
                            <form class="app-search" action="{{ Request::fullUrl() }}" method="GET">
                                <div class="card-header border-bottom-0">
                                    <div class="row justify-content-between g-3">
                                        <div class="col-auto flex-grow-1">
                                            <div class="tt-search-box">
                                                <div class="input-group">
                                                    <span class="position-absolute top-50 start-0 translate-middle-y ms-2"> 
                                                        <i data-feather="search"></i>
                                                    </span>
                                                    <input class="form-control rounded-start w-100" type="text" id="search" name="search" placeholder="{{ localize('Cerca per nome menu') }}" @isset($searchKey) value="{{ $searchKey }}" @endisset>
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
                                        <th class="text-start">{{ localize('Nome Menu') }}</th>
                                        <th class="text-start">{{ localize('Principale') }}</th>
                                        <th data-breakpoints="xs sm" class="text-end">{{ localize('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($menus as $menu)
                                    <tr data-id="{{ $menu->id }}">
                                        <td class="text-start">
                                            <a href="{{ route('admin.menus.edit', $menu->id) }}" class="d-inline-block">
                                                <h6 class="fs-sm mb-0">{{ $menu->name }}</h6>
                                            </a>
                                        </td>
                                        <td class="text-start">
                                            @if($menu->is_main)
                                                <span class="badge bg-success">{{ localize('Sì') }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ localize('No') }}</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown tt-tb-dropdown">
                                                <button type="button" class="btn p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i data-feather="more-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end shadow">
                                                    <a class="dropdown-item" href="{{ route('admin.menus.edit', $menu->id) }}">
                                                        <i data-feather="edit-3" class="me-2"></i>{{ localize('Edit') }}
                                                    </a>
                                                    <a href="#" class="dropdown-item confirm-delete" data-href="{{ route('admin.menus.delete', $menu->id) }}" title="{{ localize('Delete') }}">
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
                                    {{ $menus->firstItem() }}-{{ $menus->lastItem() }} {{ localize('of') }}
                                    {{ $menus->total() }} {{ localize('results') }}</span>
                                <nav>
                                    {{ $menus->appends(request()->input())->links() }}
                                </nav>
                            </div>
                            <!--pagination end-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<!-- Aggiungi script personalizzati se necessario -->
@endsection
