@extends('backend.layouts.master')

@section('title')
    {{ localize('Shipping Countries') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
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
                                        <h2 class="h5 mb-0">{{ localize('Shipping Countries') }}</h2>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    @include('backend.pages.fulfillments.partials.zoneNavbar')
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
                                    <th>{{ localize('Code') }}</th>
                                    <th data-breakpoints="xs sm" class="text-end">{{ localize('Active') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($countries as $key => $country)
                                    <tr>
                                        <td class="text-center">
                                            {{ $key + 1 + ($countries->currentPage() - 1) * $countries->perPage() }}
                                        </td>

                                        <td class="fw-semibold">
                                            {{ $country->name }}
                                        </td>

                                        <td class="fw-semibold">
                                            {{ $country->code }}
                                        </td>

                                        <td class="pe-4">
                                            @can('publish_shipping_countries')
                                                <div class="form-check form-switch d-flex justify-content-end">
                                                    <input type="checkbox" class="form-check-input"
                                                        onchange="updateStatus(this)"
                                                        @if ($country->is_active) checked @endif
                                                        value="{{ $country->id }}">
                                                </div>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!--pagination start-->
                        <div class="d-flex align-items-center justify-content-between px-4 pb-4">
                            <span>{{ localize('Showing') }}
                                {{ $countries->firstItem() }}-{{ $countries->lastItem() }}
                                {{ localize('of') }}
                                {{ $countries->total() }} {{ localize('results') }}</span>
                            <nav>
                                {{ $countries->appends(request()->input())->links() }}
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
            $.post('{{ route('admin.countries.updateStatus') }}', {
                    _token: '{{ csrf_token() }}',
                    id: el.value,
                    is_active: is_active
                },
                function(data) {
                    if (data == 1) {
                        location.reload();
                    } else {
                        notifyMe('danger', '{{ localize('Something went wrong') }}');
                    }
                });
        }
    </script>
@endsection
