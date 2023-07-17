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
                                <h2 class="h5 mb-lg-0">{{ localize('Popular Brands Section') }}</h2>
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
                        <!--about popular brands info start-->
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="mb-3">
                                    @php
                                        $about_popular_brand_ids = getSetting('about_popular_brand_ids') != null ? json_decode(getSetting('about_popular_brand_ids')) : [];
                                    @endphp
                                    <label class="form-label">{{ localize('Popular Brands') }}</label>
                                    <input type="hidden" name="types[]" value="about_popular_brand_ids">
                                    <select class="select2 form-control" multiple="multiple"
                                        data-placeholder="{{ localize('Select popular brands') }}"
                                        name="about_popular_brand_ids[]" required>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                @if (in_array($brand->id, $about_popular_brand_ids)) selected @endif>
                                                {{ $brand->collectLocalization('name') }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--about popular brands info end-->

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
