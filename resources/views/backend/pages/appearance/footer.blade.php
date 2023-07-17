@extends('backend.layouts.master')

@section('title')
    {{ localize('Website Footer Configuration') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-lg-0">{{ localize('Website Footer Configuration') }}</h2>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!--left sidebar-->
                <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">
                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data"
                        class="pb-4">
                        @csrf

                        <!--Topbar-->
                        <div class="card mb-4" id="section-1">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">{{ localize('Categories') }}</label>
                                    <input type="hidden" name="types[]" value="footer_categories">

                                    @php
                                        $footer_categories = getSetting('footer_categories') != null ? json_decode(getSetting('footer_categories')) : [];
                                    @endphp
                                    <select class="form-control select2" name="footer_categories[]" class="w-100"
                                        data-toggle="select2" data-placeholder="{{ localize('Select categories') }}"
                                        multiple>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                @if (in_array($category->id, $footer_categories)) selected @endif>
                                                {{ $category->collectLocalization('name') }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">{{ localize('Quick Links') }}</label>
                                    @php
                                        $quick_links = getSetting('quick_links') != null ? json_decode(getSetting('quick_links')) : [];
                                    @endphp
                                    <input type="hidden" name="types[]" value="quick_links">
                                    <select class="form-control select2" name="quick_links[]" class="w-100"
                                        data-toggle="select2" data-placeholder="{{ localize('Select quick link pages') }}"
                                        multiple>
                                        @foreach ($pages as $page)
                                            <option value="{{ $page->id }}"
                                                @if (in_array($page->id, $quick_links)) selected @endif>
                                                {{ $page->collectLocalization('title') }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="mb-3">
                                    <label for="copyright_text" class="form-label">{{ localize('Copyright Text') }}</label>
                                    <input type="hidden" name="types[]" value="copyright_text">
                                    <textarea name="copyright_text" id="copyright_text" class="editor form-control">{{ getSetting('copyright_text') }}</textarea>
                                </div>
                            </div>
                        </div>


                        <!--Images-->
                        <div class="card mb-4" id="section-2">
                            <div class="card-body">
                                <h5 class="mb-3">{{ localize('Images') }}</h5>

                                <div class="mb-3">
                                    <label class="form-label">{{ localize('Footer Logo') }}</label>
                                    <input type="hidden" name="types[]" value="footer_logo">
                                    <div class="tt-image-drop rounded">
                                        <span class="fw-semibold">{{ localize('Choose Footer Logo') }}</span>
                                        <!-- choose media -->
                                        <div class="tt-product-thumb show-selected-files mt-3">
                                            <div class="avatar avatar-xl cursor-pointer choose-media"
                                                data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
                                                onclick="showMediaManager(this)" data-selection="single">
                                                <input type="hidden" name="footer_logo"
                                                    value="{{ getSetting('footer_logo') }}">
                                                <div class="no-avatar rounded-circle">
                                                    <span><i data-feather="plus"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- choose media -->
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">{{ localize('Accepted Payment') }}</label>
                                    <input type="hidden" name="types[]" value="accepted_payment_banner">
                                    <div class="tt-image-drop rounded">
                                        <span class="fw-semibold">{{ localize('Choose Accepted Payment Banner') }}</span>
                                        <!-- choose media -->
                                        <div class="tt-product-thumb show-selected-files mt-3">
                                            <div class="avatar avatar-xl cursor-pointer choose-media"
                                                data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
                                                onclick="showMediaManager(this)" data-selection="single">
                                                <input type="hidden" name="accepted_payment_banner"
                                                    value="{{ getSetting('accepted_payment_banner') }}">
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


                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit">
                                <i data-feather="save" class="me-1"></i> {{ localize('Save Changes') }}
                            </button>
                        </div>
                    </form>
                </div>

                <!--right sidebar-->
                <div class="col-xl-3 order-1 order-md-1 order-lg-1 order-xl-2">
                    <div class="card tt-sticky-sidebar d-none d-xl-block">
                        <div class="card-body">
                            <h5 class="mb-3">{{ localize('Footer Configuration') }}</h5>
                            <div class="tt-vertical-step">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="#section-1" class="active">{{ localize('General Information') }}</a>
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
