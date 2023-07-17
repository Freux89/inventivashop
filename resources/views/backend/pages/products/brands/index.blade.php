@extends('backend.layouts.master')

@section('title')
    {{ localize('Brands') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-lg-0">{{ localize('Brands') }}</h2>
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
                                                <div class="input-group">
                                                    <select class="form-select select2" name="is_published"
                                                        data-minimum-results-for-search="Infinity">
                                                        <option value="">{{ localize('Select status') }}</option>
                                                        <option value="1"
                                                            @isset($is_published)
                                                             @if ($is_published == 1) selected @endif
                                                            @endisset>
                                                            {{ localize('Active') }}</option>
                                                        <option value="0"
                                                            @isset($is_published)
                                                             @if ($is_published == 0) selected @endif
                                                            @endisset>
                                                            {{ localize('Hidden') }}</option>
                                                    </select>
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
                                            <th class="text-center" width="7%">{{ localize('S/L') }}</th>
                                            <th class="all">{{ localize('Name') }}</th>
                                            <th data-breakpoints="xs sm">{{ localize('Active') }}</th>
                                            <th data-breakpoints="xs sm" class="text-end">
                                                {{ localize('Action') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($brands as $key => $brand)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $key + 1 + ($brands->currentPage() - 1) * $brands->perPage() }}
                                                </td>
                                                <td>
                                                    <a class="d-flex align-items-center">
                                                        <div class="avatar avatar-sm">
                                                            <img class="rounded-circle"
                                                                src="{{ uploadedAsset($brand->collectLocalization('brand_image')) }}"
                                                                alt=""
                                                                onerror="this.onerror=null;this.src='{{ staticAsset('backend/assets/img/placeholder-thumb.png') }}';" />
                                                        </div>
                                                        <h6 class="fs-sm mb-0 ms-2">
                                                            {{ $brand->collectLocalization('name') }}</h6>
                                                    </a>
                                                </td>
                                                <td>
                                                    @can('publish_brands')
                                                        <div class="form-check form-switch">
                                                            <input type="checkbox" class="form-check-input"
                                                                onchange="updateStatus(this)"
                                                                @if ($brand->is_active) checked @endif
                                                                value="{{ $brand->id }}">
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


                                                            @can('edit_brands')
                                                                <a class="dropdown-item"
                                                                    href="{{ route('admin.brands.edit', ['id' => $brand->id, 'lang_key' => env('DEFAULT_LANGUAGE')]) }}&localize">
                                                                    <i data-feather="edit-3"
                                                                        class="me-2"></i>{{ localize('Edit') }}
                                                                </a>
                                                            @endcan

                                                            @can('delete_brands')
                                                                <a href="#" class="dropdown-item confirm-delete"
                                                                    data-href="{{ route('admin.brands.delete', $brand->id) }}"
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
                                        {{ $brands->firstItem() }}-{{ $brands->lastItem() }} {{ localize('of') }}
                                        {{ $brands->total() }} {{ localize('results') }}</span>
                                    <nav>
                                        {{ $brands->appends(request()->input())->links() }}
                                    </nav>
                                </div>
                                <!--pagination end-->

                            </div>
                        </div>
                    </div>

                    @can('add_brands')
                        <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data"
                            class="pb-650">
                            @csrf
                            <!--brand info start-->
                            <div class="card mb-4" id="section-2">
                                <div class="card-body">
                                    <h5 class="mb-4">{{ localize('Add New Brand') }}</h5>

                                    <div class="mb-4">
                                        <label for="name" class="form-label">{{ localize('Brand Name') }}</label>
                                        <input type="text" name="name" id="name"
                                            placeholder="{{ localize('Type brand name') }}" class="form-control" required>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">{{ localize('Brand Image') }}</label>
                                        <div class="tt-image-drop rounded">
                                            <span class="fw-semibold">{{ localize('Choose Brand Thumbnail') }}</span>
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
                            <!--brand info end-->

                            <!--seo meta description start-->
                            <div class="card mb-4" id="section-3">
                                <div class="card-body">
                                    <h5 class="mb-4">{{ localize('SEO Meta Configuration') }}</h5>

                                    <div class="mb-4">
                                        <label for="meta_title" class="form-label">{{ localize('Meta Title') }}</label>
                                        <input type="text" name="meta_title" id="meta_title"
                                            placeholder="{{ localize('Type meta title') }}" class="form-control">
                                        <span class="fs-sm text-muted">
                                            {{ localize('Set a meta tag title. Recommended to be simple and unique.') }}
                                        </span>
                                    </div>

                                    <div class="mb-4">
                                        <label for="meta_description"
                                            class="form-label">{{ localize('Meta Description') }}</label>
                                        <textarea class="form-control" name="meta_description" id="meta_description" rows="4"
                                            placeholder="{{ localize('Type your meta description') }}"></textarea>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">{{ localize('Meta Image') }}</label>
                                        <div class="tt-image-drop rounded">
                                            <span class="fw-semibold">{{ localize('Choose Meta Image') }}</span>
                                            <!-- choose media -->
                                            <div class="tt-product-thumb show-selected-files mt-3">
                                                <div class="avatar avatar-xl cursor-pointer choose-media"
                                                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
                                                    onclick="showMediaManager(this)" data-selection="single">
                                                    <input type="hidden" name="meta_image">
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
                            <!--seo meta description end-->

                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-4">
                                        <button class="btn btn-primary" type="submit">
                                            <i data-feather="save" class="me-1"></i> {{ localize('Save Brand') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endcan
                </div>

                <!--right sidebar-->
                <div class="col-xl-3 order-1 order-md-1 order-lg-1 order-xl-2">
                    <div class="card tt-sticky-sidebar">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Brand Information') }}</h5>
                            <div class="tt-vertical-step">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="#section-1" class="active">{{ localize('All Brands') }}</a>
                                    </li>
                                    @can('add_brands')
                                        <li>
                                            <a href="#section-2">{{ localize('Add New Brand') }}</a>
                                        </li>
                                        <li>
                                            <a href="#section-3">{{ localize('Add Brand SEO') }}</a>
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
                var is_active = 1;
            } else {
                var is_active = 0;
            }
            $.post('{{ route('admin.brands.updateStatus') }}', {
                    _token: '{{ csrf_token() }}',
                    id: el.value,
                    is_active: is_active
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
