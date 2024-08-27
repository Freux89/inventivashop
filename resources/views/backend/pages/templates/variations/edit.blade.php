@extends('backend.layouts.master')

@section('title')
{{ localize('Modifica Template Varianti') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
<section class="tt-section pt-4">
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                    <div class="col-auto flex-grow-1">
                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">{{ localize('Modifica Template Varianti') }}</h2>
                        </div>
</div>
<div class="col-auto">
                        <a href="{{ route('admin.templates.variations.index') }}" class="btn btn-link">
                            <i class="fas fa-arrow-left"></i> Torna all'elenco
                        </a>
                    </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-4">
            <div class="col-12 order-2 order-md-2 order-lg-2 order-xl-1">
                <form action="{{ route('admin.templates.variations.update', $template->id) }}" method="POST" class="pb-650" id="template-variation-form">
                    @csrf
                   

                    <!-- Template Name -->
                    <div class="card mb-4" id="section-1">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="template_name" class="form-label">{{ localize('Nome Template') }}</label>
                                <input type="text" id="template_name" name="name" value="{{ $template->name }}" placeholder="{{ localize('Nome del Template') }}" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4" id="section-2">
    <div class="card-body">
        <h5 class="mb-4">{{ localize('Associa Template Condizioni') }}</h5>
        <div class="mb-3">
            <select class="select2 form-control" id="condition_group_id" name="condition_group_id">
                <option value="">{{ localize('Seleziona un template condizione') }}</option>
                @foreach ($conditionGroups as $conditionGroup)
                    <option value="{{ $conditionGroup->id }}" {{ $template->condition_group_id == $conditionGroup->id ? 'selected' : '' }}>
                        {{ $conditionGroup->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
                    <!-- Variations Section Start -->
                    <div class="card mb-4" id="section-5">
                        <div class="card-body">
                            @if (count($variations) > 0)
                            <h5 class="mb-4 mt-2">{{ localize('Varianti') }}</h5>
                            <div class="row g-3">

                                @foreach (generateVariationOptions($template->ordered_variation_combinations) as $key => $combination)
                                <div class="row g-3 mb-2">
                                    <div class="col-lg-6">
                                        <div class="variation-names">
                                            <input class="productVariation form-control bg-secondary" value="{{ $combination['name'] }}" disabled />
                                            <input type="hidden" name="chosen_variations[]" value="{{ $combination['id'] }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="variationvalues">
                                            @php
                                            $variation_values = \App\Models\VariationValue::where('variation_id', $combination['id'])->get();
                                            $old_val = array_map(function ($val) {
                                            return $val['id'];
                                            }, $combination['values']);
                                            @endphp

                                            <div class="d-flex">
                                                <div class="w-100">
                                                    <select class="form-control select2" data-toggle="select2" name="option_{{ $combination['id'] }}_choices[]" multiple onchange="generateVariationCombinations()">
                                                        @foreach ($variation_values as $variation_value)
                                                        <option value="{{ $variation_value->id }}" {{ in_array($variation_value->id, $old_val) ? 'selected' : '' }}>
                                                            {{ $variation_value->collectLocalization('name') }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <button type="button" data-toggle="remove-parent" class="btn btn-link px-2" data-parent=".row" onclick="generateVariationCombinations({{$combination['id']}})">
                                                    <i data-feather="trash-2" class="text-danger"></i>
                                                </button>
                                            </div>

                                            @if ($loop->last)
                                            <span class="text-danger fw-medium fs-xs first-info">
                                                {{ localize('Before clicking on delete button, clear the selected variations if selected') }}
                                            </span>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                @endforeach




                            </div>
                            <div class="chosen_variation_options">

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
                                @include(
                                'backend.pages.products.products.update_variation_combinations',
                                [
                                'variations' => $template->ordered_variations,
                                ]
                                )
                            </div>
                        </div>
                    </div>
                    <!-- Variations Section End -->

                    <!-- Submit Button -->
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-4">
                                <button class="btn btn-primary" type="submit">
                                    <i data-feather="save" class="me-1"></i> {{ localize('Aggiorna Template Varianti') }}
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