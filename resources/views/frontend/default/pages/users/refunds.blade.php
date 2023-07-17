@extends('frontend.default.layouts.master')

@section('title')
    {{ localize('Refund History') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    <section class="my-account pt-6 pb-120">
        <div class="container">

            @include('frontend.default.pages.users.partials.customerHero')

            <div class="row g-4">
                <div class="col-xl-3">
                    @include('frontend.default.pages.users.partials.customerSidebar')
                </div>

                <div class="col-xl-9">
                    <div class="recent-orders bg-white rounded py-5">
                        <h6 class="mb-4 px-4">{{ localize('Your Orders') }}</h6>
                        <div class="table-responsive">
                            <table class="order-history-table table">
                                <tbody>
                                    <tr>
                                        <th>{{ localize('Order Code') }}</th>
                                        <th>{{ localize('Date') }}</th>
                                        <th>{{ localize('Product') }}</th>
                                        <th>{{ localize('Amount') }}</th>
                                        <th class="text-center">{{ localize('Status') }}</th>
                                    </tr>

                                    @forelse ($refunds as $refund)
                                        <tr>
                                            <td>{{ getSetting('order_code_prefix') }}{{ $refund->orderGroup->order_code }}
                                            </td>
                                            <td>{{ date('d M, Y', strtotime($refund->created_at)) }}</td>
                                            <td>{{ $refund->orderItem->product_variation->product->collectLocalization('name') }}
                                            </td>

                                            <td class="text-secondary">
                                                {{ formatPrice($refund->orderItem->total_price) }}</td>

                                            <td class="text-center">
                                                @if ($refund->refund_status == 'rejected')
                                                    <span class="btn badge bg-danger text-capitalize cursor-pointer"
                                                        onclick="showRejectionReason('{{ $refund->refund_reject_reason }}')">
                                                        {{ $refund->refund_status }}
                                                    </span>
                                                @else
                                                    <span
                                                        class="badge bg-{{ $refund->refund_status == 'pending' ? 'info' : 'secondary' }}">
                                                        {{ ucwords(str_replace('_', ' ', $refund->refund_status)) }}
                                                    </span>
                                                @endif

                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="px-1 px-md-3">
                            {{ $refunds->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--rejection modal-->
    @include('frontend.default.pages.checkout.inc.rejectionModal')
@endsection
