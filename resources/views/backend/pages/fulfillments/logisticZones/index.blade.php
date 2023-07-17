@extends('backend.layouts.master')

@section('title')
    {{ localize('Shipping Zones') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
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
                                        <h2 class="h5 mb-0">{{ localize('Shipping Zones') }}</h2>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    @include('backend.pages.fulfillments.partials.zoneNavbar')
                                </div>
                                @can('add_shipping_zones')
                                    <div class="col-auto">
                                        <a href="{{ route('admin.logisticZones.create') }}" class="btn btn-primary"><i
                                                data-feather="plus"></i>{{ localize('Add Zone') }}</a>
                                    </div>
                                @endcan
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
                                            <select class="form-select select2" name="searchLogistic"
                                                data-minimum-results-for-search="Infinity">
                                                <option value="">{{ localize('Select a Logistic') }}</option>
                                                @foreach (\App\Models\Logistic::where('is_published', 1)->get() as $logistic)
                                                    <option value="{{ $logistic->id }}"
                                                        @if ($searchLogistic == $logistic->id) selected @endif>
                                                        {{ $logistic->name }}</option>
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

                        <table class="table tt-footable border-top align-middle" data-use-parent-width="true">
                            <thead>
                                <tr>
                                    <th class="text-center" width="7%">{{ localize('S/L') }}</th>
                                    <th width="10%">{{ localize('Name') }}</th>
                                    <th width="15%">{{ localize('Logistic') }}</th>
                                    <th data-breakpoints="xs sm">{{ localize('Cities') }}</th>
                                    <th data-breakpoints="xs sm" width="10%">{{ localize('Shipping Time') }}</th>
                                    <th data-breakpoints="xs sm" width="10%">{{ localize('Shipping Charge') }}</th>
                                    <th data-breakpoints="xs sm" class="text-end">{{ localize('Action') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logisticZones as $key => $logisticZone)
                                    <tr>
                                        <td class="text-center">
                                            {{ $key + 1 + ($logisticZones->currentPage() - 1) * $logisticZones->perPage() }}
                                        </td>

                                        <td class="fw-semibold">
                                            {{ $logisticZone->name }}
                                        </td>

                                        <td class="fw-semibold">
                                            {{ $logisticZone->logistic->name }}
                                        </td>

                                        @php
                                            $cities = $logisticZone->cities;
                                        @endphp
                                        <td>
                                            @forelse ($cities as $city)
                                                <span class="badge bg-secondary rounded-pill">{{ $city->name }}</span>
                                            @empty
                                                <span class="badge bg-secondary rounded-pill">{{ localize('n/a') }}</span>
                                            @endforelse
                                        </td>

                                        <td>
                                            @if ($logisticZone->standard_delivery_time)
                                                {{ $logisticZone->standard_delivery_time }}
                                            @else
                                                <span class="badge bg-secondary rounded-pill">{{ localize('n/a') }}</span>
                                            @endif

                                        </td>

                                        <td class="fw-bold">

                                            <span class="text-accent">
                                                {{ formatPrice($logisticZone->standard_delivery_charge) }}
                                            </span>

                                        </td>

                                        <td class="text-end">
                                            <div class="dropdown tt-tb-dropdown">
                                                <button type="button" class="btn p-0" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i data-feather="more-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end shadow">
                                                    @can('edit_shipping_zones')
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.logisticZones.edit', ['id' => $logisticZone->id, 'lang_key' => env('DEFAULT_LANGUAGE')]) }}&localize">
                                                            <i data-feather="edit-3" class="me-2"></i>{{ localize('Edit') }}
                                                        </a>
                                                    @endcan

                                                    @can('delete_shipping_zones')
                                                        <a href="#" class="dropdown-item confirm-delete"
                                                            data-href="{{ route('admin.logisticZones.delete', $logisticZone->id) }}"
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
                                {{ $logisticZones->firstItem() }}-{{ $logisticZones->lastItem() }}
                                {{ localize('of') }}
                                {{ $logisticZones->total() }} {{ localize('results') }}</span>
                            <nav>
                                {{ $logisticZones->appends(request()->input())->links() }}
                            </nav>
                        </div>
                        <!--pagination end-->
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
