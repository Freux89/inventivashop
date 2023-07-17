@extends('backend.layouts.master')

@section('title')
    {{ localize('Currencies') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection


@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-lg-0">{{ localize('Currencies') }}</h2>
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
                                            <th class="all">{{ localize('Name') }}</th>
                                            <th>{{ localize('Symbol') }}</th>
                                            <th data-breakpoints="xs sm">{{ localize('Code') }}</th>
                                            <th data-breakpoints="xs sm">{{ localize('Alignment') }}</th>
                                            <th data-breakpoints="xs sm">{{ localize('1 USD = ?') }}</th>
                                            <th data-breakpoints="xs sm">{{ localize('Active') }}</th>
                                            <th data-breakpoints="xs sm" class="text-end">{{ localize('Action') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($currencies as $key => $currency)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $loop->index + 1 }}
                                                </td>

                                                <td class="fw-semibold">{{ $currency->name }} </td>


                                                <td>
                                                    {{ $currency->symbol }}
                                                </td>

                                                <td class="fw-semibold">{{ $currency->code }} </td>

                                                <td>
                                                    {{ $currency->alignment == 0 ? localize('[symbol][amount]') : localize('[amount][symbol]') }}
                                                </td>
                                                <td class="fw-semibold">
                                                    {{ $currency->rate }}
                                                </td>

                                                <td>
                                                    @can('publish_currency')
                                                        <div class="form-check form-switch">
                                                            <input type="checkbox" class="form-check-input"
                                                                onchange="updateStatus(this)"
                                                                @if ($currency->is_active) checked @endif
                                                                value="{{ $currency->id }}">
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

                                                            @can('edit_currency')
                                                                <a class="dropdown-item"
                                                                    href="{{ route('admin.currencies.edit', $currency->id) }}">
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
                            </div>
                        </div>

                        @can('add_currency')
                            <form action="{{ route('admin.currencies.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!--currency info start-->
                                <div class="card mb-4" id="section-2">
                                    <div class="card-body">
                                        <h5 class="mb-4">{{ localize('Add New Currency') }}</h5>

                                        <div class="mb-4">
                                            <label for="name" class="form-label">{{ localize('Currency Name') }}</label>
                                            <input type="text" name="name" id="name"
                                                placeholder="{{ localize('Type currency name') }}" class="form-control"
                                                required>
                                        </div>

                                        <div class="mb-4">
                                            <label for="symbol" class="form-label">{{ localize('Currency Symbol') }}</label>
                                            <input type="text" name="symbol" id="symbol"
                                                placeholder="{{ localize('Type symbol') }}" class="form-control" required>
                                        </div>

                                        <div class="mb-4">
                                            <label for="code" class="form-label">{{ localize('Currency Code') }}</label>
                                            <input type="text" name="code" id="code"
                                                placeholder="{{ localize('Type code') }}" class="form-control" required>
                                        </div>

                                        <div class="mb-4">
                                            <label for="rate" class="form-label">{{ localize('Rate') }} <small>(
                                                    {{ localize('1 USD = ?') }} )</small></label>
                                            <input type="number" step="0.001" min="0" name="rate"
                                                id="rate" placeholder="{{ localize('Rate') }}" class="form-control"
                                                required>
                                        </div>

                                        <div class="mb-4">
                                            <label for="symbol" class="form-label">{{ localize('Alignment') }}</label>
                                            <select id="alignment" class="form-control text-uppercase select2"
                                                name="alignment" data-toggle="select2">
                                                <option value="0">{{ localize('[symbol][amount]') }}
                                                </option>
                                                <option value="1">{{ localize('[amount][symbol]') }}
                                                </option>
                                                <option value="2">{{ localize('[symbol] [amount]') }}
                                                </option>
                                                <option value="3">{{ localize('[amount] [symbol]') }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!--currency info end-->

                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-4">
                                            <button class="btn btn-primary" type="submit">
                                                <i data-feather="save" class="me-1"></i> {{ localize('Save Currency') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endcan

                        <!--configurations start-->
                        <form action="{{ route('admin.settings.update') }}" method="POST" class="pb-650 mt-3">
                            @csrf
                            <div class="card mb-4" id="section-3">
                                <div class="card-body">
                                    <h5 class="mb-4">{{ localize('Set Default Currency') }}</h5>

                                    @can('default_currency')
                                        <div class="mb-4">
                                            <input type="hidden" name="types[]" value="DEFAULT_CURRENCY">
                                            <label for="symbol"
                                                class="form-label">{{ localize('Default Currency') }}</label>
                                            <select id="DEFAULT_CURRENCY" class="form-control country-flag-select"
                                                name="DEFAULT_CURRENCY" data-toggle="select2">
                                                @foreach ($currencies as $currency)
                                                    <option value="{{ $currency->code }}"
                                                        {{ getSetting('default_currency') == $currency->code ? 'selected' : '' }}>
                                                        {{ $currency->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endcan


                                    <div class="mb-4">
                                        <input type="hidden" name="types[]" value="no_of_decimals">
                                        <label for="no_of_decimals"
                                            class="form-label">{{ localize('No of Decimals') }}</label>
                                        <select id="no_of_decimals" class="form-control country-flag-select"
                                            name="no_of_decimals" data-toggle="select2">
                                            <option value="0"
                                                {{ getSetting('no_of_decimals') == '0' ? 'selected' : '' }}>
                                                {{ localize('Disable') }}</option>
                                            <option value="1"
                                                {{ getSetting('no_of_decimals') == '1' ? 'selected' : '' }}>123.0
                                            </option>
                                            <option value="2"
                                                {{ getSetting('no_of_decimals') == '2' ? 'selected' : '' }}>123.00
                                            </option>
                                            <option value="3"
                                                {{ getSetting('no_of_decimals') == '3' ? 'selected' : '' }}>123.000
                                            </option>
                                        </select>
                                    </div>


                                    <div class="mb-4">
                                        <input type="hidden" name="types[]" value="truncate_price">
                                        <label for="truncate_price"
                                            class="form-label">{{ localize('Price Format') }}</label>
                                        <select id="truncate_price" class="form-control country-flag-select"
                                            name="truncate_price" data-toggle="select2">
                                            <option value="0"
                                                {{ getSetting('truncate_price') == '0' ? 'selected' : '' }}>
                                                {{ localize('Show Full Price (1000000)') }}</option>
                                            <option value="1"
                                                {{ getSetting('truncate_price') == '1' ? 'selected' : '' }}>
                                                {{ localize('Truncate Price (1M/1B)') }}</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-4">
                                        <button class="btn btn-primary" type="submit">
                                            <i data-feather="save" class="me-1"></i>
                                            {{ localize('Save Configurations') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--configurations end-->

                    </div>
                </div>

                <!--right sidebar-->
                <div class="col-xl-3 order-1 order-md-1 order-lg-1 order-xl-2">
                    <div class="card tt-sticky-sidebar">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Currency Information') }}</h5>
                            <div class="tt-vertical-step">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="#section-1" class="active">{{ localize('All Currencies') }}</a>
                                    </li>
                                    <li>
                                        <a href="#section-2">{{ localize('Add New Currency') }}</a>
                                    </li>
                                    <li>
                                        <a href="#section-3">{{ localize('Currency Configurations') }}</a>
                                    </li>
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
            $.post('{{ route('admin.currencies.updateStatus') }}', {
                    _token: '{{ csrf_token() }}',
                    id: el.value,
                    is_active: is_active
                },
                function(data) {
                    if (data == 1) {
                        notifyMe('success', '{{ localize('Status updated successfully') }}');
                    } else if (data == 2) {
                        notifyMe('danger', '{{ localize('Default currency can not be disabled') }}');
                    } else {
                        notifyMe('danger', '{{ localize('Something went wrong') }}');
                    }
                });
        }
    </script>
@endsection
