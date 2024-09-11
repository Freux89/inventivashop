<div class="card-body">
    <!-- Colonna -->
    <div class="row mb-4">
        <div class="col-12">
            <strong>{{ localize('Colonna') }}</strong>
        </div>
        @include('backend.pages.sections.items.partials.padding')

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
    <!-- Valutazione -->
    <div class="row mb-4">
        <div class="col-12">
            <strong>{{ localize('Valutazione') }}</strong>
        </div>
        <div class="col-md-2">
            <label for="starRating" class="form-label">{{ localize('Valutazione a Stelle') }}</label>
            <input class="form-control" type="number" id="starRating" name="starRating" value="{{ isset($item->settings['starRating']) ? $item->settings['starRating'] : '' }}" max="5" min="0" step="1">
            <span class="fs-sm text-muted">{{ localize('Imposta la valutazione a stelle della colonna.') }}</span>
        </div>
    </div>

    <!-- Pulsante -->
    <div class="row mb-4">
        <div class="col-12">
            <strong>{{ localize('Pulsante') }}</strong>
        </div>
        <div class="col-md-4">
            <label for="buttonText" class="form-label">{{ localize('Testo del Pulsante') }}</label>
            <input class="form-control" type="text" id="buttonText" name="buttonText" value="{{ isset($item->settings['buttonText']) ? $item->settings['buttonText'] : '' }}">
            <span class="fs-sm text-muted">{{ localize('Inserisci il testo che apparirà sul pulsante.') }}</span>
        </div>
        <div class="col-md-3">
        <x-color-picker 
    id="buttonTextColor" 
    name="buttonTextColor" 
    value="{{ old('buttonTextColor', $item->settings['buttonTextColor'] ?? '') }}"
    label="{{ localize('Colore del Testo del Pulsante') }}"
/>
<span class="fs-sm text-muted">{{ localize('Scegli il colore del testo del pulsante.') }}</span>
        </div>
        <div class="col-md-3">
            <label for="buttonUrl" class="form-label">{{ localize('URL del Pulsante') }}</label>
            <input class="form-control" type="text" id="buttonUrl" name="buttonUrl" value="{{ isset($item->settings['buttonUrl']) ? $item->settings['buttonUrl'] : '' }}">
            <span class="fs-sm text-muted">{{ localize('Inserisci l\'URL a cui il pulsante dovrebbe puntare.') }}</span>
        </div>
    </div>

</div>

