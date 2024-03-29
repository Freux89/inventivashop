@extends('backend.layouts.master')

@section('title')
{{ localize('Update Zone') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection


@section('contents')
<section class="tt-section pt-4">
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">{{ localize('Update Shipping Zone') }}</h2>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-4">
            <!--left sidebar-->
            <div class="col-xl-12 order-2 order-md-2 order-lg-2 order-xl-1">
                <form action="{{ route('admin.logisticZones.update') }}" method="POST" class="pb-650">
                    @csrf
                    <input type="hidden" name="id" value="{{ $logisticZone->id }}">
                    <!--basic information start-->
                    <div class="card mb-4" id="section-1">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Basic Information') }}</h5>

                            <div class="mb-4">
                                <label for="name" class="form-label">{{ localize('Zone Name') }}</label>
                                <input class="form-control" type="text" id="name" placeholder="{{ localize('Type your zone name') }}" name="name" required value="{{ $logisticZone->name }}">
                            </div>

                            <div class="mb-4">
                                <label for="logistic_id" class="form-label">{{ localize('Logistic') }}</label>
                                <select class="form-control select2" name="logistic_id" class="w-100" id="logistic_id" data-toggle="select2" disabled>
                                    <option value="{{ $logisticZone->logistic->id }}" selected>
                                        {{ $logisticZone->logistic->name }}
                                    </option>
                                </select>
                            </div>

                            <div class="mb-4">


                                @php
                                $logisticCountries = $logisticZone->countries->pluck('id')->toArray();
                                @endphp

                                <label class="form-label">{{ localize('Paesi') }}</label>
                                <select class="form-control select2" name="country_ids[]" class="w-100" id="country_ids" data-toggle="select2" data-placeholder="{{ localize('Seleziona paesi') }}" multiple required>
                                    @foreach ($countries as $country)
                                    <option value="{{ $country->id }}" {{ in_array($country->id, $logisticCountries) ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="mb-4">
                                <label for="name" class="form-label">{{ localize('Standard Delivery Charge') }}</label>
                                <input type="number" step="0.001" name="standard_delivery_charge" id="standard_delivery_charge" placeholder="{{ localize('Standard delivery charge') }}" class="form-control" min="0" required value="{{ $logisticZone->standard_delivery_charge }}">
                            </div>

                            <!-- Campo per il costo dell'imballo -->
                            <div class="mb-4">
                                <label for="packing_cost" class="form-label">{{ localize('Costo imballo') }}</label>
                                <input type="number" step="0.001" name="packing_cost" id="packing_cost" class="form-control" min="0" value="{{ $logisticZone->packing_cost ?? '' }}">
                            </div>

                            <!-- Campo per il costo della spedizione assicurata -->
                            <div class="mb-4">
                                <label for="insured_shipping_cost" class="form-label">{{ localize('Costo assicurazione') }}</label>
                                <input type="number" step="0.001" name="insured_shipping_cost" id="insured_shipping_cost" class="form-control" min="0" value="{{ $logisticZone->insured_shipping_cost ?? '' }}">
                            </div>

                            <div class="mb-4">
                                <label for="name" class="form-label">{{ localize('Standard Delivery Time') }}</label>
                                <input type="text" name="standard_delivery_time" id="standard_delivery_time" placeholder="{{ localize('1 - 3 days') }}" class="form-control" required value="{{ $logisticZone->standard_delivery_time }}">
                            </div>
                            <div class="mb-4">
                                <label for="average_delivery_days" class="form-label">{{ localize('Giorni Medi di Consegna') }}</label>
                                <input type="number" name="average_delivery_days" id="average_delivery_days" placeholder="{{ localize('e.g., 2') }}" class="form-control" required value="{{ $logisticZone->average_delivery_days ?? '' }}">
                                <span class="fs-sm text-muted">
                                    {{ localize('Specifica il tempo medio di consegna in giorni. Il valore deve essere un numero intero.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <!--basic information end-->

                    <!-- submit button -->
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-4">
                                <button class="btn btn-primary" type="submit">
                                    <i data-feather="save" class="me-1"></i> {{ localize('Save Changes') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- submit button end -->

                </form>
            </div>

            <!--right sidebar-->

        </div>
    </div>
</section>
@endsection