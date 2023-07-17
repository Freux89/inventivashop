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
                                <h2 class="h5 mb-lg-0">{{ localize('Features Section') }}</h2>
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
                                <h5 class="mb-4">{{ localize('General Information') }}</h5>
                                <div class="mb-3">
                                    <label for="about_features_title" class="form-label">{{ localize('Title') }}</label>
                                    <input type="hidden" name="types[]" value="about_features_title">
                                    <input type="text" name="about_features_title" id="about_features_title"
                                        placeholder="{{ localize('Type title') }}" class="form-control"
                                        value="{{ getSetting('about_features_title') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="about_features_sub_title"
                                        class="form-label">{{ localize('Sub Title') }}</label>
                                    <input type="hidden" name="types[]" value="about_features_sub_title">
                                    <input type="text" name="about_features_sub_title" id="about_features_sub_title"
                                        placeholder="{{ localize('Type sub title') }}" class="form-control"
                                        value="{{ getSetting('about_features_sub_title') }}">
                                </div>
                            </div>
                        </div>
                        <!--about intro info end-->

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-5">
                                    <button class="btn btn-primary" type="submit">
                                        <i data-feather="save" class="me-1"></i> {{ localize('Save Changes') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- features -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Features') }}</h5>
                            <table class="table tt-footable" data-use-parent-width="true">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="7%">{{ localize('S/L') }}</th>
                                        <th>{{ localize('Icon') }}</th>
                                        <th data-breakpoints="xs sm">{{ localize('Title') }}</th>
                                        <th data-breakpoints="xs sm">{{ localize('Text') }}</th>
                                        <th data-breakpoints="xs sm" class="text-end">
                                            {{ localize('Action') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($features as $key => $feature)
                                        <tr>
                                            <td class="text-center align-middle">
                                                {{ $key + 1 }}
                                            </td>
                                            <td class="align-middle">
                                                <div class="avatar avatar-md">
                                                    <img class="rounded" src="{{ uploadedAsset($feature->image) }}"
                                                        alt="" />
                                                </div>
                                            </td>

                                            <td class="align-middle">
                                                <h6 class="fs-sm mb-0">
                                                    {{ $feature->title }}</h6>
                                            </td>

                                            <td class="align-middle">
                                                {{ $feature->text }}
                                            </td>

                                            <td class="text-end align-middle">
                                                <div class="dropdown tt-tb-dropdown">
                                                    <button type="button" class="btn p-0" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i data-feather="more-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow">

                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.appearance.about-us.editFeatures', ['id' => $feature->id, 'lang_key' => env('DEFAULT_LANGUAGE')]) }}&localize">
                                                            <i data-feather="edit-3"
                                                                class="me-2"></i>{{ localize('Edit') }}
                                                        </a>

                                                        <a href="#" class="dropdown-item confirm-delete"
                                                            data-href="{{ route('admin.appearance.about-us.deleteFeatures', $feature->id) }}"
                                                            title="{{ localize('Delete') }}">
                                                            <i data-feather="trash-2" class="me-2"></i>
                                                            {{ localize('Delete') }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- features -->


                    <!-- add features -->
                    <form action="{{ route('admin.appearance.about-us.storeFeatures') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <!--slider info start-->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="mb-4">{{ localize('Add New Feature') }}</h5>

                                <div class="mb-4">
                                    <label for="title" class="form-label">{{ localize('Title') }}</label>
                                    <input type="text" name="title" id="title"
                                        placeholder="{{ localize('Type title') }}" class="form-control" required>
                                </div>

                                <div class="mb-4">
                                    <label for="text" class="form-label">{{ localize('Text') }}</label>
                                    <input type="text" name="text" id="text"
                                        placeholder="{{ localize('Type text') }}" class="form-control" required>
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
                                                <input type="hidden" name="image">
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
                                        <i data-feather="save" class="me-1"></i> {{ localize('Save Feature') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- add features -->

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
