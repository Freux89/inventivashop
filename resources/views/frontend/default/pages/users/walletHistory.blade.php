@extends('frontend.default.layouts.master')

@section('title')
    {{ localize('Customer Wallet History') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
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
                            <h6 class="">{{ localize('Wallet History') }}</h6>
                            <span class="fw-bold">{{ localize('Wallet Balance') }}: <span
                                    class="text-secondary">{{ formatPrice(auth()->user()->user_balance) }}</span></span>
                        </div>
                        <div class="table-responsive">
                            <table class="order-history-table table align-middle">
                                <tbody>
                                    <tr>
                                        <th>{{ localize('Date') }}</th>
                                        <th>{{ localize('Amount') }}</th>
                                        <th>{{ localize('Payment') }}</th>
                                        <th class="text-end">{{ localize('Status') }}</th>
                                    </tr>

                                    @forelse ($wallets as $wallet)
                                        <tr>
                                            <td>
                                                {{ date('d M, Y', strtotime($wallet->created_at)) }}
                                            </td>

                                            <td class="text-secondary">
                                                {{ formatPrice($wallet->amount) }}
                                            </td>

                                            <td class="text-capitalize">
                                                {{ $wallet->payment_method }}
                                            </td>

                                            <td class="text-capitalize text-end">
                                                <span class="badge bg-secondary">
                                                    {{ $wallet->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="px-1 px-md-3">
                            {{ $wallets->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
