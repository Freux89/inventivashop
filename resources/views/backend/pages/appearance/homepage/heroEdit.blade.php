@extends('backend.layouts.master')

@section('title')
{{ localize('Website Homepage Configuration') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection
@section('extra-head')
<style>
    .note-editable font[color="#ffffff"] {
    color: #ccc;
}
</style>
@endsection
@section('contents')
<section class="tt-section pt-4">
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">{{ localize('Update Slider') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-4">
            <!--left sidebar-->
            <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">

                <form action="{{ route('admin.appearance.homepage.updateHero') }}" method="POST" enctype="multipart/form-data" id="section-1">
                    @csrf
                    <input type="hidden" name="id" value="{{ $id }}">
                    @php
                    $slider = null;
                    if (!empty($sliders)) {
                    foreach ($sliders as $key => $thisSlider) {
                    if ($thisSlider->id == $id) {
                    $slider = $thisSlider;
                    }
                    }
                    }
                    @endphp

                    <div class="card mb-4">
                        <div class="card-body">
  <!-- Disposizione delle colonne -->
  <h5>{{ localize('Disposizione delle colonne') }}</h5>
        <div class="mb-3">
            <label class="form-label">{{ localize('Seleziona la larghezza delle colonne per immagine e testo') }}</label>
            <select name="column_layout" class="form-control">
                <option value="6-6" {{ isset($slider->column_layout) && $slider->column_layout === '6-6' ? 'selected' : '' }}>
                    {{ localize('Immagine 50%, Testo 50% (6-6)') }}
                </option>
                <option value="8-4" {{ isset($slider->column_layout) && $slider->column_layout === '8-4' ? 'selected' : '' }}>
                    {{ localize('Immagine 66%, Testo 33% (8-4)') }}
                </option>
                <option value="4-8" {{ isset($slider->column_layout) && $slider->column_layout === '4-8' ? 'selected' : '' }}>
                    {{ localize('Immagine 33%, Testo 66% (4-8)') }}
                </option>
                <option value="7-5" {{ isset($slider->column_layout) && $slider->column_layout === '7-5' ? 'selected' : '' }}>
                    {{ localize('Immagine 58%, Testo 42% (7-5)') }}
                </option>
                <option value="5-7" {{ isset($slider->column_layout) && $slider->column_layout === '5-7' ? 'selected' : '' }}>
                    {{ localize('Immagine 42%, Testo 58% (5-7)') }}
                </option>
            </select>
        </div>
        <div class="col-12">
            <small class="text-muted">
                {{ localize('Scegli come distribuire lo spazio tra immagine e testo. Le combinazioni più comuni sono 6-6 (50% testo, 50% immagine) oppure 8-4 (66% immagine, 33% testo).') }}
            </small>
        </div>

                            <!-- Stile Box del Testo -->
                            <h5>{{ localize('Stile del box di testo') }}</h5>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">{{ localize('Colore di sfondo / Colore 1') }}</label>
                                    <x-color-picker id="box_background_color" name="box_style[background_color]" value="{{ $slider->box_style->background_color ?? '' }}" label="{{ localize('Colore di sfondo') }}" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ localize('Colore 2 (Opzionale per sfumatura radiale)') }}</label>
                                    <x-color-picker id="box_gradient_color2" name="box_style[gradient_color2]" value="{{ $slider->box_style->gradient_color2 ?? '' }}" label="{{ localize('Colore 2') }}" />
                                </div>
                                <div class="col-12">
                                    <small class="text-muted">
                                        {{ localize('Per un singolo colore, inserisci lo stesso colore in entrambi i campi. Se inserisci un secondo colore diverso, verrà creata una sfumatura radiale.') }}
                                    </small>
                                </div>
                            </div>


                            <!-- Sottotitolo -->
                            <h5>{{ localize('Impostazioni sottotitolo') }}</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sub_title" class="form-label">{{ localize('Sottotitolo') }}</label>
                                        <input type="text" name="sub_title" id="sub_title" placeholder="{{ localize('Inserisci sottotitolo') }}" class="form-control" value="{{ $slider->sub_title }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Stili per il sottotitolo -->
                                    <div class="mb-3">
                                        <label class="form-label">{{ localize('Stile sottotitolo') }}</label>
                                        <div class="row">
                                            <div class="col-6">
                                                <input type="number" name="sub_title_style[font_size]" class="form-control" placeholder="{{ localize('Dimensione font') }}" value="{{ $slider->sub_title_style->font_size ?? '' }}">
                                            </div>
                                            <div class="col-6 d-flex align-items-center">
                                                <input type="checkbox" name="sub_title_style[is_bold]" class="me-2" {{ $slider->sub_title_style->is_bold ?? false ? 'checked' : '' }}>
                                                <label class="form-check-label">{{ localize('Grassetto') }}</label>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-6">
                                                <select name="sub_title_style[tag]" class="form-control">
                                                    <option value="h1" {{ $slider->sub_title_style->tag === 'h1' ? 'selected' : '' }}>h1</option>
                                                    <option value="h2" {{ $slider->sub_title_style->tag === 'h2' ? 'selected' : '' }}>h2</option>
                                                    <option value="h3" {{ $slider->sub_title_style->tag === 'h3' ? 'selected' : '' }}>h3</option>
                                                    <option value="h4" {{ $slider->sub_title_style->tag === 'h4' ? 'selected' : '' }}>h4</option>
                                                    <option value="h5" {{ $slider->sub_title_style->tag === 'h5' ? 'selected' : '' }}>h5</option>
                                                    <option value="h6" {{ $slider->sub_title_style->tag === 'h6' ? 'selected' : '' }}>h6</option>
                                                    <option value="p" {{ $slider->sub_title_style->tag === 'p' ? 'selected' : '' }}>p</option>
                                                    <option value="div" {{ $slider->sub_title_style->tag === 'div' ? 'selected' : '' }}>div</option>
                                                    <option value="span" {{ $slider->sub_title_style->tag === 'span' ? 'selected' : '' }}>span</option>
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <x-color-picker id="subTitleColor" name="sub_title_style[color]" value="{{ $slider->sub_title_style->color ?? '' }}" label="{{ localize('Colore') }}" />
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-6">
                                                <input type="number" name="sub_title_style[margin_top]" class="form-control" placeholder="{{ localize('Margine superiore') }}" value="{{ $slider->sub_title_style->margin_top ?? '' }}">
                                            </div>
                                            <div class="col-6">
                                                <input type="number" name="sub_title_style[margin_bottom]" class="form-control" placeholder="{{ localize('Margine inferiore') }}" value="{{ $slider->sub_title_style->margin_bottom ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Titolo -->
                            <h5>{{ localize('Impostazioni titolo') }}</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">{{ localize('Titolo') }}</label>
                                        <input type="text" name="title" id="title" placeholder="{{ localize('Inserisci titolo') }}" class="form-control" value="{{ $slider->title }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Stili per il titolo -->
                                    <div class="mb-3">
                                        <label class="form-label">{{ localize('Stile titolo') }}</label>
                                        <div class="row">
                                            <div class="col-6">
                                                <input type="number" name="title_style[font_size]" class="form-control" placeholder="{{ localize('Dimensione font') }}" value="{{ $slider->title_style->font_size ?? '' }}">
                                            </div>
                                            <div class="col-6 d-flex align-items-center">
                                                <input type="checkbox" name="title_style[is_bold]" class="me-2" {{ $slider->title_style->is_bold ?? false ? 'checked' : '' }}>
                                                <label class="form-check-label">{{ localize('Grassetto') }}</label>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-6">
                                                <select name="title_style[tag]" class="form-control">
                                                    <option value="h1" {{ $slider->title_style->tag === 'h1' ? 'selected' : '' }}>h1</option>
                                                    <option value="h2" {{ $slider->title_style->tag === 'h2' ? 'selected' : '' }}>h2</option>
                                                    <option value="h3" {{ $slider->title_style->tag === 'h3' ? 'selected' : '' }}>h3</option>
                                                    <option value="h4" {{ $slider->title_style->tag === 'h4' ? 'selected' : '' }}>h4</option>
                                                    <option value="h5" {{ $slider->title_style->tag === 'h5' ? 'selected' : '' }}>h5</option>
                                                    <option value="h6" {{ $slider->title_style->tag === 'h6' ? 'selected' : '' }}>h6</option>
                                                    <option value="p" {{ $slider->title_style->tag === 'p' ? 'selected' : '' }}>p</option>
                                                    <option value="div" {{ $slider->title_style->tag === 'div' ? 'selected' : '' }}>div</option>
                                                    <option value="span" {{ $slider->title_style->tag === 'span' ? 'selected' : '' }}>span</option>
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <x-color-picker id="titleColor" name="title_style[color]" value="{{ $slider->title_style->color ?? '' }}" label="{{ localize('Colore') }}" />
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-6">
                                                <input type="number" name="title_style[margin_top]" class="form-control" placeholder="{{ localize('Margine superiore') }}" value="{{ $slider->title_style->margin_top ?? '' }}">
                                            </div>
                                            <div class="col-6">
                                                <input type="number" name="title_style[margin_bottom]" class="form-control" placeholder="{{ localize('Margine inferiore') }}" value="{{ $slider->title_style->margin_bottom ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Testo -->
                            <div class="mb-3">
                                <label for="text" class="form-label">{{ localize('Testo') }}</label>
                                <textarea name="text" id="text" class="form-control editor" placeholder="{{ localize('Inserisci testo') }}">{{ $slider->text }}</textarea>
                            </div>

                            <!-- Link -->
                            <h5>{{ localize('Impostazioni link') }}</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="link" class="form-label">{{ localize('Link') }}</label>
                                        <input type="url" name="link" id="link" placeholder="{{ env('APP_URL') }}/example" class="form-control" value="{{ $slider->link }}">
                                        <label for="link_text" class="form-label mt-2">{{ localize('Testo pulsante') }}</label>
                                        <input type="text" name="link_text" class="form-control" placeholder="{{ localize('Testo del link') }}" value="{{ $slider->link_text ?? '' }}">
                                        <label for="link_title" class="form-label mt-2">{{ localize('Titolo link') }}</label>
                                        <input type="text" name="link_title" class="form-control" placeholder="{{ localize('Titolo del link') }}" value="{{ $slider->link_title ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Stili per il link -->
                                    <div class="mb-3">
                                        <label class="form-label">{{ localize('Stile link') }}</label>
                                        <input type="number" name="link_style[font_size]" class="form-control mb-2" placeholder="{{ localize('Dimensione font') }}" value="{{ $slider->link_style->font_size ?? '' }}">
                                        <x-color-picker id="buttonTextColor" name="link_style[button_color]" value="{{ $slider->link_style->button_color ?? '' }}" label="{{ localize('Colore pulsante') }}" />
                                    </div>
                                </div>
                            </div>

                            <!-- Immagine dello slider -->
                            <div class="mb-3">
                                <label class="form-label">{{ localize('Immagine dello slider') }}</label>
                                <div class="tt-image-drop rounded">
                                    <span class="fw-semibold">{{ localize('Scegli immagine dello slider') }}</span>
                                    <div class="tt-product-thumb show-selected-files mt-3">
                                        <div class="avatar avatar-xl cursor-pointer choose-media" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" onclick="showMediaManager(this)" data-selection="single">
                                            <input type="hidden" name="image" value="{{ $slider->image }}">
                                            <div class="no-avatar rounded-circle">
                                                <span><i data-feather="plus"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Save button -->
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-4">
                                <button class="btn btn-primary" type="submit">
                                    <i data-feather="save" class="me-1"></i> {{ localize('Salva modifiche') }}
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
                        <h5 class="mb-4">{{ localize('Hero Section Configuration') }}</h5>
                        <div class="tt-vertical-step">
                            <ul class="list-unstyled">
                                <li>
                                    <a href="#section-1" class="active">{{ localize('Update Slider') }}</a>
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