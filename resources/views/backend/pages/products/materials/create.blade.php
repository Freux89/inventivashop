@extends('backend.layouts.master')

@section('title')
{{ localize('Aggiungi Materiale') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
<section class="tt-section pt-4">
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">{{ localize('Aggiungi materiale') }}</h2>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-4">

            <!--left sidebar-->
            <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">
                <form action="{{ route('admin.materials.store') }}" method="POST" class="pb-650" id="material-form">
                    @csrf
                    <!--basic information start-->
                    <div class="card mb-4" id="section-1">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Basic Information') }}</h5>

                            <div class="mb-4">
                                <label for="name" class="form-label">{{ localize('Nome materiale') }}</label>
                                <input class="form-control" type="text" id="name" placeholder="{{ localize('Digita il nome del materiale') }}" name="name" required>
                                <span class="fs-sm text-muted">
                                    {{ localize('Il nome del materiale è obbligatorio e si consiglia di renderlo unico.') }}
                                </span>
                            </div>
                           
                            <div class="mb-4">
                                <label for="description" class="form-label">{{ localize('Description') }}</label>
                                <textarea id="description" class="editor" name="description"></textarea>
                            </div>

                        </div>
                    </div>
                    <!--basic information end-->

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
                                            <input type="hidden" name="thumbnail_image">
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
                                        <input type="number" min="0" step="0.0001" id="price" name="price" placeholder="{{ localize('Product price') }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="stock" class="form-label">{{ localize('Tipo di calcolo') }}</label>

                                        <select class="select2 form-control" id="price_type" name="price_type">
                                            <option value="mq">{{ localize('mq') }}</option>
                                            <option value="linear">{{ localize('linear') }}</option>
                                            <option value="fixed">{{ localize('fixed') }}</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        
                        </div> 
                    </div>

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
                        <h5 class="mb-4">{{ localize('Product Information') }}</h5>
                        <div class="tt-vertical-step">
                            <ul class="list-unstyled">
                                <li>
                                    <a href="#section-1" class="active">{{ localize('Basic Information') }}</a>
                                </li>
                                <li>
                                    <a href="#section-2">{{ localize('Product Images') }}</a>
                                </li>
                                <li>
                                    <a href="#section-3">{{ localize('Category') }}</a>
                                </li>
                                <li>
                                    <a href="#section-tags">{{ localize('Product tags') }}</a>
                                </li>
                                <li>
                                    <a href="#section-5">{{ localize('Prezzo, Quantità & Variazioni') }}</a>
                                </li>
                                <li>
                                    <a href="#section-6">{{ localize('Product Discount') }}</a>
                                </li>
                                <li>
                                    <a href="#section-8">{{ localize('Product Taxes') }}</a>
                                </li>

                                <li>
                                    <a href="#section-10">{{ localize('SEO Meta Options') }}</a>
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