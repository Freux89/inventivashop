@extends('backend.layouts.master')

@section('title')
    {{ localize('Refund Configurations') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection


@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-lg-0">{{ localize('Refund Configurations') }}</h2>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4 g-4">

                <!--left sidebar-->
                <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">
                    <form action="{{ route('admin.settings.update') }}" method="POST" class="pb-650">
                        @csrf
                        <!--basic information start-->
                        <div class="card mb-4" id="section-1">
                            <div class="card-body">
                                <h5 class="mb-3">{{ localize('Basic Information') }}</h5>


                                <div class="mb-3">
                                    <label for="refund_within_days"
                                        class="form-label">{{ localize('Allow Refund Within Days') }}</label>
                                    <input type="hidden" name="types[]" value="refund_within_days">
                                    <input class="form-control" type="number" min="0" id="refund_within_days"
                                        placeholder="{{ localize('Type refund days') }}" name="refund_within_days"
                                        value="{{ getSetting('refund_within_days') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="enable_refund_system"
                                        class="form-label">{{ localize('Enable Refund System') }}</label>
                                    <input type="hidden" name="types[]" value="enable_refund_system">
                                    <select class="select2 form-control" name="enable_refund_system">
                                        <option value="1" @if (getSetting('enable_refund_system') == 1) selected @endif>
                                            {{ localize('Enable') }}</option>
                                        <option value="0" @if (getSetting('enable_refund_system') == 0) selected @endif>
                                            {{ localize('Disable') }}</option>
                                    </select>
                                </div>


                            </div>
                        </div>
                        <!--basic information end-->

                        <!-- submit button -->
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <button class="btn btn-primary" type="submit">
                                        <i data-feather="save" class="me-1"></i> {{ localize('Save Configurations') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- submit button end -->
                    </form>
                </div>

                <!--right sidebar-->
                <div class="col-xl-3 order-1 order-md-1 order-lg-1 order-xl-2">
                    <div class="card tt-sticky-sidebar d-none d-xl-block">
                        <div class="card-body">
                            <h5 class="mb-3">{{ localize('Refund Information') }}</h5>
                            <div class="tt-vertical-step">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="#section-1" class="active">{{ localize('Refund Information') }}</a>
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
