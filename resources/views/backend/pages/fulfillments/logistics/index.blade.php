@extends('backend.layouts.master')

@section('title')
    {{ localize('Logistics') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-lg-0">{{ localize('Logistics') }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4 g-4">
                <!--left sidebar-->
                <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-4" id="section-1">
                                <form class="app-search" action="{{ Request::fullUrl() }}" method="GET">
                                    <div class="card-header border-bottom-0">
                                        <div class="row justify-content-between g-3">
                                            <div class="col-auto flex-grow-1">
                                                <div class="tt-search-box">
                                                    <div class="input-group">
                                                        <span
                                                            class="position-absolute top-50 start-0 translate-middle-y ms-2">
                                                            <i data-feather="search"></i></span>
                                                        <input class="form-control rounded-start w-100" type="text"
                                                            id="search" name="search"
                                                            placeholder="{{ localize('Search') }}"
                                                            @isset($searchKey)
                                        value="{{ $searchKey }}"
                                    @endisset>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <button type="submit" class="btn btn-primary">
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
                                            <th class="text-center">{{ localize('S/L') }}</th>
                                            <th>{{ localize('Name') }}</th>
                                            <th data-breakpoints="xs sm">{{ localize('Active') }}</th>
                                            <th data-breakpoints="xs sm" class="text-end">{{ localize('Action') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($logistics as $key => $logistic)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $key + 1 + ($logistics->currentPage() - 1) * $logistics->perPage() }}
                                                </td>

                                                <td>
                                                    <a class="d-flex align-items-center">
                                                        <div class="avatar avatar-sm">
                                                            <img class="rounded-circle"
                                                                src="{{ uploadedAsset($logistic->thumbnail_image) }}"
                                                                alt="{{ $logistic->name }}" />
                                                        </div>
                                                        <h6 class="fs-sm mb-0 ms-2"> {{ $logistic->name }}
                                                        </h6>
                                                    </a>
                                                </td>


                                                <td>
                                                    @can('publish_logistics')
                                                        <div class="form-check form-switch">
                                                            <input type="checkbox" class="form-check-input"
                                                                onchange="updateStatus(this)"
                                                                @if ($logistic->is_published) checked @endif
                                                                value="{{ $logistic->id }}">
                                                        </div>
                                                    @endcan
                                                </td>

                                                <td class="text-end">
                                                    <div class="dropdown tt-tb-dropdown">
                                                        <button type="button" class="btn p-0" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            <i data-feather="more-vertical"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end shadow">
                                                            @can('edit_logistics')
                                                                <a class="dropdown-item"
                                                                    href="{{ route('admin.logistics.edit', ['id' => $logistic->id, 'lang_key' => env('DEFAULT_LANGUAGE')]) }}&localize">
                                                                    <i data-feather="edit-3"
                                                                        class="me-2"></i>{{ localize('Edit') }}
                                                                </a>
                                                            @endcan

                                                            @can('delete_logistics')
                                                                <a href="#" class="dropdown-item confirm-delete"
                                                                    data-href="{{ route('admin.logistics.delete', $logistic->id) }}"
                                                                    title="{{ localize('Delete') }}">
                                                                    <i data-feather="trash-2" class="me-2"></i>
                                                                    {{ localize('Delete') }}
                                                                </a>
                                                            @endcan
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
                                        {{ $logistics->firstItem() }}-{{ $logistics->lastItem() }} {{ localize('of') }}
                                        {{ $logistics->total() }} {{ localize('results') }}</span>
                                    <nav>
                                        {{ $logistics->appends(request()->input())->links() }}
                                    </nav>
                                </div>
                                <!--pagination end-->
                            </div>
                        </div>

                        @can('add_logistics')
                            <form action="{{ route('admin.logistics.store') }}" class="pb-650" method="POST">
                                @csrf
                                <!-- Logistic info start-->
                                <div class="card mb-4" id="section-2">
                                    <div class="card-body">
                                        <h5 class="mb-4">{{ localize('Add New Logistic') }}</h5>

                                        <div class="mb-4">
                                            <label for="name" class="form-label">{{ localize('Logistic Name') }}</label>
                                            <input class="form-control" type="text" id="name" name="name"
                                                placeholder="{{ localize('Type logistic name') }}" required>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">{{ localize('Logistic Image') }}</label>
                                            <div class="tt-image-drop rounded">
                                                <span class="fw-semibold">{{ localize('Choose Logistic Thumbnail') }}</span>
                                                <!-- choose media -->
                                                <div class="tt-product-thumb show-selected-files mt-3">
                                                    <div class="avatar avatar-xl cursor-pointer choose-media"
                                                        data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
                                                        onclick="showMediaManager(this)" data-selection="single">
                                                        <input type="hidden" name="image">
                                                        <div class="no-avatar rounded-circle">
                                                            <span><i data-feather="plus"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- choose media -->
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- Logistic info end-->

                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-4">
                                            <button class="btn btn-primary" type="submit">
                                                <i data-feather="save" class="me-1"></i> {{ localize('Save Logistic') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endcan
                    </div>
                </div>

                <!--right sidebar-->
                <div class="col-xl-3 order-1 order-md-1 order-lg-1 order-xl-2">
                    <div class="card tt-sticky-sidebar">
                        <div class="card-body">
                            <h5 class="mb-4">Logistic Information</h5>
                            <div class="tt-vertical-step">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="#section-1" class="active">All Logistics</a>
                                    </li>

                                    @can('add_logistics')
                                        <li>
                                            <a href="#section-2">Add New Logistic</a>
                                        </li>
                                    @endcan
                                </ul>
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
        "use strict";

        function updateStatus(el) {
            if (el.checked) {
                var is_published = 1;
            } else {
                var is_published = 0;
            }
            $.post('{{ route('admin.logistics.updateStatus') }}', {
                    _token: '{{ csrf_token() }}',
                    id: el.value,
                    is_published: is_published
                },
                function(data) {
                    if (data == 1) {
                        notifyMe('success', '{{ localize('Status updated successfully') }}');
                    } else {
                        notifyMe('danger', '{{ localize('Something went wrong') }}');
                    }
                });
        }
    </script>
@endsection
