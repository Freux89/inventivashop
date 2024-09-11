<div class="card-body">
    <!-- Colonna -->
    <div class="row mb-4">
        <div class="col-12">
            <strong>{{ localize('Colonna') }}</strong>
        </div>
      

    </div>

     <!-- Titolo -->
     @include('backend.pages.sections.items.partials.title')


    <!-- Immagine-->
    <div class="row mb-4">
        <div class="col-12">
            <strong>{{ localize('Immagine') }}</strong>
        </div>

        <div class="col-md-12">
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
    </div>
    <!-- Descrizione -->
    <div class="row mb-4">
        <div class="col-12">
            <strong>{{ localize('Descrizione') }}</strong>
        </div>
        <div class="col-md-12">
            <label for="title" class="form-label">{{ localize('Descrizione') }}</label>
            <textarea id="description" class="editor" name="description">{{ isset($item->settings['description']) ? $item->settings['description'] : '' }}</textarea>
        </div>
       
    </div>
    

    <!-- Pulsante -->
    <div class="row mb-4">
        <div class="col-12">
            <strong>{{ localize('Url') }}</strong>
        </div>
        <div class="col-md-4">
            <label for="textUrl" class="form-label">{{ localize('Testo url') }}</label>
            <input class="form-control" type="text" id="textUrl" name="textUrl" value="{{ isset($item->settings['textUrl']) ? $item->settings['textUrl'] : '' }}">
            <span class="fs-sm text-muted">{{ localize('Inserisci il testo che apparirà sull\'url.') }}</span>
        </div>
       
        <div class="col-md-3">
            <label for="url" class="form-label">{{ localize('URL') }}</label>
            <input class="form-control" type="text" id="url" name="url" value="{{ isset($item->settings['url']) ? $item->settings['url'] : '' }}">
            
        </div>
    </div>

</div>

