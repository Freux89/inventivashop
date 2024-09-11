<div class="card-body">
    <!-- Colonna -->
    <div class="row mb-4">
        <div class="col-12">
            <strong>{{ localize('Colonna') }}</strong>
        </div>
        @include('backend.pages.sections.items.partials.padding')

    </div>




    <!-- Immagine-->
    <div class="row mb-4">
        <div class="col-12">
            <strong>{{ localize('Video') }}</strong>
        </div>

        <div class="col-md-12">
            <label class="form-label">{{ localize('Anteprima video') }}</label>
            <div class="tt-image-drop rounded">
                <span class="fw-semibold">{{ localize('Choose Image') }}</span>
                <div class="tt-product-thumb show-selected-files mt-3">
                    <div class="avatar avatar-xl cursor-pointer choose-media" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" onclick="showMediaManager(this)" data-selection="single">
                        <input type="hidden" name="image" value="{{ isset($item->settings['image']) ? $item->settings['image'] : '' }}">
                        <div class="no-avatar rounded-circle">
                            <span><i data-feather="plus"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
    </div>


    <!-- Pulsante -->
    <div class="row mb-4">
        <div class="col-md-3">
            <label for="videoUrl" class="form-label">{{ localize('URL video') }}</label>
            <input class="form-control" type="text" id="videoUrl" name="videoUrl" value="{{ isset($item->settings['videoUrl']) ? $item->settings['videoUrl'] : '' }}">
            <span class="fs-sm text-muted">{{ localize('Inserisci l\'URL del video.') }}</span>
        </div>
    </div>

</div>