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
                <div class="col-lg-12">
                    <div class="invoice-title d-flex align-items-center">
                        <h3>{{ localize('Congratulazioni') }}</h3>
                        <span class="badge rounded-pill fw-medium ms-3" style="background-color: {{ $order->orderState->color }};color: {{ isLight($order->orderState->color) ? '#000000' : '#FFFFFF' }};">
                            {{ localize(ucwords(str_replace('_', ' ', $order->orderState->name))) }}
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
            </div>
            <span class="my-6 w-100 d-block border-top"></span>
            <div class="row justify-content-between g-5">
                <div class="col-xl-7 col-lg-6">
                    <div class="welcome-message">
                        <h4 class="mb-2">{{ auth()->user()->name }}</h4>
                        <p class="mb-0">
                            {{ localize('Here are your order details. We thank you for your purchase.') }}
                        </p>

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
                    @if (!$order->orderGroup->is_pos_order)
                    <div class="shipping-address d-flex justify-content-md-end">
                        <div class="border-end pe-2">
                            <h6 class="mb-2">{{ localize('Shipping Address') }}</h6>
                            @php
                            $shippingAddress = $orderGroup->shippingAddress;
                            @endphp
                            <p class="mb-0">{{ optional($shippingAddress)->address }},
                                {{ optional($shippingAddress)->city }},
                                {{ optional(optional($shippingAddress)->state)->name }},
                                {{ optional(optional($shippingAddress)->country)->name }}
                            </p>
                        </div>
                        @if($orderGroup->billingAddress)
                        <div class="ms-4">
                            <h6 class="mb-2">{{ localize('Billing Address') }}</h6>
                            @php
                            $billingAddress = $orderGroup->billingAddress;
                            @endphp
                            <p class="mb-0">{{ optional($billingAddress)->address }},
                                {{ optional($billingAddress)->city }},
                                {{ optional(optional($billingAddress)->state)->name }},
                                {{ optional(optional($billingAddress)->country)->name }}
                            </p>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            <div class="table-responsive mt-6">
                <table class="table invoice-table">
                    <tr>

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
                    $product = $item->product;
                    $informations = json_decode($item->informations, true); // Decodifica JSON in array

                    @endphp
                    <tr>

                        <td class="text-nowrap">
                            <div class="d-flex">
                                <img src="{{ uploadedAsset($product->thumbnail_image) }}" alt="{{ $product->collectLocalization('name') }}" class="img-fluid product-item d-none">
                                {{-- <div class="ms-2"> --}}
                                <div class="">
                                    <span>{{$informations['product_name'] }}</span>
                                    <div class="text-muted order_informations" >
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
                        </td>
                        <td>{{ formatPrice($item->unit_price - ($item->total_tax / $item->qty)) }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>{{ formatPrice($item->total_price - $item->total_tax) }}</td>

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
                            <span class="btn badge bg-danger text-capitalize cursor-pointer" onclick="showRejectionReason('{{ $item->refundRequest->refund_reject_reason }}')">
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
                            <a href="javascript:void(0);" onclick="requestRefund({{ $item->id }})" class="fw-semibold badge bg-secondary"><i class="fas fa-rotate-left me-1"></i>
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

                      

                        <!-- <td>
                            <strong class="text-dark d-block text-nowrap">{{ localize('Tips') }}</strong>
                            <span>{{ formatPrice($orderGroup->total_tips_amount) }}</span>
                        </td> -->

                        <td>
                            <strong class="text-dark d-block text-nowrap">{{ localize('Shipping Cost') }}</strong>
                            <span>{{ formatPrice($orderGroup->total_shipping_cost) }}</span> 
                            @if($orderGroup->total_insured_shipping_cost > 0)
                                <span>
                                    + {{ formatPrice($orderGroup->total_insured_shipping_cost) }} ({{ localize('Spedizione assicurata') }})
                                </span>
                            @endif
                            
                            <!--Se c'è l'assicurazione visualizzare spese assicurazione spedizione-->
                                
                            
                        </td>
                        <td>
                            <strong class="text-dark d-block text-nowrap">{{ localize('Sub Total') }}</strong>
                            <span>{{ formatPrice($orderGroup->sub_total_amount) }}</span>
                        </td>
                        @if ($orderGroup->total_coupon_discount_amount > 0)
                        <td>
                            <strong class="text-dark d-block text-nowrap">{{ localize('Coupon Discount') }}</strong>
                            <span>{{ formatPrice($orderGroup->total_coupon_discount_amount) }}</span>
                        </td>
                        @endif
                        <td>
                            <strong class="text-dark d-block text-nowrap">{{ localize('Tasse') }}</strong>
                            <span>{{ formatPrice($orderGroup->total_tax_amount) }}</span>
                        </td>
                        <td>
                            <strong class="text-dark d-block text-nowrap">{{ localize('Total Price') }}</strong>
                            <span class="text-primary fw-bold">{{ formatPrice($orderGroup->grand_total_amount) }}</span>
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
                            <button type="submit" class="btn btn-secondary btn-md me-3">{{ localize('Submit') }}</button>
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