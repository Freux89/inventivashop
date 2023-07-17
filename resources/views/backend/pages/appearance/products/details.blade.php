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
                                <h2 class="h5 mb-lg-0">{{ localize('Product Details Widget') }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4 g-4">
                <!--left sidebar-->
                <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-4" id="section-1">
                                <table class="table tt-footable" data-use-parent-width="true">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="7%">{{ localize('S/L') }}</th>
                                            <th>{{ localize('Image') }}</th>
                                            <th data-breakpoints="xs sm">{{ localize('Title') }}</th>
                                            <th>{{ localize('Sub Title') }}</th>
                                            <th data-breakpoints="xs sm" class="text-end">
                                                {{ localize('Action') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($widgets as $key => $widget)
                                            <tr>
                                                <td class="text-center align-middle">
                                                    {{ $key + 1 }}
                                                </td>
                                                <td class="align-middle">
                                                    <div class="avatar avatar-sm">
                                                        <img class="rounded" src="{{ uploadedAsset($widget->image) }}"
                                                            alt="" />
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    <h6 class="fs-sm mb-0">
                                                        {{ $widget->title }}</h6>
                                                </td>

                                                <td class="align-middle">
                                                    <h6 class="fs-sm mb-0">
                                                        {{ $widget->sub_title }}</h6>
                                                </td>

                                                <td class="text-end align-middle">
                                                    <div class="dropdown tt-tb-dropdown">
                                                        <button type="button" class="btn p-0" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            <i data-feather="more-vertical"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end shadow">

                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.appearance.products.details.editWidget', ['id' => $widget->id, 'lang_key' => env('DEFAULT_LANGUAGE')]) }}&localize">
                                                                <i data-feather="edit-3"
                                                                    class="me-2"></i>{{ localize('Edit') }}
                                                            </a>

                                                            <a href="#" class="dropdown-item confirm-delete"
                                                                data-href="{{ route('admin.appearance.products.details.deleteWidget', $widget->id) }}"
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
                    </div>

                    <form action="{{ route('admin.appearance.products.details.storeWidget') }}" method="POST"
                        enctype="multipart/form-data" class="mb-3" id="section-one">
                        @csrf
                        <!--widget info start-->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="mb-3">{{ localize('Add New Widget') }}</h5>

                                <div class="mb-3">
                                    <label for="title" class="form-label">{{ localize('Title') }}</label>
                                    <input type="text" name="title" id="title"
                                        placeholder="{{ localize('Type title') }}" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="sub_title" class="form-label">{{ localize('Sub Title') }}</label>
                                    <input type="text" name="sub_title" id="sub_title"
                                        placeholder="{{ localize('Type sub title') }}" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">{{ localize('Icon') }}</label>
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
                        <!--widget info end-->

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <button class="btn btn-primary" type="submit">
                                        <i data-feather="save" class="me-1"></i> {{ localize('Save Widget') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>


                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data"
                        class="pb-650" id="section-banner">
                        @csrf
                        <!--widget info start-->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="mb-3">{{ localize('Add Promotional Banner') }}</h5>

                                <div class="mb-3">
                                    <input type="hidden" name="types[]" value="product_page_banner_link">
                                    <label for="product_page_banner_link"
                                        class="form-label">{{ localize('Link') }}</label>
                                    <input type="url" name="product_page_banner_link" id="product_page_banner_link"
                                        placeholder="{{ localize('Type link') }}" class="form-control"
                                        value="{{ getSetting('product_page_banner_link') }}">
                                </div>


                                <div class="mb-3">
                                    <label class="form-label">{{ localize('Promotional Banner') }}</label>
                                    <input type="hidden" name="types[]" value="product_page_banner">
                                    <div class="tt-image-drop rounded">
                                        <span class="fw-semibold">{{ localize('Choose Promotional Banner') }}</span>
                                        <!-- choose media -->
                                        <div class="tt-product-thumb show-selected-files mt-3">
                                            <div class="avatar avatar-xl cursor-pointer choose-media"
                                                data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
                                                onclick="showMediaManager(this)" data-selection="single">
                                                <input type="hidden" name="product_page_banner"
                                                    value="{{ getSetting('product_page_banner') }}">
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
                        <!--widget info end-->

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <button class="btn btn-primary" type="submit">
                                        <i data-feather="save" class="me-1"></i> {{ localize('Save Banner') }}
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
                            <h5 class="mb-4">{{ localize('Product Details Page') }}</h5>
                            <div class="tt-vertical-step">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="#section-one" class="active">{{ localize('Widgets') }}</a>
                                    </li>

                                    <li>
                                        <a href="#section-banner">{{ localize('Promotional Banner') }}</a>
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
