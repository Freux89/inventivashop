@extends('frontend.default.layouts.master')

@section('title')
    {{ localize('Customer Reward Points') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
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

                        <div class="d-flex justify-content-between px-4 mb-4">
                            <h6 class="">{{ localize('Reward Points') }}</h6>
                            <span class="fw-bold">{{ localize('1 Usd') }} = <span
                                    class="text-secondary">{{ getSetting('reward_points_per_usd') }}
                                    {{ localize('Point(s)') }}</span></span>
                        </div>
                        <div class="table-responsive">
                            <table class="order-history-table table">
                                <tbody>
                                    <tr>
                                        <th>{{ localize('Order Code') }}</th>
                                        <th>{{ localize('Points') }}</th>
                                        <th>{{ localize('Status') }}</th>
                                        <th>{{ localize('Date') }}</th>
                                        <th class="text-center">{{ localize('Action') }}</th>
                                    </tr>

                                    @forelse ($rewards as $reward)
                                        <tr>
                                            <td>{{ getSetting('order_code_prefix') }}{{ $reward->orderGroup->order_code }}
                                            </td>
                                            <td class="text-secondary">
                                                {{ $reward->total_points }}
                                            </td>
                                            <td>
                                                @if ($reward->is_converted == 1)
                                                    <span class="badge bg-secondary">
                                                        {{ localize('Converted') }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-info">
                                                        {{ localize('Pending') }}
                                                    </span>
                                                @endif

                                            </td>

                                            <td>
                                                {{ date('d M, Y', strtotime($reward->created_at)) }}
                                            </td>

                                            <td class="text-center">
                                                @if ($reward->is_converted == 1)
                                                    <span class="badge bg-success">
                                                        {{ localize('Converted') }}
                                                    </span>
                                                @else
                                                    @php
                                                        $waitingDays = (int) getSetting('waiting_days_for_wallet_conversion');
                                                        
                                                        $checkDate = \Carbon\Carbon::parse($reward->created_at)->addDays($waitingDays);
                                                        $today = today();
                                                        
                                                        $count = $checkDate->diffInDays($today);
                                                    @endphp

                                                    @if ($count > 0)
                                                        {{ $count }} {{ localize('day(s) left') }}
                                                    @else
                                                        <a href="{{ route('customers.convertRewardPoints', encrypt($reward->id)) }}"
                                                            class="view-invoice fs-xs" data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            data-bs-title="{{ localize('Convert To Wallet') }}">
                                                            <i class="fa-solid fa-money-bill-transfer"></i></a>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="px-1 px-md-3">
                            {{ $rewards->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
