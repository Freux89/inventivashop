@extends('backend.layouts.master')

@section('title')
{{ localize('Orders') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
<section class="tt-section pt-4">
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">{{ localize('Orders') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12">
                <div class="card mb-4" id="section-1">
                    <form class="app-search" action="{{ Request::fullUrl() }}" method="GET">
                        <div class="card-header border-bottom-0">
                            <div class="row justify-content-between g-3">
                                <div class="col-auto flex-grow-1 d-none">
                                    <div class="tt-search-box">
                                        <div class="input-group">
                                            <span class="position-absolute top-50 start-0 translate-middle-y ms-2"> <i data-feather="search"></i></span>
                                            <input class="form-control rounded-start w-100" type="text" id="search" name="search" placeholder="{{ localize('Search by name/phone') }}" @isset($searchKey) value="{{ $searchKey }}" @endisset>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto flex-grow-1">
                                    <div class="input-group mb-3">
                                        @if (getSetting('order_code_prefix') != null)
                                        <div class="input-group-prepend">
                                            <span class="input-group-text rounded-end-0">{{ getSetting('order_code_prefix') }}</span>
                                        </div>
                                        @endif
                                        <input type="text" class="form-control" placeholder="{{ localize('code') }}" name="code" @isset($searchCode) value="{{ $searchCode }}" @endisset>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <select class="form-select select2" name="payment_status" data-minimum-results-for-search="Infinity" id="payment_status">
                                        <option value="">{{ localize('Payment Status') }}</option>
                                        <option value="{{ paidPaymentStatus() }}" @if (isset($paymentStatus) && $paymentStatus==paidPaymentStatus()) selected @endif>
                                            {{ localize('Paid') }}
                                        </option>
                                        <option value="{{ unpaidPaymentStatus() }}" @if (isset($paymentStatus) && $paymentStatus==unpaidPaymentStatus()) selected @endif>
                                            {{ localize('Unpaid') }}
                                        </option>
                                    </select>
                                </div>

                                <div class="col-auto">
                                    <select class="form-select select2" name="order_state_id" data-minimum-results-for-search="Infinity" id="update_order_state_id">
                                        <option value="">{{ localize('Stato ordine') }}</option>
                                        @foreach($orderStates as $state)
                                        <option value="{{ $state->id }}" @if ($stateId==$state->id) selected @endif>
                                            {{ localize($state->name) }}
                                        </option>
                                        @endforeach



                                    </select>
                                </div>

                                <!-- @if (count($locations) > 0)
                                        <div class="col-auto">
                                            <select class="form-select select2" name="location_id"
                                                data-minimum-results-for-search="Infinity" id="location_id">
                                                <option value="">{{ localize('Location') }}</option>
                                                @foreach ($locations as $location)
                                                    <option value="{{ $location->id }}"
                                                        @if (isset($locationId) && $locationId == $location->id) selected @endif>
                                                        {{ $location->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif -->

                                <!-- <div class="col-auto">
                                    <select class="form-select select2" name="is_pos_order" data-minimum-results-for-search="Infinity" id="is_pos_order">
                                        <option value="0" @if (isset($posOrder) && $posOrder==0) selected @endif>
                                            {{ localize('Online Orders') }}
                                        </option>
                                        <option value="1" @if (isset($posOrder) && $posOrder==1) selected @endif>
                                            {{ localize('POS Orders') }}
                                        </option>
                                    </select>
                                </div> -->
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">
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
                                <th class="text-center">{{ localize('S/L') }}
                                </th>
                                <th>{{ localize('Order Code') }}</th>
                                <th data-breakpoints="xs sm md">{{ localize('Customer') }}</th>


                                <th data-breakpoints="xs sm">{{ localize('Payment') }}</th>
                                <th data-breakpoints="xs sm">{{ localize('Status') }}</th>
                                <th data-breakpoints="xs">{{ localize('Totale') }}</th>
                                <th>{{ localize('Data') }}</th>
                                <th>{{ localize('Consegna stimata') }}</th>
                                <!-- <th data-breakpoints="xs sm">{{ localize('Type') }}</th> -->
                                <!-- @if (count($locations) > 0)
                                        <th data-breakpoints="xs sm">{{ localize('Location') }}</th>
                                    @endif -->
                                <th data-breakpoints="xs sm" class="text-end">{{ localize('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $key => $order)
                            <tr>
                                <td class="text-center">
                                    {{ $key + 1 + ($orders->currentPage() - 1) * $orders->perPage() }}
                                </td>

                                <td class="fs-sm">
                                    {{ getSetting('order_code_prefix') }}{{ $order->orderGroup->order_code }}
                                </td>

                                <td>
                                    <div class="d-flex align-items-center">

                                        <div class="ms-2">
                                            <h6 class="fs-sm mb-0">{{ optional($order->user)->name }}</h6>
                                            <span class="text-muted fs-sm">
                                                {{ optional($order->user)->email ?? '-' }}</span>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    @if ($order->payment_status == unpaidPaymentStatus())
                                    <span class="badge bg-soft-danger rounded-pill text-capitalize">
                                        {{ localize($order->payment_status) }}
                                    </span>
                                    @else
                                    <span class="badge bg-soft-primary rounded-pill text-capitalize">
                                        {{ localize($order->payment_status) }}
                                    </span>
                                    @endif
                                </td>


                                <td>
                                    @if ($order->orderState) <!-- Controlla se esiste uno stato d'ordine associato -->
                                    <span class="badge rounded-pill text-capitalize" style="background-color: {{ $order->orderState->color }};color: {{ isLight($order->orderState->color) ? '#000000' : '#FFFFFF' }};">
                                        {{ localize($order->orderState->name) }}
                                    </span>
                                    @else
                                    <span class="badge bg-soft-info rounded-pill text-capitalize">
                                        {{ localize('Stato Non Definito') }}
                                    </span>
                                    @endif
                                </td>

                                <!-- <td>
                                            <span
                                                class="badge rounded-pill text-capitalize {{ $order->shipping_delivery_type == getScheduledDeliveryType() ? 'bg-soft-warning' : 'bg-secondary' }}">
                                                {{ Str::title(Str::replace('_', ' ', $order->shipping_delivery_type)) }}
                                            </span>
                                        </td> -->

                                <!-- @if (count($locations) > 0)
                                            <td>
                                                <span class="badge rounded-pill text-capitalize bg-secondary">
                                                    @if ($order->location)
                                                        {{ $order->location->name }}
                                                    @else
                                                        {{ localize('N/A') }}
                                                    @endif
                                                </span>
                                            </td>
                                        @endif -->
                                        <td>
                                        {{ formatPrice($order->orderGroup->grand_total_amount) }}
                                    </td>
                                <td>
                                    <span class="fs-sm">{{ date('d M, Y', strtotime($order->created_at)) }}</span>
                                </td>
                                <td>
                                    <span class="fs-sm">{{ calculateEstimatedDeliveryDate($order->created_at,$order->indicative_delivery_days ) }}</span>
                                </td>
                                <td class="text-end">
                                    @can('manage_orders')
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm p-0 tt-view-details" data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizza dettagli">
                                        <i data-feather="eye"></i>
                                    </a>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!--pagination start-->
                    <div class="d-flex align-items-center justify-content-between px-4 pb-4">
                        <span>{{ localize('Showing') }}
                            {{ $orders->firstItem() }}-{{ $orders->lastItem() }} {{ localize('of') }}
                            {{ $orders->total() }} {{ localize('results') }}</span>
                        <nav>
                            {{ $orders->appends(request()->input())->links() }}
                        </nav>
                    </div>
                    <!--pagination end-->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection