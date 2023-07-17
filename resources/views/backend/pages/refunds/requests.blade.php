@extends('backend.layouts.master')

@section('title')
    {{ localize('Refund Requests') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-lg-0">{{ localize('Refund Requests') }}</h2>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12">
                    <div class="card mb-4" id="section-1">

                        <table class="table tt-footable border-top" data-use-parent-width="true">
                            <thead>
                                <tr>
                                    <th class="text-center">{{ localize('S/L') }}
                                    </th>
                                    <th>{{ localize('User') }}</th>
                                    <th data-breakpoints="xs sm">{{ localize('Order Code') }}</th>
                                    <th data-breakpoints="xs sm">{{ localize('Product') }}</th>
                                    <th data-breakpoints="xs sm">{{ localize('Amount') }}</th>
                                    <th data-breakpoints="xs sm">{{ localize('Payment') }}</th>
                                    <th data-breakpoints="xs sm md lg xl">{{ localize('Reason') }}</th>
                                    <th data-breakpoints="xs sm md" class="text-end">{{ localize('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($refundRequests as $key => $refundRequest)
                                    @php
                                        $product = $refundRequest->orderItem->product_variation->product;
                                    @endphp
                                    <tr>
                                        <td class="text-center">
                                            {{ $key + 1 + ($refundRequests->currentPage() - 1) * $refundRequests->perPage() }}
                                        </td>
                                        <td>
                                            <a class="d-flex align-items-center">
                                                <div class="avatar avatar-sm">
                                                    <img class="rounded-circle"
                                                        src="{{ uploadedAsset($refundRequest->user->avatar) }}"
                                                        alt="" />
                                                </div>
                                                <h6 class="fs-sm mb-0 ms-2">
                                                    {{ $refundRequest->user->name }}
                                                </h6>
                                            </a>
                                        </td>

                                        <td>
                                            {{ getSetting('order_code_prefix') }}{{ $refundRequest->orderGroup->order_code }}
                                        </td>

                                        <td>
                                            <a class="d-flex align-items-center">
                                                <div class="avatar avatar-sm">
                                                    <img class="rounded-circle"
                                                        src="{{ uploadedAsset($product->thumbnail_image) }}"
                                                        alt="{{ $product->collectLocalization('name') }}" />
                                                </div>
                                                <h6 class="fs-sm mb-0 ms-2">
                                                    {{ $product->collectLocalization('name') }}
                                                </h6>
                                            </a>
                                        </td>

                                        <td>
                                            {{ formatPrice($refundRequest->orderItem->total_price) }}
                                        </td>

                                        <td>
                                            @if ($refundRequest->orderGroup->payment_status == paidPaymentStatus())
                                                <span class="badge bg-soft-primary text-capitalize rounded-pill">
                                                    {{ $refundRequest->orderGroup->payment_status }}
                                                </span>
                                            @else
                                                <span class="badge bg-soft-danger text-capitalize rounded-pill">
                                                    {{ $refundRequest->orderGroup->payment_status }}
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            {{ $refundRequest->refund_reason }}
                                        </td>

                                        <td class="text-end">
                                            <div class="dropdown tt-tb-dropdown">
                                                <button type="button" class="btn p-0" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i data-feather="more-vertical"></i>
                                                </button>

                                                <div class="dropdown-menu dropdown-menu-end shadow">
                                                    <a class="dropdown-item confirm-approval" href="#"
                                                        data-href="{{ route('admin.refund.approve', $refundRequest->id) }}">
                                                        <i data-feather="check-circle"
                                                            class="me-2"></i>{{ localize('Approve') }}
                                                    </a>

                                                    <a href="#" class="dropdown-item confirm-rejection"
                                                        data-href="{{ route('admin.refund.reject', $refundRequest->id) }}"
                                                        title="{{ localize('Reject') }}">
                                                        <i data-feather="x-octagon" class="me-2"></i>
                                                        {{ localize('Reject') }}
                                                    </a>
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
                                {{ $refundRequests->firstItem() }}-{{ $refundRequests->lastItem() }} {{ localize('of') }}
                                {{ $refundRequests->total() }} {{ localize('results') }}</span>
                            <nav>
                                {{ $refundRequests->appends(request()->input())->links() }}
                            </nav>
                        </div>
                        <!--pagination end-->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--approval-->
    @include('backend.inc.refundApprovalModal')

    <!--rejecttion-->
    @include('backend.inc.refundRejectionModal')
@endsection
