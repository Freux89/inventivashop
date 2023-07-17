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
                                <h2 class="h5 mb-lg-0">{{ localize('What Clients Say') }}</h2>
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
                                            <th>{{ localize('Name') }}</th>
                                            <th data-breakpoints="xs sm md lg xl">{{ localize('Review') }}</th>
                                            <th data-breakpoints="xs sm" class="text-end">
                                                {{ localize('Action') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($feedback as $key => $singleFeedback)
                                            <tr>
                                                <td class="text-center align-middle">
                                                    {{ $key + 1 }}
                                                </td>
                                                <td class="align-middle">
                                                    <div class="avatar avatar-lg">
                                                        <img class="rounded"
                                                            src="{{ uploadedAsset($singleFeedback->image) }}"
                                                            alt="" />
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    <h6 class="fs-sm mb-0">
                                                        {{ $singleFeedback->name }}</h6>
                                                    <div>{{ renderStarRating($singleFeedback->rating) }}</div>
                                                </td>

                                                <td class="align-middle">
                                                    {{ $singleFeedback->review }}
                                                </td>

                                                <td class="text-end align-middle">
                                                    <div class="dropdown tt-tb-dropdown">
                                                        <button type="button" class="btn p-0" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            <i data-feather="more-vertical"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end shadow">

                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.appearance.homepage.editClientFeedback', ['id' => $singleFeedback->id, 'lang_key' => env('DEFAULT_LANGUAGE')]) }}&localize">
                                                                <i data-feather="edit-3"
                                                                    class="me-2"></i>{{ localize('Edit') }}
                                                            </a>

                                                            <a href="#" class="dropdown-item confirm-delete"
                                                                data-href="{{ route('admin.appearance.homepage.deleteClientFeedback', $singleFeedback->id) }}"
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

                    <form action="{{ route('admin.appearance.homepage.storeClientFeedback') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <!--slider info start-->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="mb-4">{{ localize('Add New Feedback') }}</h5>

                                <div class="mb-3">
                                    <label for="name" class="form-label">{{ localize('Name') }}</label>
                                    <input type="text" name="name" id="name"
                                        placeholder="{{ localize('Type reviewer name') }}" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">{{ localize('Rating') }}</label>
                                    <select class="select2 form-control" name="rating"
                                        data-minimum-results-for-search="Infinity">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>


                                <div class="mb-3">
                                    <label for="review" class="form-label">{{ localize('Review') }}</label>
                                    <textarea name="review" id="review" placeholder="{{ localize('Type review') }}" class="form-control" required></textarea>
                                </div>


                                <div class="mb-3">
                                    <label class="form-label">{{ localize('Avatar Image') }}</label>
                                    <div class="tt-image-drop rounded">
                                        <span class="fw-semibold">{{ localize('Choose Avatar Image') }}</span>
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
                                <div class="mb-3">
                                    <button class="btn btn-primary" type="submit">
                                        <i data-feather="save" class="me-1"></i> {{ localize('Save Feedback') }}
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
                            <h5 class="mb-4">{{ localize('Homepage Configuration') }}</h5>
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
