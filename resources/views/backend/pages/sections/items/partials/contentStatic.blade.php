<div class="card-body">


    @php
    $section = $item->section;
    if($section->type == 'filtergrid'){

    $categoryList = isset($section->settings['categories']) ? $section->settings['categories'] : '';
    $categories = explode(',', $categoryList);
    }

    @endphp
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
    @if($section->type !== 'filtergrid')
    <div class="row mb-4">
        <div class="col-12">
            <strong>{{ localize('Valutazione') }}</strong>
        </div>
        <div class="col-md-4">
            <label for="starRating" class="form-label">{{ localize('Valutazione a Stelle') }}</label>
            <input class="form-control" type="number" id="starRating" name="starRating" value="{{ isset($item->settings['starRating']) ? $item->settings['starRating'] : '' }}" max="5" min="0" step="1">
            <span class="fs-sm text-muted">{{ localize('Imposta la valutazione a stelle della colonna.') }}</span>
        </div>
    </div>
    @endif
    @if($section->type == 'filtergrid')
    <div class="row mb-4">
        <div class="col-12">
            <strong>{{ localize('Categorie') }}</strong>
        </div>
        <div class="col-md-12">
        <label for="categories_item" class="form-label">{{ localize('Scegli le categorie di appartenenza') }}</label>
            <select class="form-control select2" name="categories_item[]" class="w-100" data-toggle="select2" data-placeholder="{{ localize('Seleziona categorie') }}" multiple>
                @foreach($categories as $category)
                <option value="{{$category}}" {{ in_array($category, $item->settings['categories_item']) ? 'selected' : '' }}>{{$category}}</option>
                @endforeach
            </select>
            <span class="fs-sm text-muted">{{ localize('Puoi selezionare più di una categoria') }}</span>

        </div>
    </div>
    @endif
    <!-- Pulsante -->
    <div class="row mb-4">
        <div class="col-12">
            <strong>{{ localize('Url') }}</strong>
        </div>
        <div class="col-md-3">
            <label for="url" class="form-label">{{ localize('Url') }}</label>
            <input class="form-control" type="url" id="url" name="url" value="{{ isset($item->settings['url']) ? $item->settings['url'] : '' }}">
            <span class="fs-sm text-muted">{{ localize('Inserisci l\'URL dell\'elemento.') }}</span>
        </div>
    </div>

</div>