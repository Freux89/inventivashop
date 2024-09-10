@extends('backend.layouts.master')


@section('title')
{{ localize('Update Variation Value') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
<section class="tt-section pt-4">
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body">
                        <div class="row g-3 align-items-center">
                            <div class="col-auto flex-grow-1">
                                <div class="tt-page-title">
                                    <h2 class="h5 mb-0">{{ localize('Update Variation Value') }} <sup
                                            class="badge bg-soft-warning px-2">{{ $lang_key }}</sup></h2>
                                </div>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('admin.variationValues.index', $variationValue->variation_id) }}" class="btn btn-link">
                                    <i class="fas fa-arrow-left"></i> Torna ai valori variante
                                </a>
                            </div>
                            <div class="col-4 col-md-2">
                                <select id="language" class="w-100 form-control text-capitalize country-flag-select"
                                    data-toggle="select2" onchange="localizeData(this.value)">
                                    @foreach (\App\Models\Language::all() as $key => $language)
                                    <option value="{{ $language->code }}"
                                        {{ $lang_key == $language->code ? 'selected' : '' }}
                                        data-flag="{{ staticAsset('backend/assets/img/flags/' . $language->flag . '.png') }}">
                                        {{ $language->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="row mb-4 g-4">

            <!--left sidebar-->
            <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">
                <form action="{{ route('admin.variationValues.update') }}" method="POST" class="pb-650">
                    @csrf
                    <input type="hidden" name="id" value="{{ $variationValue->id }}">
                    <input type="hidden" name="variation_id" value="{{ $variationValue->variation_id }}">
                    <input type="hidden" name="lang_key" value="{{ $lang_key }}">
                    <!--basic information start-->
                    <div class="card mb-4" id="section-1">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Basic Information') }}</h5>

                            <div class="mb-4">
                                <label for="name" class="form-label">{{ localize('Variation Value Name') }}</label>
                                <input type="text" name="name"
                                    value="{{ $variationValue->collectLocalization('name', $lang_key) }}"
                                    id="name" placeholder="{{ localize('Variation value name') }}"
                                    class="form-control" required>
                            </div>

                            <div class="mb-4">
                                <label for="default_price" class="form-label">{{ localize('Prezzo di default') }}</label>
                                <input type="text" name="default_price" value="{{ $variationValue->default_price }}" id="default_price" class="form-control">
                                <div><small class="form-text text-muted">{{ localize('Questo prezzo sarà utilizzato se non viene specificato un prezzo per il valore della variante all\'interno del prodotto.') }}</small></div>
                            </div>
                            <div class="mb-4">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="activate_dimensions" 
               {{ ($variationValue->width || $variationValue->height) ? 'checked' : '' }} 
               onclick="toggleDimensions()">
        <label class="form-check-label" for="activate_dimensions">
            {{ localize('Attiva Dimensione') }}
        </label>
    </div>
    <div id="dimension_fields" style="display: {{ ($variationValue->width || $variationValue->height) ? 'block' : 'none' }};">
        <label for="width" class="form-label">{{ localize('Larghezza (mm)') }}</label>
        <input type="number" name="width" value="{{ $variationValue->width }}" id="width" class="form-control">
        <small class="form-text text-muted">{{ localize('Inserisci la larghezza in millimetri (mm).') }}</small>
        <br>
        <label for="height" class="form-label">{{ localize('Altezza (mm)') }}</label>
        <input type="number" name="height" value="{{ $variationValue->height }}" id="height" class="form-control">
        <small class="form-text text-muted">{{ localize('Inserisci l\'altezza in millimetri (mm).') }}</small>
    </div>
</div>
                            <div class="mb-4">
                                <label class="form-label">{{ localize('Image') }}</label>
                                <div class="tt-image-drop rounded">
                                    <span class="fw-semibold">{{ localize('Choose Image') }}</span>
                                    <div class="tt-product-thumb show-selected-files mt-3">
                                        <div class="avatar avatar-xl cursor-pointer choose-media"
                                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
                                            onclick="showMediaManager(this)" data-selection="single">
                                            <input type="hidden" name="image" value="{{ $variationValue->image }}">
                                            <div class="no-avatar rounded-circle">
                                                <span><i data-feather="plus"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h5 class="mb-4">{{ localize('Info') }}</h5>

                            <div class="mb-4">
                                <label for="name" class="form-label">{{ localize('Info valore variante') }}</label>
                                <textarea name="info_description" class="editor" class="form-control">{{ $variationValue->collectLocalization('info_description', $lang_key) }}</textarea>
                            </div>


                            <!-- New Section for Info Type -->
                            <h5 class="mb-4">{{ localize('Info Media') }}</h5>

                            <!-- Radio Input for selecting the type of info -->
                            <div class="mb-4">
                                <label class="form-label">{{ localize('Seleziona tipo') }}</label>
                                <div class="d-flex gap-3">
                                    <div>
                                        <input type="radio" id="info_type_image" name="info_type" value="image"
                                            {{ $variationValue->info_image_id ? 'checked' : '' }}>
                                        <label for="info_type_image">{{ localize('Immagine singola') }}</label>
                                    </div>
                                    <div>
                                        <input type="radio" id="info_type_gallery" name="info_type" value="gallery"
                                            {{ $variationValue->info_slider_image_ids ? 'checked' : '' }}>
                                        <label for="info_type_gallery">{{ localize('Galleria slide') }}</label>
                                    </div>
                                    <div>
                                        <input type="radio" id="info_type_video" name="info_type" value="video"
                                            {{ $variationValue->info_video_url ? 'checked' : '' }}>
                                        <label for="info_type_video">{{ localize('Video') }}</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Image Field -->
                            <div class="mb-4 info-image-field">
                                <label class="form-label">{{ localize('Info Image') }}</label>
                                <div class="tt-image-drop rounded">
                                    <span class="fw-semibold">{{ localize('Choose Image') }}</span>
                                    <div class="tt-product-thumb show-selected-files mt-3">
                                        <div class="avatar avatar-xl cursor-pointer choose-media"
                                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
                                            onclick="showMediaManager(this)" data-selection="single">
                                            <input type="hidden" name="info_image_id" value="{{ $variationValue->info_image_id }}">
                                            <div class="no-avatar rounded-circle">
                                                <span><i data-feather="plus"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Image Gallery Field -->
                            <div class="mb-4 info-gallery-field d-none">
                                <label class="form-label">{{ localize('Info Gallery Images') }}</label>
                                <div class="tt-image-drop rounded">
                                    <span class="fw-semibold">{{ localize('Choose Images') }}</span>
                                    <div class="tt-product-thumb show-selected-files mt-3">
                                        <div class="avatar avatar-xl cursor-pointer choose-media"
                                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
                                            onclick="showMediaManager(this)" data-selection="multiple">
                                            <input type="hidden" name="info_slider_image_ids" value="{{ $variationValue->info_slider_image_ids }}">
                                            <div class="no-avatar rounded-circle">
                                                <span><i data-feather="plus"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Video URL Field -->
                            <div class="mb-4 info-video-field d-none">
                                <label for="info_video_url" class="form-label">{{ localize('Info Video URL') }}</label>
                                <input type="text" name="info_video_url" value="{{ $variationValue->info_video_url }}" id="info_video_url" placeholder="{{ localize('Enter Video URL') }}" class="form-control">
                            </div>

                        </div>
                    </div>
                    <!--basic information end-->

                    <!-- submit button -->
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-4">
                                <button class="btn btn-primary" type="submit">
                                    <i data-feather="save" class="me-1"></i> {{ localize('Save Changes') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- submit button end -->

                </form>
            </div>

            <!--right sidebar-->
            <div class="col-xl-3 order-1 order-md-1 order-lg-1 order-xl-2">
                <div class="card tt-sticky-sidebar d-none d-xl-block">
                    <div class="card-body">
                        <h5 class="mb-4">{{ localize('Variation Value Information') }}</h5>
                        <div class="tt-vertical-step">
                            <ul class="list-unstyled">
                                <li>
                                    <a href="#section-1" class="active">{{ localize('Basic Information') }}</a>
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
@include('backend.inc.product-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const radioInputs = document.querySelectorAll('input[name="info_type"]');
        const infoImageField = document.querySelector('.info-image-field');
        const infoGalleryField = document.querySelector('.info-gallery-field');
        const infoVideoField = document.querySelector('.info-video-field');

        // Funzione per aggiornare la visibilità dei campi
        function updateInfoFields() {
            radioInputs.forEach(function(radio) {
                if (radio.checked) {
                    if (radio.value === 'image') {
                        infoImageField.classList.remove('d-none');
                        infoGalleryField.classList.add('d-none');
                        infoVideoField.classList.add('d-none');
                    } else if (radio.value === 'gallery') {
                        infoImageField.classList.add('d-none');
                        infoGalleryField.classList.remove('d-none');
                        infoVideoField.classList.add('d-none');
                    } else if (radio.value === 'video') {
                        infoImageField.classList.add('d-none');
                        infoGalleryField.classList.add('d-none');
                        infoVideoField.classList.remove('d-none');
                    }
                }
            });
        }

        // Chiamare la funzione all'inizializzazione per impostare lo stato iniziale
        updateInfoFields();

        // Aggiungere l'evento 'change' a tutti i radio buttons
        radioInputs.forEach(function(radio) {
            radio.addEventListener('change', function() {
                updateInfoFields();
            });
        });
    });
</script>

<script>
    function toggleDimensions() {
        const checkBox = document.getElementById('activate_dimensions');
        const dimensionFields = document.getElementById('dimension_fields');
        const widthInput = document.getElementById('width');
        const heightInput = document.getElementById('height');

        if (checkBox.checked) {
            dimensionFields.style.display = 'block';
        } else {
            dimensionFields.style.display = 'none';
            // Cancella il contenuto di larghezza e altezza se il check è deselezionato
            widthInput.value = '';
            heightInput.value = '';
        }
    }
</script>
@endsection