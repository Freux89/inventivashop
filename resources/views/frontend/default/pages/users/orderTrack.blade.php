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

                <div class="order-tracking-wrap bg-white rounded py-5 px-4">

                    <h6 class="mb-4">{{ localize('Order Tracking') }}</h6>
                    <form class="search-form d-flex align-items-center mb-5 justify-content-center" action="{{ route('customers.trackOrder') }}">
                        <div class="input-group mb-3 d-flex justify-content-center">
                            @if (getSetting('order_code_prefix') != null)
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-0 rounded-start">{{ getSetting('order_code_prefix') }}</span>
                            </div>
                            @endif
                            <input type="text" class="w-50" placeholder="{{ localize('code') }}" name="code" @isset($searchCode) value="{{ $searchCode }}" @endisset>

                            <button type="submit" class="btn btn-secondary px-3"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </form>


                    @isset($order)


                    <ol id="progress-bar">
                        @php
                        $activeStates = $order->activeAndVisibleOrderStates; // Stati visibili
                        $allStates = $order->ActiveOrderStates; // Tutti gli stati, visibili e non
                        $currentStateId = $order->order_state_id;

                        // Controlla se lo stato corrente è visibile
                        $currentStateVisible = $activeStates->pluck('id')->contains($currentStateId);

                        if (!$currentStateVisible) {
                        // Trova l'ultimo stato visibile precedente allo stato corrente
                        $lastVisibleState = null;
                        foreach ($allStates as $state) {
                        if ($state->id == $currentStateId) {
                        break;
                        }
                        if ($activeStates->pluck('id')->contains($state->id)) {
                        $lastVisibleState = $state;
                        }
                        }

                        // Imposta l'indice sullo stato visibile trovato
                        $currentStateIndex = $lastVisibleState ? $activeStates->pluck('id')->search($lastVisibleState->id) : null;
                        } else {
                        // Se lo stato corrente è visibile, usa il suo indice
                        $currentStateIndex = $activeStates->pluck('id')->search($currentStateId);
                        }

                        $stateCount = $activeStates->count();
                        $width = $stateCount > 5 ? 20 : 100 / max($stateCount, 1);
                        @endphp

                        @foreach ($activeStates as $index => $state)
                        <li class="fs-xs tt-step
        @if ($index == $currentStateIndex) active
        @elseif ($index < $currentStateIndex) tt-step-done
        @endif
        @if ($index % 5 == 0) no-after
        @endif" style="width: {{ $width }}%;">
                            {{ localize($state->name) }}
                        </li>
                        @endforeach

                    </ol>


                    <div class="table-responsive-md mt-5">
                        <table class="table table-bordered fs-xs">
                            <thead>
                                <tr>
                                    <th scope="col">{{ localize('Date') }}</th>
                                    <th scope="col">{{ localize('Status Info') }}</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($order->orderUpdates as $orderUpdate)
                                <tr>
                                    <td>{{ date('d M, Y', strtotime($orderUpdate->created_at)) }}</td>
                                    <td>{{ localize($orderUpdate->note) }}</span>
                                    </td>
                                </tr>
                                @endforeach

                                <tr>
                                    <td> {{ date('d M, Y', strtotime($order->created_at)) }} </td>
                                    <td>{{ localize('Order has been placed') }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    @endisset
                </div>
            </div>
        </div>
    </div>
</section>
@endsection