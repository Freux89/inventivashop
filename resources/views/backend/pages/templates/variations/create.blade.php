@extends('backend.layouts.master')

@section('title')
    {{ localize('Aggiungi Template Varianti') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-lg-0">{{ localize('Aggiungi Template Varianti') }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4 g-4">
                <div class="col-12 order-2 order-md-2 order-lg-2 order-xl-1">
                    <form action="{{ route('admin.templates.variations.store') }}" method="POST" class="pb-650" id="template-variation-form">
                        @csrf

                        <!-- Template Name -->
                        <div class="card mb-4" id="section-1">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="template_name" class="form-label">{{ localize('Nome Template') }}</label>
                                    <input type="text" id="template_name" name="name" placeholder="{{ localize('Nome del Template') }}" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <!-- Variations Section Start -->
                        <div class="card mb-4" id="section-5">
                            <div class="card-body">
                                @if (count($variations) > 0)
                                    <h5 class="mb-4 mt-2">{{ localize('Varianti') }}</h5>
                                    <div class="row g-3">
                                        <div class="col-lg-6">
                                            <div class="mb-0">
                                                <label class="form-label">{{ localize('Select Variations') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-0">
                                                <label class="form-label">{{ localize('Seleziona Valore') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chosen_variation_options">
                                        <div class="row g-3">
                                            <div class="col-lg-6">
                                                <div class="mb-0">
                                                    <select class="form-select select2" onchange="getVariationValues(this)" name="chosen_variations[]">
                                                        <option value="">{{ localize('Select a Variation') }}</option>
                                                        @foreach ($variations as $variation)
                                                            <option value="{{ $variation->id }}">{{ $variation->collectLocalization('name') }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-0">
                                                    <div class="variationvalues">
                                                        <input type="text" class="form-control" placeholder="{{ localize('Select variation values') }}" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-4">
                                                <button class="btn btn-link px-0 fw-medium fs-base" type="button" onclick="addAnotherVariation()">
                                                    <i data-feather="plus" class="me-1"></i>
                                                    {{ localize('Aggiungi un’altra Variante') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="variation_combination" id="variation_combination">
                                    {{-- Combinazioni verranno aggiunte qui tramite risposta AJAX --}}
                                </div>
                            </div>
                        </div>
                        <!-- Variations Section End -->

                        <!-- Submit Button -->
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-4">
                                    <button class="btn btn-primary" type="submit">
                                        <i data-feather="save" class="me-1"></i> {{ localize('Salva Template Varianti') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Submit Button End -->

                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    @include('backend.inc.product-scripts') 
@endsection
