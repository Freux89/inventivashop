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
                                <h2 class="h5 mb-lg-0">{{ localize('Intro Section') }}</h2>
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
                        <!--about intro info start-->
                        <div class="card mb-4">
                            <div class="card-body">

                                <div class="mb-3">
                                    <label for="about_intro_sub_title"
                                        class="form-label">{{ localize('Sub Title') }}</label>
                                    <input type="hidden" name="types[]" value="about_intro_sub_title">
                                    <input type="text" name="about_intro_sub_title" id="about_intro_sub_title"
                                        placeholder="{{ localize('Type sub title') }}" class="form-control"
                                        value="{{ getSetting('about_intro_sub_title') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="about_intro_title" class="form-label">{{ localize('Title') }}</label>
                                    <input type="hidden" name="types[]" value="about_intro_title">
                                    <input type="text" name="about_intro_title" id="about_intro_title"
                                        placeholder="{{ localize('Type title') }}" class="form-control"
                                        value="{{ getSetting('about_intro_title') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="about_intro_text" class="form-label">{{ localize('Text') }}</label>
                                    <input type="hidden" name="types[]" value="about_intro_text">
                                    <input type="text" name="about_intro_text" id="about_intro_text"
                                        placeholder="{{ localize('Type text') }}" class="form-control"
                                        value="{{ getSetting('about_intro_text') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="about_intro_mission" class="form-label">{{ localize('Mission') }}</label>
                                    <input type="hidden" name="types[]" value="about_intro_mission">
                                    <textarea name="about_intro_mission" id="about_intro_mission" class="form-control">{{ getSetting('about_intro_mission') }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="about_intro_vision" class="form-label">{{ localize('Vision') }}</label>
                                    <input type="hidden" name="types[]" value="about_intro_vision">
                                    <textarea name="about_intro_vision" id="about_intro_vision" class="form-control">{{ getSetting('about_intro_vision') }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="about_intro_quote" class="form-label">{{ localize('Quote') }}</label>
                                    <input type="hidden" name="types[]" value="about_intro_quote">
                                    <textarea name="about_intro_quote" id="about_intro_quote" class="form-control">{{ getSetting('about_intro_quote') }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="about_intro_quote_by" class="form-label">{{ localize('Quote By') }}</label>
                                    <input type="hidden" name="types[]" value="about_intro_quote_by">
                                    <input type="text" name="about_intro_quote_by" id="text"
                                        placeholder="{{ localize('Type name of the user') }}" class="form-control"
                                        value="{{ getSetting('about_intro_quote_by') }}">
                                </div>


                                <div class="mb-3">
                                    <label class="form-label">{{ localize('Image') }}</label>
                                    <input type="hidden" name="types[]" value="about_intro_image">
                                    <div class="tt-image-drop rounded">
                                        <span class="fw-semibold">{{ localize('Choose Banner Image') }}</span>
                                        <!-- choose media -->
                                        <div class="tt-product-thumb show-selected-files mt-3">
                                            <div class="avatar avatar-xl cursor-pointer choose-media"
                                                data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
                                                onclick="showMediaManager(this)" data-selection="single">
                                                <input type="hidden" name="about_intro_image"
                                                    value="{{ getSetting('about_intro_image') }}">
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
                        <!--about intro info end-->

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
                            <h5 class="mb-4">{{ localize('About Us Configuration') }}</h5>
                            <div class="tt-vertical-step-link">
                                <ul class="list-unstyled">
                                    @include('backend.pages.appearance.aboutUs.inc.rightSidebar')
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
