@extends('backend.layouts.master')

@section('title')
{{ localize('Aggiorna Materiale') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
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
                                        <h2 class="h5 mb-0">{{ localize('Update Product') }} <sup
                                                class="badge bg-soft-warning px-2">{{ $lang_key }}</sup></h2>
                                    </div>
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
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">{{ localize('Modifica materiale') }}</h2>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-4">

            <!--left sidebar-->
            <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">
                <form action="{{ route('admin.materials.update') }}" method="POST" class="pb-650" id="material-form">
                    @csrf

                    <input type="hidden" name="id" value="{{ $material->id }}">
                    <input type="hidden" name="lang_key" value="{{ $lang_key }}">
                    <!--basic information start-->
                    <div class="card mb-4" id="section-1">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Basic Information') }}</h5>

                            <div class="mb-4">
                                <label for="name" class="form-label">{{ localize('Nome materiale') }}</label>
                                <input class="form-control" type="text" id="name" placeholder="{{ localize('Digita il nome del materiale') }}" name="name" value="{{ $material->collectLocalization('name', $lang_key) }}" required>
                                <span class="fs-sm text-muted">
                                    {{ localize('Il nome del materiale è obbligatorio e si consiglia di renderlo unico.') }}
                                </span>
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label">{{ localize('Description') }}</label>
                                <textarea id="description" class="editor" name="description">{{ $material->collectLocalization('description', $lang_key) }}</textarea>
                            </div>

                        </div>
                    </div>
                    <!--basic information end-->
                    @if (env('DEFAULT_LANGUAGE') == $lang_key)
                    <!--material image and texture-->
                    <div class="card mb-4" id="section-2">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Images') }}</h5>
                            <div class="mb-4">
                                <label class="form-label">{{ localize('Thumbnail') }} (592x592)</label>
                                <div class="tt-image-drop rounded">
                                    <span class="fw-semibold">{{ localize('Scegli la miniatura del materiale') }}</span>
                                    <!-- choose media -->
                                    <div class="tt-product-thumb show-selected-files mt-3">
                                        <div class="avatar avatar-xl cursor-pointer choose-media" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" onclick="showMediaManager(this)" data-selection="single">
                                            <input type="hidden" name="thumbnail_image" value="{{ $material->thumbnail_image }}">
                                            <div class="no-avatar rounded-circle">
                                                <span><i data-feather="plus"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- choose media -->
                                </div>
                            </div>

                        </div>
                    </div>



                    <!--material price and type price-->
                    <div class="card mb-4" id="section-5">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-4">{{ localize('Prezzo') }}</h5>

                            </div>

                            <div class="row g-3">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">{{ localize('Price') }}</label>
                                        <input type="number" min="0" step="0.0001" id="price" name="price" placeholder="{{ localize('Prezzo materiale') }}" class="form-control" value="{{$material->price}}" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="stock" class="form-label">{{ localize('Tipo di calcolo') }}</label>

                                        <select class="select2 form-control" id="price_type" name="price_type">
                                            <option value="mq" {{ $material->price_type == 'mq' ? 'selected' : '' }}>{{ localize('mq') }}</option>
                                            <option value="linear" {{ $material->price_type == 'linear' ? 'selected' : '' }}>{{ localize('Metro lineare') }}</option>
                                            <option value="fixed" {{ $material->price_type == 'fixed' ? 'selected' : '' }}>{{ localize('fixed') }}</option>
                                        </select>

                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    @endif
                    <!-- submit button -->
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-4">
                                <button class="btn btn-primary" type="submit">
                                    <i data-feather="save" class="me-1"></i> {{ localize('Salva') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- submit button end -->

                </form>
            </div>

            <!--right sidebar-->
            <div class="col-xl-3 order-1 order-md-1 order-lg-1 order-xl-2">
                <div class="card tt-sticky-sidebar">
                    <div class="card-body">
                        <h5 class="mb-4">{{ localize('Informazioni materiale') }}</h5>
                        <div class="tt-vertical-step">
                            <ul class="list-unstyled">
                                <li>
                                    <a href="#section-1" class="active">{{ localize('Basic Information') }}</a>
                                </li>
                                <li>
                                    <a href="#section-2">{{ localize('Miniatura immagine') }}</a>
                                </li>
                                <li>
                                    <a href="#section-5">{{ localize('Prezzo') }}</a>
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
@endsection