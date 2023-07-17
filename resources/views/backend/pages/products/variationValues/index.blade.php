@extends('backend.layouts.master')

@section('title')
    {{ localize('Variation values') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-lg-0">{{ localize('Values') }} -
                                    {{ $variation->collectLocalization('name') }}</h2>
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
                                            <th class="text-center" width="7%">{{ localize('S/L') }}</th>
                                            <th class="all">{{ localize('Name') }}</th>
                                            @if ($variation->id == 2)
                                                <th class="all">{{ localize('Code') }}</th>
                                            @endif
                                            <th data-breakpoints="xs sm">{{ localize('Active') }}</th>
                                            <th data-breakpoints="xs sm" class="text-end">
                                                {{ localize('Action') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($variationValues as $key => $variationValue)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $key + 1 + ($variationValues->currentPage() - 1) * $variationValues->perPage() }}
                                                </td>
                                                <td>
                                                    <a class="javascript:void(0);" class="d-flex align-items-center">
                                                        <h6 class="fs-sm mb-0">
                                                            {{ $variationValue->collectLocalization('name') }}</h6>
                                                    </a>
                                                </td>

                                                @if ($variation->id == 2)
                                                    <td>
                                                        {{ $variationValue->color_code }}
                                                    </td>
                                                @endif

                                                <td>
                                                    @can('publish_variation_values')
                                                        <div class="form-check form-switch">
                                                            <input type="checkbox" class="form-check-input"
                                                                onchange="updateStatus(this)"
                                                                @if ($variationValue->is_active) checked @endif
                                                                value="{{ $variationValue->id }}">
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
                                                            @can('edit_variation_values')
                                                                <a class="dropdown-item"
                                                                    href="{{ route('admin.variationValues.edit', ['id' => $variationValue->id, 'lang_key' => env('DEFAULT_LANGUAGE')]) }}&localize">
                                                                    <i data-feather="edit-3"
                                                                        class="me-2"></i>{{ localize('Edit') }}
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
                                        {{ $variationValues->firstItem() }}-{{ $variationValues->lastItem() }}
                                        {{ localize('of') }}
                                        {{ $variationValues->total() }} {{ localize('results') }}</span>
                                    <nav>
                                        {{ $variationValues->appends(request()->input())->links() }}
                                    </nav>
                                </div>
                                <!--pagination end-->

                            </div>
                        </div>
                    </div>

                    @can('add_variation_values')
                        <form action="{{ route('admin.variationValues.store') }}" class="pb-650" method="POST">
                            @csrf
                            <input type="hidden" name="variation_id" value="{{ $variation->id }}">
                            <!--variation value info start-->
                            <div class="card mb-4" id="section-2">
                                <div class="card-body">
                                    <h5 class="mb-4">{{ localize('Add New Variation Value') }}</h5>

                                    <div class="mb-4">
                                        <label for="name" class="form-label">{{ localize('Variation Value Name') }}</label>
                                        <input class="form-control" type="text" id="name" name="name"
                                            placeholder="{{ localize('Type variation value name') }}" required>
                                    </div>

                                    @if ($variation->id == 2)
                                        <div class="mb-4">
                                            <label for="name" class="form-label">{{ localize('Color Code') }}</label>
                                            <input type="color" name="color_code" id="color_code" class="form-control">
                                        </div>
                                    @endif

                                </div>
                            </div>
                            <!-- variation info end-->

                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-4">
                                        <button class="btn btn-primary" type="submit">
                                            <i data-feather="save" class="me-1"></i> {{ localize('Save Value') }}
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
                            <h5 class="mb-4">{{ localize('Variation Value Information') }}</h5>
                            <div class="tt-vertical-step">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="#section-1" class="active">{{ localize('All Variation Values') }}</a>
                                    </li>

                                    @can('add_variation_values')
                                        <li>
                                            <a href="#section-2">{{ localize('Add New Variation Value') }}</a>
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
            $.post('{{ route('admin.variationValues.updateStatus') }}', {
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
