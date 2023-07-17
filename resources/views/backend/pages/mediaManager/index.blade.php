@extends('backend.layouts.master')

@section('title')
    {{ localize('Media Manager') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    <section class="tt-section pt-4 pb-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-lg-0">{{ localize('Media Manager') }}</h2>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-4 mb-4">
                <div class="col-12">
                    <div data-type="media-index">
                        @include('backend.inc.media-manager.media-manager-content')
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
            getMediaFiles();
        });
    </script>
@endsection
