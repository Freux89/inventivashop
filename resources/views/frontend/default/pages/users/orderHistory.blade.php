@extends('frontend.default.layouts.master')

@section('title')
    {{ localize('Customer Order History') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
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
                                        <th>{{ localize('Placed on') }}</th>
                                        <th>{{ localize('Items') }}</th>
                                        <th>{{ localize('Total') }}</th>
                                        <th>{{ localize('Status') }}</th>
                                        <th class="text-center">{{ localize('Action') }}</th>
                                    </tr>

                                    @forelse ($orders as $order)
                                        <tr>
                                            <td>{{ getSetting('order_code_prefix') }}{{ $order->orderGroup->order_code }}
                                            </td>
                                            <td>{{ date('d M, Y', strtotime($order->created_at)) }}</td>
                                            <td>{{ $order->orderItems()->count() }}</td>
                                            <td class="text-secondary">
                                                {{ formatPrice($order->orderGroup->grand_total_amount) }}</td>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    {{ ucwords(str_replace('_', ' ', $order->delivery_status)) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('customers.trackOrder') }}?code={{ $order->orderGroup->order_code }}"
                                                    class="view-invoice fs-xs me-2" target="_blank" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    data-bs-title="{{ localize('Track My Order') }}"><i
                                                        class="fas fa-truck text-dark"></i></a>

                                                <a href="{{ route('checkout.invoice', $order->orderGroup->order_code) }}"
                                                    class="view-invoice fs-xs" target="_blank" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    data-bs-title="{{ localize('View Details') }}"><i
                                                        class="fas fa-eye"></i></a>


                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="px-1 px-md-3">
                            {{ $orders->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
