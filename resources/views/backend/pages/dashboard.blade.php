@extends('backend.layouts.master')

@section('title')
    {{ localize('Dashboard') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    @can('dashboard')
        <section class="tt-section pt-4">
            <div class="container">
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card tt-page-header">
                            <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                                <div class="tt-page-title">
                                    <h2 class="h5 mb-lg-0">{{ localize('Admin Dashboard') }}</h2>
                                </div>
                                <div class="tt-action">

                                    @can('manage_orders')
                                        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary"><i
                                                data-feather="shopping-cart" class="me-2"></i>{{ localize('Manage Sales') }}</a>
                                    @endcan

                                    @can('add_products')
                                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary ms-2"><i
                                                data-feather="plus" class="me-2"></i>
                                            {{ localize('Add Product') }}</a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-xl-9">
                        <div class="row g-3">
                            <!-- total sales chart -->
                            <div class="col-sm-6 col-md-4 col-lg-4">
                                <div class="card h-100 flex-column">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span class="text-muted">{{ localize('Total Earning') }}</span>
                                            <div class="dropdown tt-tb-dropdown fs-sm">
                                                <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    @if (isset($timelineText))
                                                        {{ $timelineText }}
                                                    @else
                                                        {{ localize('Last 7 days') }}
                                                    @endif
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end shadow">
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.dashboard') }}">{{ localize('Last 7 days') }}</a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.dashboard') }}?&timeline=30">{{ localize('Last 30 days') }}</a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.dashboard') }}?&timeline=90">{{ localize('Last 3 months') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="fw-bold">{{ formatPrice($totalSalesData->totalEarning) }}</h4>
                                    </div>
                                    <div id="totalSales"></div>
                                </div>
                            </div>
                            <!-- total sales chart -->


                            <!-- top 5 category sales chart -->
                            <div class="col-sm-6 col-md-4 col-lg-4">
                                <div class="card h-100 flex-column">
                                    <div class="card-body d-flex flex-column h-100">
                                        <span class="text-muted">{{ localize('Top 5 Category Sales') }}</span>
                                        <h4 class="fw-bold">{{ $totalCatSalesData->totalCategorySalesCount }}</h4>
                                        <div id="topFive"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- top 5 category sales chart -->

                            <!-- total order this month chart -->
                            <div class="col-sm-6 col-md-4 col-lg-4 d-none d-lg-block d-md-block">
                                <div class="card h-100 flex-column">
                                    <div class="card-body">
                                        <span class="text-muted">{{ localize('Last 30 Days Orders') }}</span>
                                        <h4 class="fw-bold">{{ $totalOrdersData->totalOrders }}</h4>
                                    </div>
                                    <div id="last30DaysOrders"></div>
                                </div>
                            </div>
                            <!-- total order this month chart -->

                            <!-- sales this month chart -->
                            <div class="col-l2">
                                <div class="card">
                                    <div class="card-body pb-0">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span class="text-muted">{{ localize('Sales This Months') }}</span>
                                        </div>
                                        <h4 class="fw-bold mb-0">{{ formatPrice($thisMonthSaleData->totalEarning) }}</h4>
                                    </div>
                                    <div id="thisMonthChart" class="px-3"></div>
                                </div>
                            </div>
                            <!-- sales this month chart -->

                        </div>
                    </div>

                    <div class="col-xl-3">
                        <!-- top selling products -->
                        <div class="card h-100 flex-column">
                            <div class="card-body px-0">
                                <div class="px-3">
                                    <h5 class="fw-bold mb-1">{{ localize('Top Selling Products') }}</h5>
                                    <span class="text-muted">
                                        {{ localize('We have listed ' . \App\Models\Product::count() . ' total products.') }}</span>
                                </div>
                                <div class="tt-top-selling mt-3 h-25rem" data-simplebar>
                                    <ul class="tt-top-selling-list list-unstyled mb-0 px-3">
                                        @php
                                            $top_selling_products = \App\Models\Product::where('total_sale_count', '>', 0)
                                                ->orderBy('total_sale_count', 'DESC')
                                                ->take(15)
                                                ->get();
                                        @endphp
                                        @foreach ($top_selling_products as $product)
                                            <li class="py-3 d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-md flex-shrink-0">
                                                        <img class="rounded-circle"
                                                            src="{{ uploadedAsset($product->thumbnail_image) }}"
                                                            alt="" />
                                                    </div>
                                                    <div class="ms-2">
                                                        <h6 class="fs-md mb-0 tt-line-clamp tt-clamp-1">
                                                            {{ $product->collectLocalization('name') }}
                                                        </h6>
                                                        <span class="text-muted fs-sm">{{ localize('Brand') }}:
                                                            {{ optional($product->brand)->name }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <span class="fw-bold heading-font text-end  cursor-pointer"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ localize('Total Sales') }}">({{ $product->total_sale_count }})</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- top selling products -->
                    </div>
                </div>

                @can('manage_orders')
                    <div class="row g-3 mb-3">
                        <a href="{{ route('admin.orders.index') }}" class="col-lg-3 col-sm-6">
                            <div class="card h-100 flex-column">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-lg">
                                            <div class="text-center bg-soft-primary rounded-circle">
                                                <span class="text-primary"> <i data-feather="shopping-bag"></i></span>
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <h4 class="mb-1">{{ \App\Models\Order::count() }}</h4>
                                            <span class="text-muted">{{ localize('Total Orders') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('admin.orders.index') }}?delivery_status={{ orderPendingStatus() }}"
                            class="col-lg-3 col-sm-6">
                            <div class="card h-100 flex-column">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-lg">
                                            <div class="text-center bg-soft-warning rounded-circle">
                                                <span class="text-warning"> <i data-feather="clock"></i></span>
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <h4 class="mb-1">{{ \App\Models\Order::isPlacedOrPending()->count() }}</h4>
                                            <span class="text-muted">{{ localize('Order Pending') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('admin.orders.index') }}?delivery_status={{ orderProcessingStatus() }}"
                            class="col-lg-3 col-sm-6">
                            <div class="card h-100 flex-column">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-lg">
                                            <div class="text-center bg-soft-info rounded-circle">
                                                <span class="text-info"> <i data-feather="refresh-cw"></i></span>
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <h4 class="mb-1">{{ \App\Models\Order::isProcessing()->count() }}</h4>
                                            <span class="text-muted">{{ localize('Order Processing') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('admin.orders.index') }}?delivery_status={{ orderDeliveredStatus() }}"
                            class="col-lg-3 col-sm-6">
                            <div class="card h-100 flex-column">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-lg">
                                            <div class="text-center bg-soft-success rounded-circle">
                                                <span class="text-success"> <i data-feather="check-circle"></i></span>
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <h4 class="mb-1">{{ \App\Models\Order::isDelivered()->count() }}</h4>
                                            <span class="text-muted">{{ localize('Total Delivered') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endcan

                @can('orders')
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header border-bottom-0">
                                    <div class="row justify-content-between g-3">
                                        <div class="col-auto flex-grow-1">
                                            <h5 class="mb-1">{{ localize('Recent Orders') }}</h5>
                                            <span class="text-muted">{{ localize('Your 10 Most Recent Orders') }}</span>
                                        </div>

                                        <div class="col-auto">
                                            @can('manage_orders')
                                                <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">
                                                    <i data-feather="eye" width="18"></i>
                                                    {{ localize('View All') }}
                                                </a>
                                            @endcan
                                        </div>
                                    </div>
                                </div>

                                @php
                                    $orders = App\Models\Order::latest()
                                        ->take(10)
                                        ->get();
                                @endphp
                                <table class="table tt-footable border-top align-middle" data-use-parent-width="true">
                                    <thead>
                                        <tr>
                                            <th class="ps-4">{{ localize('Order Code') }}</th>
                                            <th data-breakpoints="xs sm md">{{ localize('Customer') }}</th>
                                            <th>{{ localize('Placed On') }}</th>
                                            <th data-breakpoints="xs">{{ localize('Items') }}</th>
                                            <th data-breakpoints="xs">{{ localize('Payment Status') }}</th>
                                            <th data-breakpoints="xs">{{ localize('Delivery Status') }}</th>
                                            <th data-breakpoints="xs">{{ localize('Delivery Type') }}</th>
                                            <th data-breakpoints="xs" class="text-end">{{ localize('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($orders as $key => $order)
                                            <tr>

                                                <td class="fs-sm ps-4">
                                                    {{ getSetting('order_code_prefix') }}{{ $order->orderGroup->order_code }}
                                                </td>

                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-md">
                                                            <img class="rounded-circle"
                                                                src="{{ uploadedAsset(optional($order->user)->avatar) }}"
                                                                alt="avatar"
                                                                onerror="this.onerror=null;this.src='{{ staticAsset('backend/assets/img/placeholder-thumb.png') }}';" />
                                                        </div>
                                                        <div class="ms-2">
                                                            <h6 class="fs-sm mb-0">{{ optional($order->user)->name }}</h6>
                                                            <span class="text-muted fs-sm">
                                                                {{ optional($order->user)->phone ?? '-' }}</span>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>
                                                    <span
                                                        class="fs-sm">{{ date('d M, Y', strtotime($order->created_at)) }}</span>
                                                </td>



                                                <td class="tt-tb-price">
                                                    <span class="fw-bold">
                                                        {{ $order->orderItems()->count() }}
                                                    </span>
                                                </td>

                                                <td>
                                                    @if ($order->payment_status == unpaidPaymentStatus())
                                                        <span class="badge bg-soft-danger rounded-pill text-capitalize">
                                                            {{ $order->payment_status }}
                                                        </span>
                                                    @else
                                                        <span class="badge bg-soft-primary rounded-pill text-capitalize">
                                                            {{ $order->payment_status }}
                                                        </span>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($order->delivery_status == orderDeliveredStatus())
                                                        <span class="badge bg-soft-primary rounded-pill text-capitalize">
                                                            {{ $order->delivery_status }}
                                                        </span>
                                                    @elseif($order->delivery_status == orderCancelledStatus())
                                                        <span class="badge bg-soft-danger rounded-pill text-capitalize">
                                                            {{ localize(Str::title(Str::replace('_', ' ', $order->delivery_status))) }}
                                                        </span>
                                                    @else
                                                        <span class="badge bg-soft-info rounded-pill text-capitalize">
                                                            {{ localize(Str::title(Str::replace('_', ' ', $order->delivery_status))) }}
                                                        </span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <span
                                                        class="badge rounded-pill text-capitalize {{ $order->shipping_delivery_type == getScheduledDeliveryType() ? 'bg-soft-warning' : 'bg-secondary' }}">
                                                        {{ Str::title(Str::replace('_', ' ', $order->shipping_delivery_type)) }}
                                                    </span>
                                                </td>

                                                <td class="text-end">
                                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                                        class="btn btn-sm p-0 tt-view-details" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="View Details">
                                                        <i data-feather="eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endcan

                <!-- counter in dashboard -->
                <div class="row g-3 mb-3">
                    @can('manage_orders')
                        <a href="{{ route('admin.orders.index') }}?delivery_status={{ orderPickedUpStatus() }}"
                            class="col-lg-3 col-sm-6">
                            <div class="card h-100 flex-column">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-lg">
                                            <div class="text-center bg-soft-info rounded-circle">
                                                <span class="text-info"> <i data-feather="arrow-down"></i></span>
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <h4 class="mb-1">{{ \App\Models\Order::isPickedUp()->count() }}</h4>
                                            <span class="text-muted">{{ localize('Picked Up Orders') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('admin.orders.index') }}?delivery_status={{ orderCancelledStatus() }}"
                            class="col-lg-3 col-sm-6">
                            <div class="card h-100 flex-column">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-lg">
                                            <div class="text-center bg-soft-accent rounded-circle">
                                                <span class="text-accent"> <i data-feather="x"></i></span>
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <h4 class="mb-1">{{ \App\Models\Order::isCancelled()->count() }}</h4>
                                            <span class="text-muted">{{ localize('Cancelled Orders') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('admin.orders.index') }}?delivery_status={{ orderOutForDeliveryStatus() }}"
                            class="col-lg-3 col-sm-6">
                            <div class="card h-100 flex-column">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-lg">
                                            <div class="text-center bg-soft-warning rounded-circle">
                                                <span class="text-warning"> <i data-feather="truck"></i></span>
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <h4 class="mb-1">{{ \App\Models\Order::isOutForDelivery()->count() }}</h4>
                                            <span class="text-muted">{{ localize('Out For Delivery') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('admin.orders.index') }}?payment_status={{ paidPaymentStatus() }}"
                            class="col-lg-3 col-sm-6">
                            <div class="card h-100 flex-column">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-lg">
                                            <div class="text-center bg-soft-success rounded-circle">
                                                <span class="text-success"> <i data-feather="dollar-sign"></i></span>
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <h4 class="mb-1">{{ \App\Models\Order::isPaid()->count() }}</h4>
                                            <span class="text-muted">{{ localize('Paid Orders') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('admin.orders.index') }}?payment_status={{ unpaidPaymentStatus() }}"
                            class="col-lg-3 col-sm-6">
                            <div class="card h-100 flex-column">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-lg">
                                            <div class="text-center bg-soft-info rounded-circle">
                                                <span class="text-info"> <i data-feather="credit-card"></i></span>
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <h4 class="mb-1">{{ \App\Models\Order::isUnpaid()->count() }}</h4>
                                            <span class="text-muted">{{ localize('Unpaid Orders') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endcan

                    <div class="col-lg-3 col-sm-6">
                        <div class="card h-100 flex-column">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-lg">
                                        <div class="text-center bg-soft-accent rounded-circle">
                                            <span class="text-accent"> <i data-feather="calendar"></i></span>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <h4 class="mb-1">{{ formatPrice($todayEarning) }}</h4>
                                        <span class="text-muted">{{ localize("Today's Earning") }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="card h-100 flex-column">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-lg">
                                        <div class="text-center bg-soft-warning rounded-circle">
                                            <span class="text-warning"> <i data-feather="pause"></i></span>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <h4 class="mb-1">{{ formatPrice($todayPendingEarning) }}</h4>
                                        <span class="text-muted">{{ localize("Today's Pending Earning") }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="card h-100 flex-column">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-lg">
                                        <div class="text-center bg-soft-success rounded-circle">
                                            <span class="text-success"> <i data-feather="bar-chart-2"></i></span>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <h4 class="mb-1">{{ formatPrice($thisYearEarning) }}</h4>
                                        <span class="text-muted">{{ localize('This Year Earning') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-3 col-sm-6">
                        <div class="card h-100 flex-column">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-lg">
                                        <div class="text-center bg-soft-info rounded-circle">
                                            <span class="text-info"> <i data-feather="dollar-sign"></i></span>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <h4 class="mb-1">{{ formatPrice($totalEarning) }}</h4>
                                        <span class="text-muted">{{ localize('Total Earning') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="card h-100 flex-column">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-lg">
                                        <div class="text-center bg-soft-accent rounded-circle">
                                            <span class="text-accent"> <i data-feather="shopping-cart"></i></span>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <h4 class="mb-1">{{ \App\Models\Product::sum('total_sale_count') }}</h4>
                                        <span class="text-muted">{{ localize('Total Product Sale') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="card h-100 flex-column">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-lg">
                                        <div class="text-center bg-soft-warning rounded-circle">
                                            <span class="text-warning"> <i data-feather="calendar"></i></span>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <h4 class="mb-1">{{ $todaySaleCount }}</h4>
                                        <span class="text-muted">{{ localize("Today's Product Sale") }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="card h-100 flex-column">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-lg">
                                        <div class="text-center bg-soft-success rounded-circle">
                                            <span class="text-success"> <i data-feather="check-circle"></i></span>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <h4 class="mb-1">{{ $monthSaleCount }}</h4>
                                        <span class="text-muted">{{ localize("This Month's Product Sale") }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card h-100 flex-column">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-lg">
                                        <div class="text-center bg-soft-info rounded-circle">
                                            <span class="text-info"> <i data-feather="activity"></i></span>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <h4 class="mb-1">{{ $yearSaleCount }}</h4>
                                        <span class="text-muted">{{ localize("This Year's Product Sale") }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('admin.customers.index') }}" class="col-lg-3 col-sm-6">
                        <div class="card h-100 flex-column">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-lg">
                                        <div class="text-center bg-soft-accent rounded-circle">
                                            <span class="text-accent"> <i data-feather="users"></i></span>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <h4 class="mb-1">{{ \App\Models\User::where('user_type', 'customer')->count() }}
                                        </h4>
                                        <span class="text-muted">{{ localize('Total Customers') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('admin.subscribers.index') }}" class="col-lg-3 col-sm-6">
                        <div class="card h-100 flex-column">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-lg">
                                        <div class="text-center bg-soft-warning rounded-circle">
                                            <span class="text-warning"> <i data-feather="at-sign"></i></span>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <h4 class="mb-1">{{ \App\Models\SubscribedUser::count() }}</h4>
                                        <span class="text-muted">{{ localize('Total Subscribers') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('admin.categories.index') }}" class="col-lg-3 col-sm-6">
                        <div class="card h-100 flex-column">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-lg">
                                        <div class="text-center bg-soft-success rounded-circle">
                                            <span class="text-success"> <i data-feather="sliders"></i></span>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <h4 class="mb-1">{{ \App\Models\Category::count() }}</h4>
                                        <span class="text-muted">{{ localize('Total Categories') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('admin.brands.index') }}" class="col-lg-3 col-sm-6 d-none">
                        <div class="card h-100 flex-column">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-lg">
                                        <div class="text-center bg-soft-success rounded-circle">
                                            <span class="text-success"> <i data-feather="check-circle"></i></span>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <h4 class="mb-1">{{ \App\Models\Brand::count() }}</h4>
                                        <span class="text-muted">{{ localize('Total Brands') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- counter in dashboard -->

            </div>
        </section>
    @endcan
@endsection

@section('scripts')
    <script>
        "use strict";
        // total earning chart
        var totalSales = {
            chart: {
                type: "area",
                height: 80,
                sparkline: {
                    enabled: true,
                },
            },
            stroke: {
                curve: "smooth",
                width: 2,
            },
            fill: {
                opacity: 1,
            },
            series: [{
                name: '{{ localize('Earning') }}',
                data: [{!! $totalSalesData->amount !!}],
            }, ],
            labels: [{!! $totalSalesData->labels !!}],
            xaxis: {
                type: "datetime",
            },
            yaxis: {
                min: 0,
            },
            colors: ["#FF7C08"],
        };
        new ApexCharts(document.querySelector("#totalSales"), totalSales).render();

        //pie chart top five
        var optionsTopFive = {
            chart: {
                type: "donut",
                height: 100,
                offsetY: 15,
                offsetX: -20,
            },
            series: {!! $totalCatSalesData->series !!},
            labels: [{!! $totalCatSalesData->labels !!}],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200,
                    },
                    legend: {
                        position: "bottom",
                        show: false,
                    },
                    dataLabels: {
                        enabled: false,
                    },
                },
            }, ],
        };

        var chartTopFive = new ApexCharts(
            document.querySelector("#topFive"),
            optionsTopFive
        );
        chartTopFive.render();

        // last 30 days order chart 
        var optionsBar = {
            chart: {
                type: "bar",
                height: 80,
                width: "100%",
                stacked: true,
                offsetX: -3,
                sparkline: {
                    enabled: true,
                },
                zoom: {
                    enabled: false,
                },
                toolbar: {
                    show: false,
                },
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: false,
                    },
                    columnWidth: "60%",
                    endingShape: "rounded",
                },
            },
            colors: ["#1E90FF"],
            series: [{
                name: "Orders",
                data: [{!! $totalOrdersData->amount !!}],
            }, ],
            labels: [{!! $totalOrdersData->labels !!}],
            xaxis: {
                type: "datetime",
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false,
                },
                crosshairs: {
                    show: false,
                },
                labels: {
                    show: false,
                    style: {
                        fontSize: "14px",
                    },
                },
            },
            grid: {
                xaxis: {
                    lines: {
                        show: false,
                    },
                },
                yaxis: {
                    lines: {
                        show: false,
                    },
                },
            },
            yaxis: {
                axisBorder: {
                    show: false,
                },
                labels: {
                    show: false,
                },
            },
            legend: {
                floating: false,
                position: "bottom",
                horizontalAlign: "right",
            },
            tooltip: {
                shared: true,
                intersect: false,
            },
        };
        var chartBar = new ApexCharts(document.querySelector("#last30DaysOrders"), optionsBar);
        chartBar.render();

        // this month sales 
        var options = {
            chart: {
                height: 210,
                width: "100%",
                type: "area",
                offsetX: -10,
                zoom: {
                    enabled: false,
                },
                toolbar: {
                    show: false,
                },
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: "smooth",
                width: 2,
            },

            colors: ["#4EB529"],
            series: [{
                name: "Sales",
                data: [{!! $thisMonthSaleData->amount !!}],
            }],
            zoom: {
                enabled: false,
            },
            legend: {
                show: false,
                enabled: false,
            },
            labels: [{!! $thisMonthSaleData->labels !!}],
            xaxis: {
                labels: {
                    show: false,
                },
                axisTicks: {
                    show: false,
                },

            }
        };
        var chart = new ApexCharts(document.querySelector("#thisMonthChart"), options);
        chart.render();
    </script>
@endsection
