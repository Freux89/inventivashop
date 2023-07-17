<div class="card-body">
    <div class="row mb-4">
        {{-- recent uploads --}}
        <div class="col-12 col-lg-6">
            <h5>{{ localize('Recently uploaded files') }}</h5>
            <div class="row g-2 recent-uploads  tt-media-wrap">
                {{-- data will come from ajax response --}}
            </div>
        </div>

        {{-- uploader --}}
        <div class="col-12 col-lg-6 order-first order-md-last mb-2 mb-md-0 ps-md-3">
            @can('add_media')
                <h5>{{ localize('Add files here') }}</h5>
                <div class="uppy-drag-drop-area"></div>
            @endcan
        </div>
    </div>

    <div class="card bg-secondary-subtle">
        <div class="card-header border-bottom-0">
            {{-- search --}}

            <form action="" id="media-search-from">
                <div class="row justify-content-between align-items-center g-3">

                    <div class="col-auto flex-grow-1">
                        <h5 class="mb-0">{{ localize('Previously uploaded files') }}</h5>
                    </div>
                    <div class="col-auto">

                        <div class="tt-search-box">
                            <div class="input-group">
                                <span class="position-absolute top-50 start-0 translate-middle-y ms-2"> <i
                                        data-feather="search"></i></span>
                                <input class="form-control rounded-start w-100" type="text" id="search"
                                    name="media-search" placeholder="{{ localize('Search by name') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-secondary">
                            <i data-feather="search" width="18"></i>
                            {{ localize('Search') }}
                        </button>
                    </div>
                </div>
            </form>
            {{-- search --}}
        </div>


        <div class="card-body row g-2 previous-uploads tt-media-wrap">
            {{-- data will come from ajax response --}}
        </div>
    </div>

    <div class="mt-3 load-more-media d-none">
        <button class="btn btn-primary" onclick="getNextMediaFiles()">
            <span> <i data-feather="refresh-cw" class="me-2" width="18"></i>{{ localize('Load More') }}</span>
        </button>
    </div>

</div>
