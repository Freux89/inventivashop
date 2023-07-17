@extends('backend.layouts.master')

@section('title')
    {{ localize('Shipping Cities') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body">
                            <div class="row justify-content-between align-items-center g-3">
                                <div class="col-auto flex-grow-1">
                                    <div class="tt-page-title">
                                        <h2 class="h5 mb-0">{{ localize('Shipping Citites') }}</h2>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    @include('backend.pages.fulfillments.partials.zoneNavbar')
                                </div>

                                <div class="col-auto">
                                    @can('add_shipping_cities')
                                        <a href="{{ route('admin.cities.create') }}" class="btn btn-primary"><i
                                                data-feather="plus"></i>{{ localize('Add City') }}</a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4 g-4">
                <div class="col-12">
                    <div class="card mb-4" id="section-1">
                        <form class="app-search" action="{{ Request::fullUrl() }}" method="GET">
                            <div class="card-header border-bottom-0">
                                <div class="row justify-content-between g-3">
                                    <div class="col-auto flex-grow-1">
                                        <div class="tt-search-box">
                                            <div class="input-group">
                                                <span class="position-absolute top-50 start-0 translate-middle-y ms-2">
                                                    <i data-feather="search"></i></span>
                                                <input class="form-control rounded-start w-100" type="text"
                                                    id="search" name="search" placeholder="{{ localize('Search') }}"
                                                    @isset($searchKey)
                                value="{{ $searchKey }}"
                            @endisset>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-auto">
                                        <div class="input-group">
                                            <select class="form-select select2" name="searchState">
                                                <option value="">{{ localize('Select an State') }}</option>
                                                @foreach (\App\Models\State::where('is_active', 1)->get() as $state)
                                                    <option value="{{ $state->id }}"
                                                        @if ($searchState == $state->id) selected @endif>
                                                        {{ $state->name }}</option>
                                                @endforeach
                                            </select>
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
                                    <th class="text-center">{{ localize('S/L') }}</th>
                                    <th>{{ localize('Name') }}</th>
                                    <th>{{ localize('State') }}</th>
                                    <th data-breakpoints="xs sm">{{ localize('Active') }}</th>
                                    <th data-breakpoints="xs sm" class="text-end">{{ localize('Action') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cities as $key => $city)
                                    <tr>
                                        <td class="text-center">
                                            {{ $key + 1 + ($cities->currentPage() - 1) * $cities->perPage() }}
                                        </td>

                                        <td class="fw-semibold">
                                            {{ $city->name }}
                                        </td>

                                        <td class="fw-semibold">
                                            {{ $city->state->name }}
                                        </td>

                                        <td>
                                            @can('publish_shipping_cities')
                                                <div class="form-check form-switch">
                                                    <input type="checkbox" class="form-check-input"
                                                        onchange="updateStatus(this)"
                                                        @if ($city->is_active) checked @endif
                                                        value="{{ $city->id }}">
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

                                                    @can('edit_shipping_cities')
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.cities.edit', ['id' => $city->id, 'lang_key' => env('DEFAULT_LANGUAGE')]) }}&localize">
                                                            <i data-feather="edit-3" class="me-2"></i>{{ localize('Edit') }}
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
                                {{ $cities->firstItem() }}-{{ $cities->lastItem() }}
                                {{ localize('of') }}
                                {{ $cities->total() }} {{ localize('results') }}</span>
                            <nav>
                                {{ $cities->appends(request()->input())->links() }}
                            </nav>
                        </div>
                        <!--pagination end-->
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
            $.post('{{ route('admin.cities.updateStatus') }}', {
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
