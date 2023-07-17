@extends('backend.layouts.master')

@section('title')
    {{ localize('Website Header Configuration') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-lg-0">{{ localize('Website Header Configuration') }}</h2>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!--left sidebar-->
                <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">
                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data"
                        class="pb-650">
                        @csrf

                        <!--Topbar-->
                        <div class="card mb-4" id="section-1">
                            <div class="card-body">
                                <h5 class="mb-4">{{ localize('Topbar Information') }}</h5>

                                <div class="mb-3">
                                    <label for="topbar_welcome_text"
                                        class="form-label">{{ localize('Welcome Text') }}</label>
                                    <input type="hidden" name="types[]" value="topbar_welcome_text">
                                    <input type="text" name="topbar_welcome_text" id="topbar_welcome_text"
                                        class="form-control" placeholder="{{ localize('Welcome to our organic store') }}"
                                        value="{{ getSetting('topbar_welcome_text') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="topbar_email" class="form-label">{{ localize('Topbar Email') }}</label>
                                    <input type="hidden" name="types[]" value="topbar_email">
                                    <input type="email" name="topbar_email" id="topbar_email" class="form-control"
                                        placeholder="{{ localize('grostore@support.com') }}"
                                        value="{{ getSetting('topbar_email') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="topbar_location"
                                        class="form-label">{{ localize('Topbar Location') }}</label>
                                    <input type="hidden" name="types[]" value="topbar_location">
                                    <input type="text" name="topbar_location" id="topbar_location" class="form-control"
                                        placeholder="{{ localize('Washington, New York, USA - 254230') }}"
                                        value="{{ getSetting('topbar_location') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="facebook_link" class="form-label">{{ localize('Facebook Link') }}</label>
                                    <input type="hidden" name="types[]" value="facebook_link">
                                    <input type="url" name="facebook_link" id="facebook_link" class="form-control"
                                        placeholder="https://facebook.com/example"
                                        value="{{ getSetting('facebook_link') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="twitter_link" class="form-label">{{ localize('Twitter Link') }}</label>
                                    <input type="hidden" name="types[]" value="twitter_link">
                                    <input type="url" name="twitter_link" id="twitter_link" class="form-control"
                                        placeholder="https://twitter.com/example" value="{{ getSetting('twitter_link') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="linkedin_link" class="form-label">{{ localize('LinkedIn Link') }}</label>
                                    <input type="hidden" name="types[]" value="linkedin_link">
                                    <input type="url" name="linkedin_link" id="linkedin_link" class="form-control"
                                        placeholder="https://linkedin.com/example"
                                        value="{{ getSetting('linkedin_link') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="youtube_link" class="form-label">{{ localize('Youtube Link') }}</label>
                                    <input type="hidden" name="types[]" value="youtube_link">
                                    <input type="url" name="youtube_link" id="youtube_link" class="form-control"
                                        placeholder="https://youtube.com/example"
                                        value="{{ getSetting('youtube_link') }}">
                                </div>


                                <div class="mb-3">
                                    <label for="about_us" class="form-label">{{ localize('About Us') }}</label>
                                    <input type="hidden" name="types[]" value="about_us">
                                    <textarea name="about_us" id="about_us" class="form-control">{{ getSetting('about_us') }}</textarea>
                                </div>

                            </div>
                        </div>


                        <!--Navbar-->
                        <div class="card mb-4" id="section-2">
                            <div class="card-body">
                                <h5 class="mb-4">{{ localize('Navbar Information') }}</h5>

                                <div class="mb-3">
                                    <label class="form-label">{{ localize('Navbar Logo') }}</label>
                                    <input type="hidden" name="types[]" value="navbar_logo">
                                    <div class="tt-image-drop rounded">
                                        <span class="fw-semibold">{{ localize('Choose Navbar Logo') }}</span>
                                        <!-- choose media -->
                                        <div class="tt-product-thumb show-selected-files mt-3">
                                            <div class="avatar avatar-xl cursor-pointer choose-media"
                                                data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
                                                onclick="showMediaManager(this)" data-selection="single">
                                                <input type="hidden" name="navbar_logo"
                                                    value="{{ getSetting('navbar_logo') }}">
                                                <div class="no-avatar rounded-circle">
                                                    <span><i data-feather="plus"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- choose media -->
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">{{ localize('Categories') }}</label>
                                    <input type="hidden" name="types[]" value="navbar_categories">

                                    @php
                                        $navbar_categories = getSetting('navbar_categories') != null ? json_decode(getSetting('navbar_categories')) : [];
                                    @endphp
                                    <select class="form-control select2" name="navbar_categories[]" class="w-100"
                                        data-toggle="select2" data-placeholder="{{ localize('Select categories') }}"
                                        multiple>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                @if (in_array($category->id, $navbar_categories)) selected @endif>
                                                {{ $category->collectLocalization('name') }}</option>
                                            @foreach ($category->childrenCategories as $childCategory)
                                                @include('backend.pages.products.categories.subCategory', [
                                                    'subCategory' => $childCategory,
                                                    'navbar_categories' => $navbar_categories,
                                                ])
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">{{ localize('Pages') }}</label>
                                    @php
                                        $navbar_pages = getSetting('navbar_pages') != null ? json_decode(getSetting('navbar_pages')) : [];
                                    @endphp
                                    <input type="hidden" name="types[]" value="navbar_pages">
                                    <select class="form-control select2" name="navbar_pages[]" class="w-100"
                                        data-toggle="select2" data-placeholder="{{ localize('Select pages') }}" multiple>
                                        @foreach ($pages as $page)
                                            <option value="{{ $page->id }}"
                                                @if (in_array($page->id, $navbar_pages)) selected @endif>
                                                {{ $page->collectLocalization('title') }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="navbar_contact_number"
                                        class="form-label">{{ localize('Contact Number') }}</label>
                                    <input type="hidden" name="types[]" value="navbar_contact_number">
                                    <input type="text" name="navbar_contact_number" id="navbar_contact_number"
                                        class="form-control" placeholder="+80 157 058 4567"
                                        value="{{ getSetting('navbar_contact_number') }}">
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
                            <h5 class="mb-4">{{ localize('Header Configuration') }}</h5>
                            <div class="tt-vertical-step">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="#section-1" class="active">{{ localize('Topbar Information') }}</a>
                                    </li>
                                    <li>
                                        <a href="#section-2">{{ localize('Navbar Information') }}</a>
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
