@extends('frontend.default.layouts.master')

@section('title')
    {{ localize('Invoice') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    <!--invoice section start-->
    @if (!is_null($orderGroup))
        @php
            $order = $orderGroup->order;
            $orderItems = $order->orderItems;
        @endphp
        <section class="invoice-section pt-6 pb-120">
            <div class="container">
                <div class="invoice-box bg-white rounded p-4 p-sm-6">
                    <div class="row g-5 justify-content-between">
                        <div class="col-lg-6">
                            <div class="invoice-title d-flex align-items-center">
                                <h3>{{ localize('Invoice') }}</h3>
                                <span class="badge rounded-pill bg-primary-light text-primary fw-medium ms-3">
                                    {{ ucwords(str_replace('_', ' ', $order->delivery_status)) }}
                                </span>
                            </div>
                            <table class="invoice-table-sm">
                                <tr>
                                    <td><strong>{{ localize('Order Code') }}</strong></td>
                                    <td>{{ getSetting('order_code_prefix') }}{{ $orderGroup->order_code }}</td>
                                </tr>

                                <tr>
                                    <td><strong>{{ localize('Date') }}</strong></td>
                                    <td>{{ date('d M, Y', strtotime($orderGroup->created_at)) }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-lg-5 col-md-8">
                            <div class="text-lg-end">
                                <a href="{{ route('home') }}"><img src="{{ uploadedAsset(getSetting('navbar_logo')) }}"
                                        alt="logo" class="img-fluid"></a>
                                <h6 class="mb-0 text-gray mt-4">{{ getSetting('site_address') }}</h6>
                            </div>
                        </div>
                    </div>
                    <span class="my-6 w-100 d-block border-top"></span>
                    <div class="row justify-content-between g-5">
                        <div class="col-xl-7 col-lg-6">
                            <div class="welcome-message">
                                <h4 class="mb-2">{{ auth()->user()->name }}</h4>
                                <p class="mb-0">
                                    {{ localize('Here are your order details. We thank you for your purchase.') }}</p>

                                @php
                                    $deliveryInfo = json_decode($order->scheduled_delivery_info);
                                @endphp

                                <p class="mb-0">{{ localize('Delivery Type') }}:
                                    <span
                                        class="badge bg-primary">{{ Str::title(Str::replace('_', ' ', $order->shipping_delivery_type)) }}</span>


                                </p>
                                @if ($order->shipping_delivery_type == getScheduledDeliveryType())
                                    <p class="mb-0">
                                        {{ localize('Delivery Time') }}:
                                        {{ date('d F', $deliveryInfo->scheduled_date) }},
                                        {{ $deliveryInfo->timeline }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-6">
                            @if (!$order->orderGroup->is_pos_order)
                                <div class="shipping-address d-flex justify-content-md-end">
                                    <div class="border-end pe-2">
                                        <h6 class="mb-2">{{ localize('Shipping Address') }}</h6>
                                        @php
                                            $shippingAddress = $orderGroup->shippingAddress;
                                        @endphp
                                        <p class="mb-0">{{ optional($shippingAddress)->address }},
                                            {{ optional(optional($shippingAddress)->city)->name }},
                                            {{ optional(optional($shippingAddress)->state)->name }},
                                            {{ optional(optional($shippingAddress)->country)->name }}</p>
                                    </div>
                                    <div class="ms-4">
                                        <h6 class="mb-2">{{ localize('Billing Address') }}</h6>
                                        @php
                                            $billingAddress = $orderGroup->billingAddress;
                                        @endphp
                                        <p class="mb-0">{{ optional($billingAddress)->address }},
                                            {{ optional(optional($billingAddress)->city)->name }},
                                            {{ optional(optional($billingAddress)->state)->name }},
                                            {{ optional(optional($billingAddress)->country)->name }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="table-responsive mt-6">
                        <table class="table invoice-table">
                            <tr>
                                <th>{{ localize('S/L') }}</th>
                                <th>{{ localize('Products') }}</th>
                                <th>{{ localize('U.Price') }}</th>
                                <th>{{ localize('QTY') }}</th>
                                <th>{{ localize('T.Price') }}</th>
                                @if (getSetting('enable_refund_system') == 1)
                                    <th>{{ localize('Refund') }}</th>
                                @endif
                            </tr>
                            @foreach ($orderItems as $key => $item)
                                @php
                                    $product = $item->product_variation->product;
                                @endphp
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td class="text-nowrap">
                                        <div class="d-flex">
                                            <img src="{{ uploadedAsset($product->thumbnail_image) }}"
                                                alt="{{ $product->collectLocalization('name') }}"
                                                class="img-fluid product-item d-none">
                                            {{-- <div class="ms-2"> --}}
                                            <div class="">
                                                <span>{{ $product->collectLocalization('name') }}</span>
                                                <div>
                                                    @foreach (generateVariationOptions($item->product_variation->combinations) as $variation)
                                                        <span class="fs-xs">
                                                            {{ $variation['name'] }}:
                                                            @foreach ($variation['values'] as $value)
                                                                {{ $value['name'] }}
                                                            @endforeach
                                                            @if (!$loop->last)
                                                                ,
                                                            @endif
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ formatPrice($item->unit_price) }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>{{ formatPrice($item->total_price) }}</td>

                                    @if (getSetting('enable_refund_system') == 1)
                                        <td>
                                            @if ($item->refundRequest)
                                                @if ($item->refundRequest->refund_status == 'pending')
                                                    <span class="badge bg-info text-capitalize">
                                                        {{ $item->refundRequest->refund_status }}
                                                    </span>
                                                @elseif($item->refundRequest->refund_status == 'refunded')
                                                    <span class="badge bg-primary text-capitalize">
                                                        {{ $item->refundRequest->refund_status }}
                                                    </span>
                                                @else
                                                    <span class="btn badge bg-danger text-capitalize cursor-pointer"
                                                        onclick="showRejectionReason('{{ $item->refundRequest->refund_reject_reason }}')">
                                                        {{ $item->refundRequest->refund_status }}
                                                    </span>
                                                @endif
                                            @else
                                                @php
                                                    $withinDays = (int) getSetting('refund_within_days');
                                                    
                                                    $checkDate = \Carbon\Carbon::parse($item->created_at)->addDays($withinDays);
                                                    $today = today();
                                                    
                                                    $count = $checkDate->diffInDays($today);
                                                @endphp
                                                @if ($count > 0)
                                                    <a href="javascript:void(0);"
                                                        onclick="requestRefund({{ $item->id }})"
                                                        class="fw-semibold badge bg-secondary"><i
                                                            class="fas fa-rotate-left me-1"></i>
                                                        {{ localize('Request Refund') }}</a>
                                                @else
                                                    {{ localize('Time Over') }}
                                                @endif
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach


                        </table>
                    </div>
                    <div class="mt-4 table-responsive">
                        <table class="table footer-table">
                            <tr>
                                <td>
                                    <strong class="text-dark d-block text-nowrap">{{ localize('Payment Method') }}</strong>
                                    <span> {{ ucwords(str_replace('_', ' ', $orderGroup->payment_method)) }}</span>
                                </td>

                                <td>
                                    <strong class="text-dark d-block text-nowrap">{{ localize('Sub Total') }}</strong>
                                    <span>{{ formatPrice($orderGroup->sub_total_amount) }}</span>
                                </td>

                                <td>
                                    <strong class="text-dark d-block text-nowrap">{{ localize('Tips') }}</strong>
                                    <span>{{ formatPrice($orderGroup->total_tips_amount) }}</span>
                                </td>

                                <td>
                                    <strong class="text-dark d-block text-nowrap">{{ localize('Shipping Cost') }}</strong>
                                    <span>{{ formatPrice($orderGroup->total_shipping_cost) }}</span>
                                </td>
                                @if ($orderGroup->total_coupon_discount_amount > 0)
                                    <td>
                                        <strong
                                            class="text-dark d-block text-nowrap">{{ localize('Coupon Discount') }}</strong>
                                        <span>{{ formatPrice($orderGroup->total_coupon_discount_amount) }}</span>
                                    </td>
                                @endif

                                <td>
                                    <strong class="text-dark d-block text-nowrap">{{ localize('Total Price') }}</strong>
                                    <span
                                        class="text-primary fw-bold">{{ formatPrice($orderGroup->grand_total_amount) }}</span>
                                </td>

                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!--invoice section end-->

    <!--refund modal-->
    <div class="modal fade refundModal" id="refundModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="gstore-product-quick-view bg-white rounded-3 pt-3 pb-6 px-4">
                        <h2 class="modal-title fs-5 mb-3">{{ localize('Request Refund') }}</h2>
                        <form action="{{ route('customers.requestRefund') }}" method="post">
                            @csrf
                            <input type="hidden" name="order_item_id" value="" class="order_item_id">
                            <div class="row g-4">
                                <div class="col-sm-12">
                                    <div class="label-input-field">
                                        <label>{{ localize('Refund Reason') }}</label>
                                        <textarea rows="4" placeholder="{{ localize('Type refund reason') }}" name="refund_reason" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6 d-flex">
                                <button type="submit"
                                    class="btn btn-secondary btn-md me-3">{{ localize('Submit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--rejection modal-->
    @include('frontend.default.pages.checkout.inc.rejectionModal')
@endsection


@section('scripts')
    <script>
        "use strict";

        // request refund
        function requestRefund(order_item_id) {
            $('#refundModal').modal('show');
            $('.order_item_id').val(order_item_id);
        }
    </script>
@endsection
