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
                                <h2 class="h5 mb-lg-0">{{ localize('Update Feedback') }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4 g-4">
                <!--left sidebar-->
                <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">

                    <form action="{{ route('admin.appearance.homepage.updateClientFeedback') }}" method="POST"
                        enctype="multipart/form-data" id="section-1">
                        @csrf
                        <input type="hidden" name="id" value="{{ $id }}">
                        @php
                            $singleFeedback = null;
                            if (!empty($feedback)) {
                                foreach ($feedback as $key => $thisFeedback) {
                                    if ($thisFeedback->id == $id) {
                                        $singleFeedback = $thisFeedback;
                                    }
                                }
                            }
                        @endphp
                        <!--slider info start-->
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="name" class="form-label">{{ localize('Name') }}</label>
                                    <input type="text" name="name" id="name"
                                        placeholder="{{ localize('Type reviewer name') }}" class="form-control"
                                        value="{{ $singleFeedback->name }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">{{ localize('Rating') }}</label>
                                    <select class="select2 form-control" name="rating"
                                        data-minimum-results-for-search="Infinity">
                                        <option value="1" @if ($singleFeedback->rating == 1) selected @endif>1</option>
                                        <option value="2" @if ($singleFeedback->rating == 2) selected @endif>2</option>
                                        <option value="3" @if ($singleFeedback->rating == 3) selected @endif>3</option>
                                        <option value="4" @if ($singleFeedback->rating == 4) selected @endif>4</option>
                                        <option value="5" @if ($singleFeedback->rating == 5) selected @endif>5</option>
                                    </select>
                                </div>


                                <div class="mb-3">
                                    <label for="review" class="form-label">{{ localize('Review') }}</label>
                                    <textarea name="review" id="review" placeholder="{{ localize('Type review') }}" class="form-control" required>{{ $singleFeedback->review }}</textarea>
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
                                                <input type="hidden" name="image" value="{{ $singleFeedback->image }}">
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
                            <h5 class="mb-4">{{ localize('Client Feedback Configuration') }}</h5>
                            <div class="tt-vertical-step">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="#section-1" class="active">{{ localize('Update Feedback') }}</a>
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
