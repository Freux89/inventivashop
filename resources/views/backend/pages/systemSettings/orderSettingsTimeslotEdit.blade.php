@extends('backend.layouts.master')

@section('title')
    {{ localize('Update Time Slot') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection


@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-lg-0">{{ localize('Update Time Slot') }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4 g-4">

                <!--left sidebar-->
                <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">
                    <form action="{{ route('admin.timeslot.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $slot->id }}">
                        <!--timeslot information start-->
                        <div class="card mb-4" id="section-1">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="timeline" class="form-label">{{ localize('Time Slot') }}</label>
                                    <input type="text" id="timeline" name="timeline" class="form-control"
                                        placeholder="{{ localize('8am - 9am') }}" value="{{ $slot->timeline }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="sorting_order" class="form-label">{{ localize('Sorting Order') }}</label>
                                    <input type="number" min="0" value="{{ $slot->sorting_order }}"
                                        id="sorting_order" name="sorting_order" class="form-control">
                                    <small>{{ localize('Timeslots with lower sorting order will be shown first') }}</small>
                                </div>
                            </div>
                        </div>
                        <!--timeslot information end-->

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
                <div class="col-xl-3 order-1 order-md-1 order-lg-1 order-xl-2">
                    <div class="card tt-sticky-sidebar d-none d-xl-block">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Time Slot Information') }}</h5>
                            <div class="tt-vertical-step">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="#section-1" class="active">{{ localize('Basic Information') }}</a>
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
