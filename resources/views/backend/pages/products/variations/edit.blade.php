@extends('backend.layouts.master')

@section('title')
{{ localize('Update Variation') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
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
                                    <h2 class="h5 mb-0">{{ localize('Update Variation') }} <sup class="badge bg-soft-warning px-2">{{ $lang_key }}</sup></h2>
                                </div>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('admin.variations.index') }}" class="btn btn-link">
                                    <i class="fas fa-arrow-left"></i> Torna all'elenco
                                </a>
                            </div>
                            <div class="col-4 col-md-2">
                                <select id="language" class="w-100 form-control text-capitalize country-flag-select" data-toggle="select2" onchange="localizeData(this.value)">
                                    @foreach (\App\Models\Language::all() as $key => $language)
                                    <option value="{{ $language->code }}" {{ $lang_key == $language->code ? 'selected' : '' }} data-flag="{{ staticAsset('backend/assets/img/flags/' . $language->flag . '.png') }}">
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
                <form action="{{ route('admin.variations.update') }}" method="POST" class="pb-650">
                    @csrf
                    <input type="hidden" name="id" value="{{ $variation->id }}">
                    <input type="hidden" name="lang_key" value="{{ $lang_key }}">
                    <!--basic information start-->
                    <div class="card mb-4" id="section-1">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Basic Information') }}</h5>

                            <div class="mb-4">
                                <label for="name" class="form-label">{{ localize('Variation Name') }}</label>
                                <input type="text" name="name" value="{{ $variation->collectLocalization('name', $lang_key) }}" id="name" placeholder="{{ localize('Variation name') }}" class="form-control" required>
                            </div>
                            <div class="mb-4">
                                <label for="alias" class="form-label">{{ localize('Alias') }}</label>
                                <input type="text" name="alias" value="{{ $variation->collectLocalization('alias', $lang_key) }}" id="alias" placeholder="{{ localize('Alias') }}" class="form-control">
                                <div><small class="form-text text-muted">{{ localize('Questo alias sarà visibile solo all\'interno della pagina prodotto e se non viene inserito verrà visualizzato il nome della variante.') }}</small></div>
                            </div>
                            <div class="mb-4">
                                <label for="display_type" class="form-label">{{ localize('Display Type') }}</label>
                                <select class="form-control" id="display_type" name="display_type" required>
                                    <option value="select" {{ $variation->display_type == 'select' ? 'selected' : '' }}>{{ localize('Campo Select') }}</option>
                                    <option value="image" {{ $variation->display_type == 'image' ? 'selected' : '' }}>{{ localize('Image') }}</option>
                                    <option value="color" {{ $variation->display_type == 'color' ? 'selected' : '' }}>{{ localize('Color') }}</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="replace_product_image" name="replace_product_image" {{ $variation->replace_product_image ? 'checked' : '' }}>
                                    <label class="form-check-label" for="replace_product_image">
                                        {{ localize('Sostituisci l\'immagine del prodotto con l\'immagine del valore variante al carrello') }}
                                    </label>
                                </div>
                                <small class="text-muted">{{ localize('Se attivato, l\'immagine del prodotto verrà sostituita con l\'immagine del valore variante selezionato, di questa variante, quando il prodotto è aggiunto al carrello.') }}</small>
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
                        <h5 class="mb-4">{{ localize('Variation Information') }}</h5>
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