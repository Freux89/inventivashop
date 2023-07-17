@extends('backend.layouts.master')

@section('title')
    {{ localize('Product Page Configuration') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-lg-0">{{ localize('Update Widget') }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4 g-4">
                <!--left sidebar-->
                <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">

                    <form action="{{ route('admin.appearance.products.details.updateWidget') }}" method="POST"
                        enctype="multipart/form-data" id="section-1">
                        @csrf
                        <input type="hidden" name="id" value="{{ $id }}">
                        @php
                            $widget = null;
                            if (!empty($widgets)) {
                                foreach ($widgets as $key => $thisWidget) {
                                    if ($thisWidget->id == $id) {
                                        $widget = $thisWidget;
                                    }
                                }
                            }
                        @endphp
                        <!--slider info start-->
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="title" class="form-label">{{ localize('Title') }}</label>
                                    <input type="text" name="title" id="title"
                                        placeholder="{{ localize('Type title') }}" class="form-control"
                                        value="{{ $widget->title }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="sub_title" class="form-label">{{ localize('Sub Title') }}</label>
                                    <input type="text" name="sub_title" id="sub_title"
                                        placeholder="{{ localize('Type sub title') }}" class="form-control"
                                        value="{{ $widget->sub_title }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">{{ localize('Slider Image') }}</label>
                                    <div class="tt-image-drop rounded">
                                        <span class="fw-semibold">{{ localize('Choose Slider Image') }}</span>
                                        <!-- choose media -->
                                        <div class="tt-product-thumb show-selected-files mt-3">
                                            <div class="avatar avatar-xl cursor-pointer choose-media"
                                                data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
                                                onclick="showMediaManager(this)" data-selection="single">
                                                <input type="hidden" name="image" value="{{ $widget->image }}">
                                                <div class="no-avatar rounded-circle">
                                                    <span><i data-feather="plus"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- choose media -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--slider info end-->


                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <button class="btn btn-primary" type="submit">
                                        <i data-feather="save" class="me-1"></i> {{ localize('Save Changes') }}
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
                            <h5 class="mb-4">{{ localize('Widgets Configuration') }}</h5>
                            <div class="tt-vertical-step">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="#section-1" class="active">{{ localize('Update Widget') }}</a>
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
