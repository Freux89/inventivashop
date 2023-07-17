@extends('backend.layouts.master')

@section('title')
    {{ localize('Website Homepage Configuration') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-lg-0">{{ localize('Weekly Best Deals') }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4 g-4">
                <!--left sidebar-->
                <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">
                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!--slider info start-->
                        <div class="card mb-4">
                            <div class="card-body">

                                <div class="mb-3">
                                    <label class="form-label">{{ localize('Date Range') }}</label>
                                    @php
                                        $best_deal_end_date = getSetting('best_deal_end_date');
                                        if (!is_null($best_deal_end_date)) {
                                            $best_deal_end_date = date('m/d/Y', strtotime($best_deal_end_date));
                                        }
                                    @endphp
                                    <div class="input-group">
                                        <input type="hidden" name="types[]" value="best_deal_end_date">
                                        <input class="form-control date-picker" type="text"
                                            placeholder="{{ localize('End date') }}" name="best_deal_end_date"
                                            @if ($best_deal_end_date != null) data-date="'{{ $best_deal_end_date }}'" @endif>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    @php
                                        $weekly_best_deals = getSetting('weekly_best_deals') != null ? json_decode(getSetting('weekly_best_deals')) : [];
                                    @endphp
                                    <label class="form-label">{{ localize('Best Deal Products') }}</label>
                                    <input type="hidden" name="types[]" value="weekly_best_deals">
                                    <select class="select2 form-control" multiple="multiple"
                                        data-placeholder="{{ localize('Select products') }}" name="weekly_best_deals[]"
                                        required>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                @if (in_array($product->id, $weekly_best_deals)) selected @endif>
                                                {{ $product->collectLocalization('name') }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="mb-3">
                                    <label class="form-label">{{ localize('Banner Image') }}</label>
                                    <input type="hidden" name="types[]" value="best_deal_banner">
                                    <div class="tt-image-drop rounded">
                                        <span class="fw-semibold">{{ localize('Choose Banner Image') }}</span>
                                        <!-- choose media -->
                                        <div class="tt-product-thumb show-selected-files mt-3">
                                            <div class="avatar avatar-xl cursor-pointer choose-media"
                                                data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
                                                onclick="showMediaManager(this)" data-selection="single">
                                                <input type="hidden" name="best_deal_banner"
                                                    value="{{ getSetting('best_deal_banner') }}">
                                                <div class="no-avatar rounded-circle">
                                                    <span><i data-feather="plus"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- choose media -->
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="best_deal_banner_link"
                                        class="form-label">{{ localize('Banner Link') }}</label>
                                    <input type="hidden" name="types[]" value="best_deal_banner_link">
                                    <input type="url" name="best_deal_banner_link" id="best_deal_banner_link"
                                        placeholder="{{ env('APP_URL') . '/example' }}" class="form-control"
                                        value="{{ getSetting('best_deal_banner_link') }}">
                                </div>
                            </div>
                        </div>
                        <!--slider info end-->


                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <button class="btn btn-primary" type="submit">
                                        <i data-feather="save" class="me-1"></i> {{ localize('Save') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!--right sidebar-->
                <div class="col-xl-3 order-1 order-md-1 order-lg-1 order-xl-2">
                    <div class="card tt-sticky-sidebar">
                        <div class="card-body">
                            <h5 class="mb-3">{{ localize('Homepage Configuration') }}</h5>
                            <div class="tt-vertical-step-link">
                                <ul class="list-unstyled">
                                    @include('backend.pages.appearance.homepage.inc.rightSidebar')
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@section('scripts')
    <script>
        "use strict";

        // runs when the document is ready --> for media files
        $(document).ready(function() {
            getChosenFilesCount();
            showSelectedFilePreviewOnLoad();
        });
    </script>
@endsection
