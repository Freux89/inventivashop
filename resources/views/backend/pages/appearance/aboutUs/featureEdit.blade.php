@extends('backend.layouts.master')

@section('title')
    {{ localize('About Us Configuration') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-lg-0">{{ localize('Update Feature') }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4 g-4">
                <!--left sidebar-->
                <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">

                    <form action="{{ route('admin.appearance.about-us.updateFeatures') }}" method="POST"
                        enctype="multipart/form-data" id="section-1">
                        @csrf
                        <input type="hidden" name="id" value="{{ $id }}">
                        @php
                            $feature = null;
                            if (!empty($features)) {
                                foreach ($features as $key => $thisFeature) {
                                    if ($thisFeature->id == $id) {
                                        $feature = $thisFeature;
                                    }
                                }
                            }
                        @endphp
                        <!--slider info start-->
                        <div class="card mb-4">
                            <div class="card-body">


                                <div class="mb-4">
                                    <label for="title" class="form-label">{{ localize('Title') }}</label>
                                    <input type="text" name="title" id="title"
                                        placeholder="{{ localize('Type title') }}" class="form-control"
                                        value="{{ $feature->title }}" required>
                                </div>

                                <div class="mb-4">
                                    <label for="text" class="form-label">{{ localize('Text') }}</label>
                                    <input type="text" name="text" id="text"
                                        placeholder="{{ localize('Type text') }}" class="form-control"
                                        value="{{ $feature->text }}" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">{{ localize('Icon Image') }}</label>
                                    <div class="tt-image-drop rounded">
                                        <span class="fw-semibold">{{ localize('Choose Icon Image') }}</span>
                                        <!-- choose media -->
                                        <div class="tt-product-thumb show-selected-files mt-3">
                                            <div class="avatar avatar-xl cursor-pointer choose-media"
                                                data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
                                                onclick="showMediaManager(this)" data-selection="single">
                                                <input type="hidden" name="image" value="{{ $feature->image }}">
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
                                <div class="mb-4">
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
                            <h5 class="mb-4">{{ localize('About Us Configuration') }}</h5>
                            <div class="tt-vertical-step">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="#section-1" class="active">{{ localize('Update Feature') }}</a>
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
