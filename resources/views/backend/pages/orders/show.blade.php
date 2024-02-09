@extends('backend.layouts.master')

@section('title')
{{ localize('Order Details') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
<section class="tt-section pt-4">
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">{{ localize('Order Details') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!--left sidebar-->
            <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">
                <div class="card mb-4" id="section-1">
                    <div class="card-header border-bottom-0">

                        <!--order status-->
                        <div class="row justify-content-between align-items-center g-3">
                            <div class="col-auto flex-grow-1">
                                <h5 class="mb-0">{{ localize('Ordine') }}
                                    <span class="text-accent">{{ getSetting('order_code_prefix') }}{{ $order->orderGroup->order_code }}
                                    </span>
                                </h5>
                                <span class="text-muted">{{ localize('Data ordine') }}:
                                    {{ date('d M, Y', strtotime($order->created_at)) }}
                                </span>

                                <!-- @if ($order->location_id != null)
                                <div>
                                    <span class="text-muted">
                                        <i class="las la-map-marker"></i> {{ optional($order->location)->name }}
                                    </span>
                                </div>
                                @endif -->

                            </div>

                            <div class="col-auto col-lg-3">
                                <div class="input-group">
                                    <select class="form-select select2" name="payment_status" data-minimum-results-for-search="Infinity" id="update_payment_status">
                                        <option value="" disabled>
                                            {{ localize('Payment Status') }}
                                        </option>
                                        <option value="paid" @if ($order->payment_status == 'paid') selected @endif>
                                            {{ localize('Paid') }}
                                        </option>
                                        <option value="unpaid" @if ($order->payment_status == 'unpaid') selected @endif>
                                            {{ localize('Unpaid') }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-auto col-lg-3">
                                <div class="input-group">
                                    <select class="form-select select2" name="delivery_status" data-minimum-results-for-search="Infinity" id="update_delivery_status">
                                        <option value="" disabled>{{ localize('Delivery Status') }}</option>
                                        @foreach($order->activeOrderStates as $state)
                                        <option value="{{ $state->id }}" @if ($order->order_state_id == $state->id) selected @endif>
                                            {{ localize($state->name) }}
                                        </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            @if($order->orderGroup->billingAddress)
                            <div class="col-auto">
                                <a href="#" class="btn btn-primary">
                                    <i data-feather="download" width="18"></i>
                                    {{ localize('Genera fattura') }}
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!--customer info-->
                    <div class="card-body">
                        <div class="row justify-content-between g-3">
                            <div class="col-xl-7 col-lg-6">
                                <div class="welcome-message">
                                    <h6 class="mb-2">{{ localize('Informazioni cliente') }}</h6>
                                    <p class="mb-0">{{ localize('Name') }}: {{ optional($order->user)->name }}</p>
                                    <p class="mb-0">{{ localize('Email') }}: {{ optional($order->user)->email }}</p>
                                    <p class="mb-0">{{ localize('Phone') }}: {{ optional($order->user)->phone }}</p>

                                    <!-- @php
                                    $deliveryInfo = json_decode($order->scheduled_delivery_info);
                                    @endphp

                                    <p class="mb-0">{{ localize('Delivery Type') }}:
                                        <span class="badge bg-primary">{{ Str::title(Str::replace('_', ' ', $order->shipping_delivery_type)) }}</span>


                                    </p> -->
                                    @if ($order->shipping_delivery_type == getScheduledDeliveryType())
                                    <p class="mb-0">
                                        {{ localize('Delivery Time') }}:
                                        {{ date('d F', $deliveryInfo->scheduled_date) }},
                                        {{ $deliveryInfo->timeline }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-5 col-lg-6">
                                <div class="shipping-address d-flex justify-content-md-end">
                                    <div class="border-end pe-2">
                                        <h6 class="mb-2">{{ localize('Shipping Address') }}</h6>
                                        @php
                                        $shippingAddress = $order->orderGroup->shippingAddress;

                                        @endphp
                                        <p class="mb-0">
                                            @if ($order->orderGroup->is_pos_order)
                                            {{ $order->orderGroup->pos_order_address }}
                                            @else
                                            {{ optional($shippingAddress)->address }},
                                            {{ optional($shippingAddress)->city  }},
                                            {{ optional(optional($shippingAddress)->state)->name }},
                                            {{ optional(optional($shippingAddress)->country)->name }}
                                            @endif
                                        </p>
                                    </div>
                                    @if (!$order->orderGroup->is_pos_order)
                                    @if($order->orderGroup->billingAddress)
                                    <div class="ms-4">
                                        <h6 class="mb-2">{{ localize('Billing Address') }}</h6>
                                        @php
                                        $billingAddress = $order->orderGroup->billingAddress;
                                        @endphp
                                        <p class="mb-0">

                                            {{ optional($billingAddress)->address }},
                                            {{ optional($billingAddress)->city }},
                                            {{ optional(optional($billingAddress)->state)->name }},
                                            {{ optional(optional($billingAddress)->country)->name }}
                                        </p>
                                    </div>
                                    @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--order details-->
                    <table class="table tt-footable border-top" data-use-parent-width="true">
                        <thead>
                            <tr>
                                <th class="text-center" width="7%">{{ localize('S/L') }}</th>
                                <th>{{ localize('Products') }}</th>
                                <th data-breakpoints="xs sm">{{ localize('Unit Price') }}</th>
                                <th data-breakpoints="xs sm">{{ localize('QTY') }}</th>
                                <th data-breakpoints="xs sm" class="text-end">{{ localize('Total Price') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($order->orderItems as $key => $item)
                            @php
                            $product = $item->product_variations->first()->product;
                            $informations = json_decode($item->informations, true); // Decodifica JSON in array
                            @endphp
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm"> <img src="{{ uploadedAsset($product->thumbnail_image) }}" alt="{{ $product->collectLocalization('name') }}" class="rounded-circle">
                                        </div>
                                        <div class="ms-2">
                                            <h6 class="fs-sm mb-0">
                                                {{$informations['product_name'] }}
                                            </h6>
                                            <div class="text-muted">


                                                <div class="text-muted order_informations">
                                                    @if (!empty($informations) && !empty($informations['variations']))
                                                    <ul>
                                                        @foreach ($informations['variations'] as $variation)
                                                        <li>{{ $variation['name'] }}: {{ $variation['value'] }}</li>
                                                        @endforeach
                                                    </ul>
                                                    @endif
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="tt-tb-price">
                                    <span class="fw-bold">{{ formatPrice($item->unit_price - ($item->total_tax / $item->qty)) }}
                                    </span>
                                </td>
                                <td class="fw-bold">{{ $item->qty }}</td>

                                <td class="tt-tb-price text-end">
                                    @if ($item->refundRequest && $item->refundRequest->refund_status == 'refunded')
                                    <span class="badge bg-soft-info rounded-pill text-capitalize">{{ $item->refundRequest->refund_status }}</span>
                                    @endif
                                    <span class="text-accent fw-bold">{{ formatPrice($item->total_price - $item->total_tax) }}
                                    </span>

                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!--grand total-->
                    <div class="card-body">
                        <div class="card-footer border-top-0 px-4 py-3 rounded">
                            <div class="row g-4">
                               
                                <div class="col-auto flex-grow-1">
                                    <h6 class="mb-1">{{ localize('Shipping Cost') }}</h6>
                                    <strong>{{ formatPrice($order->orderGroup->total_shipping_cost) }}</strong>
                                    @if($order->orderGroup->total_insured_shipping_cost > 0)
                                    <span>
                                        + {{ formatPrice($order->orderGroup->total_insured_shipping_cost) }} ({{ localize('Spedizione assicurata') }})
                                    </span>
                                    @endif
                                </div>
                                <div class="col-auto flex-grow-1">
                                    <h6 class="mb-1">{{ localize('Sub Total') }}</h6>
                                    <strong>{{ formatPrice($order->orderGroup->sub_total_amount) }}</strong>
                                </div>
                                




                                @if ($order->orderGroup->total_coupon_discount_amount > 0)
                                <div class="col-auto flex-grow-1">
                                    <h6 class="mb-1">{{ localize('Coupon Discount') }}</h6>
                                    <strong>{{ formatPrice($order->orderGroup->total_coupon_discount_amount) }}</strong>
                                </div>
                                @endif
                                <div class="col-auto flex-grow-1">
                                    <h6 class="mb-1">{{ localize('Tasse') }}</h6>
                                    <strong>{{ formatPrice($order->orderGroup->total_tax_amount) }}</strong>
                                </div>
                               
                                <div class="col-auto text-lg-end flex-grow-1">
                                    <h6 class="mb-1">{{ localize('Grand Total') }}</h6>
                                    <strong class="text-accent">{{ formatPrice($order->orderGroup->grand_total_amount) }}</strong>
                                </div>
                              
                            </div>
                            <div class="row mt-4">
                            <div class="col-auto flex-grow-1">
                                    <h6 class="mb-1">{{ localize('Payment Method') }}</h6>
                                    <span>{{ ucwords(str_replace('_', ' ', $order->orderGroup->payment_method)) }}</span>
                                </div>

                                <div class="col-auto flex-grow-1">
                                    <h6 class="mb-1">{{ localize('Logistic') }}</h6>
                                    <span>{{ $order->logistic_name }}</span>

                                </div>
                                <div class="col-auto flex-grow-1">
                                    <h6 class="mb-1">{{ localize('Pacco') }}</h6>
                                    <span>{{$order->orderGroup->packaging_type}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--right sidebar-->
            <div class="col-xl-3 order-1 order-md-1 order-lg-1 order-xl-2">
                <div class="tt-sticky-sidebar">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Order Logs') }}</h5>
                            <div class="tt-vertical-step">
                                <ul class="list-unstyled">

                                    @forelse ($order->orderUpdates as $orderUpdate)
                                    <li>
                                        <a class="{{ $loop->first ? 'active' : '' }}">
                                            {{ localize($orderUpdate->note) }} <br> da
                                            <span class="text-capitalize">{{ optional($orderUpdate->user)->name }}</span>
                                            il
                                            {{ date('d M, Y', strtotime($orderUpdate->created_at)) }}.</a>
                                    </li>
                                    @empty
                                    <li>
                                        <a class="active">{{ localize('No logs found') }}</a>
                                    </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script type="text/javascript">
    "use strict";

    // payment status
    $('#update_payment_status').on('change', function() {
        var order_id = {{$order->id}};
        var status = $('#update_payment_status').val();
        $.post('{{ route("admin.orders.update_payment_status") }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id,
                status: status
            },
            function(data) {
                notifyMe('success', '{{ localize("Payment status has been updated") }}');
                window.location.reload();
            });
    });

    // delivery status 
    $('#update_delivery_status').on('change', function() {
        var order_id = {{$order->id}};
        var status = $('#update_delivery_status').val();
        $.post('{{ route("admin.orders.update_delivery_status") }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id,
                status: status
            },
            function(data) {
                notifyMe('success', '{{ localize("Delivery status has been updated") }}');
                window.location.reload();
            });
    });
</script>
@endsection