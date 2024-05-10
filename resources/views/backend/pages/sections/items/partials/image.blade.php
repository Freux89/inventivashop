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
            <strong>{{ localize('Immagine') }}</strong>
        </div>

        <div class="col-md-6">
            <label class="form-label">{{ localize('Image') }}</label>
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
        <div class="col-md-6">
            <label for="altImage" class="form-label">{{ localize('Alt immagine') }}</label>
            <input class="form-control" type="text" id="altImage" name="altImage" value="{{ isset($item->settings['altImage']) ? $item->settings['altImage'] : '' }}">
            <span class="fs-sm text-muted">{{ localize('Inserisci l\'alt dell\'immagine.') }}</span>
        </div>
    </div>


    <!-- Pulsante -->
    <div class="row mb-4">
        <div class="col-md-3">
            <label for="imageUrl" class="form-label">{{ localize('URL') }}</label>
            <input class="form-control" type="url" id="imageUrl" name="imageUrl" value="{{ isset($item->settings['imageUrl']) ? $item->settings['imageUrl'] : '' }}">
            <span class="fs-sm text-muted">{{ localize('Inserisci l\'URL a cui l\'immagine dovrebbe puntare.') }}</span>
        </div>
        <div class="col-md-3">
            <label for="titleUrl" class="form-label">{{ localize('Titolo URL') }}</label>
            <input class="form-control" type="text" id="titleUrl" name="titleUrl" value="{{ isset($item->settings['titleUrl']) ? $item->settings['titleUrl'] : '' }}">
            <span class="fs-sm text-muted">{{ localize('Inserisci il titolo dell\'url.') }}</span>
        </div>
    </div>

</div>