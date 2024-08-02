@extends('backend.layouts.master')

@section('title')
{{ localize('Aggiungi Livello di Sconto') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
<section class="tt-section pt-4">
    <div class="container">
    <div class="row mb-3">
    <div class="col-12">
        <div class="card tt-page-header">
            <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                <div class="tt-page-title">
                    <h2 class="h5 mb-lg-0">{{ localize('Aggiungi Livello di Sconto') }}</h2>
                </div>
                <div>
                    <a href="{{ route('quantity_discounts.edit', $quantityDiscount->id) }}" class="btn btn-link">
                        <i class="fas fa-arrow-left"></i> Torna allo sconto quantità
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


        <div class="row mb-4 g-4">
            <div class="col-xl-12">
                <form action="{{ route('quantity_discounts.tiers.store', $quantityDiscount->id) }}" method="POST" class="pb-650">
                    @csrf
                    <!-- Informazioni di base -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Informazioni del Tier') }}</h5>

                            <div class="mb-4">
                                <label for="min_quantity" class="form-label">{{ localize('Quantità Minima') }}</label>
                                <input class="form-control" type="number" id="min_quantity" name="min_quantity" placeholder="{{ localize('Digita la quantità minima') }}" required>
                                <span class="fs-sm text-muted">{{ localize('La quantità minima è obbligatoria.') }}</span>
                            </div>

                            <div class="mb-4">
                                <label for="discount_percentage" class="form-label">{{ localize('Percentuale di Sconto') }}</label>
                                <input class="form-control" type="number" id="discount_percentage" name="discount_percentage" step="0.01" placeholder="{{ localize('Digita la percentuale di sconto') }}" required>
                                <span class="fs-sm text-muted">{{ localize('La percentuale di sconto è obbligatoria.') }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- Informazioni di base end -->

                    <!-- Submit button -->
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-4">
                                <button class="btn btn-primary" type="submit">
                                    <i data-feather="save" class="me-1"></i> {{ localize('Salva') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Submit button end -->
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
