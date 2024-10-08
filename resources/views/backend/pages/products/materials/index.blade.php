@extends('backend.layouts.master')

@section('title')
{{ localize('Materials') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
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
                            <h2 class="h5 mb-lg-0">{{ localize('Materiali') }}</h2>
                        </div>
                        <div class="tt-action">

                            <a href="{{ route('admin.materials.create') }}" class="btn btn-primary"><i data-feather="plus"></i> {{ localize('Aggiungi materiale') }}</a>

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
                                                    <input class="form-control rounded-start w-100" type="text" id="search" name="search" placeholder="{{ localize('Search') }}" @isset($searchKey) value="{{ $searchKey }}" @endisset>
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
                                        <th class="text-center" width="5%"></th>
                                        <th>{{ localize('Name') }}</th>
                                        <th data-breakpoints="xs sm">{{ localize('Active') }}</th>
                                        <th data-breakpoints="xs sm" class="text-end">
                                            {{ localize('Action') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($materials as $key => $material)
                                    <tr data-id="{{ $material->id }}">
                                        <td class="handle"> <i class="fa-solid fa-bars"></i></td>
                                        <td>

                                        <a href="{{ route('admin.materials.edit', ['id' => $material->id, 'lang_key' => env('DEFAULT_LANGUAGE')]) }}" class="d-flex align-items-center">
                                                <!-- <div class="avatar avatar-sm">
                                                    <img class="rounded-circle" src="{{ uploadedAsset($material->thumbnail_image) }}" alt="" onerror="this.onerror=null;this.src='{{ staticAsset('backend/assets/img/placeholder-thumb.png') }}';" />
                                                </div> -->
                                                <h6 class="fs-sm mb-0 ms-2">
                                                    {{ $material->collectLocalization('name') }}
                                                </h6>
                                            </a>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input" onchange="updateStatus(this)" @if ($material->is_active) checked @endif
                                                value="{{ $material->id }}">
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown tt-tb-dropdown">
                                                <button type="button" class="btn p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i data-feather="more-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end shadow">

                                                    <a class="dropdown-item" href="{{ route('admin.materials.edit', ['id' => $material->id, 'lang_key' => env('DEFAULT_LANGUAGE')]) }}&localize">
                                                        <i data-feather="edit-3" class="me-2"></i>{{ localize('Edit') }}
                                                    </a>

                                                    <a href="#" class="dropdown-item confirm-delete" data-href="{{ route('admin.materials.delete', $material->id) }}" title="{{ localize('Delete') }}">
                                                        <i data-feather="trash" class="me-2"></i>{{ localize('Delete') }}
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

                @can('add_materials')
                <form action="{{ route('admin.materials.store') }}" class="pb-650" method="POST">
                    <!-- ... (Rest of the form remains unchanged, just replace "variation" with "material") ... -->
                </form>
                @endcan
            </div>

        </div>

    </div>
</section>
@endsection

@section('scripts')
<script>
    'use strict';

    function updateStatus(el) {
        if (el.checked) {
            var is_active = 1;
        } else {
            var is_active = 0;
        }
        $.post('{{ route("admin.materials.updateStatus") }}', {
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
</script>

<script>
    // table-sort.js
    document.addEventListener('DOMContentLoaded', (event) => {
        const tableBody = document.querySelector('.table tbody');
        const sortable = new Sortable(tableBody, {
            // ... (Rest of the script remains unchanged, just replace "variation" with "material") ...
        });
    });
</script>
@endsection