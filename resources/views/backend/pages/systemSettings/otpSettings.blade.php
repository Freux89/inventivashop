@extends('backend.layouts.master')

@section('title')
    {{ localize('OTP Settings') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-lg-0">{{ localize('OTP Settings') }}</h2>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!--left sidebar-->
                <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1 pb-650">
                    <form action="{{ route('admin.envKey.update') }}" method="POST" enctype="multipart/form-data"
                        class="mb-4">
                        @csrf
                        <!--Twilio settings-->
                        <div class="card mb-4" id="section-1">
                            <div class="card-body">
                                <h5 class="mb-4">{{ localize('Twilio Credentials') }}</h5>
                                <div class="mb-3">
                                    <label for="TWILIO_SID" class="form-label">{{ localize('Twilio SID') }}</label>
                                    <input type="hidden" name="types[]" value="TWILIO_SID">
                                    <input type="text" id="TWILIO_SID" name="TWILIO_SID" class="form-control"
                                        value="{{ env('TWILIO_SID') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="TWILIO_AUTH_TOKEN"
                                        class="form-label">{{ localize('Twilio Auth Token') }}</label>
                                    <input type="hidden" name="types[]" value="TWILIO_AUTH_TOKEN">
                                    <input type="text" id="TWILIO_AUTH_TOKEN" name="TWILIO_AUTH_TOKEN"
                                        class="form-control" value="{{ env('TWILIO_AUTH_TOKEN') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="VALID_TWILIO_NUMBER"
                                        class="form-label">{{ localize('Valid Twilo Number') }}</label>
                                    <input type="hidden" name="types[]" value="VALID_TWILIO_NUMBER">
                                    <input type="text" id="VALID_TWILIO_NUMBER" name="VALID_TWILIO_NUMBER"
                                        class="form-control" value="{{ env('VALID_TWILIO_NUMBER') }}">
                                </div>
                            </div>
                        </div>
                        <!--Twilio settings-->

                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit">
                                <i data-feather="save" class="me-1"></i> {{ localize('Save Configuration') }}
                            </button>
                        </div>
                    </form>

                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!--Active-->
                        <div class="card mb-4" id="section-active-gateway">
                            <div class="card-body">
                                <h5 class="mb-4">{{ localize('Active SMS Gateway') }}</h5>

                                <div class="mb-3">
                                    <input type="hidden" name="types[]" value="active_sms_gateway">
                                    <select id="enable_twilio" class="form-control text-uppercase select2"
                                        name="active_sms_gateway" data-toggle="select2">
                                        <option value="" disabled selected>{{ localize('Select SMS gateway') }}
                                        </option>
                                        <option value="twilio"
                                            {{ getSetting('active_sms_gateway') == 'twilio' ? 'selected' : '' }}>
                                            {{ localize('Twilio') }}</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <!--Active-->

                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit">
                                <i data-feather="save" class="me-1"></i> {{ localize('Save Configuration') }}
                            </button>
                        </div>

                    </form>
                </div>

                <!--right sidebar-->
                <div class="col-xl-3 order-1 order-md-1 order-lg-1 order-xl-2">
                    <div class="card tt-sticky-sidebar">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('OTP Settings') }}</h5>
                            <div class="tt-vertical-step">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="#section-1" class="active">{{ localize('Twilio') }}</a>
                                    </li>

                                    <li>
                                        <a href="#section-active-gateway"
                                            class="">{{ localize('Active SMS Gateway') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
