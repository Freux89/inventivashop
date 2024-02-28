@extends('backend.layouts.master')

@section('title')
{{ localize('Modifica Lavorazione') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
<section class="tt-section pt-4">
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">{{ localize('Modifica lavorazione') }}</h2>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-4">

            <!--left sidebar-->
            <div class="col-xl-12 order-2 order-md-2 order-lg-2 order-xl-1">

                <form action="{{ route('admin.workflows.update', $workflow->id) }}" method="POST" class="pb-650" id="material-form">
                    @csrf
                    @method('POST') <!-- Aggiungi questo per specificare che si tratta di una richiesta PUT -->

                    <!-- Informazioni di base -->
                    <div class="card mb-4" id="section-1">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Informazioni di Base') }}</h5>

                            <div class="mb-4">
                                <label for="name" class="form-label">{{ localize('Nome') }}</label>
                                <input class="form-control" type="text" id="name" placeholder="{{ localize('Digita il nome della lavorazione') }}" name="name" value="{{ $workflow->name }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="duration" class="form-label">{{ localize('Durata Lavorazione (giorni)') }}</label>
                                <input class="form-control" type="number" id="duration" placeholder="{{ localize('Inserisci la durata in giorni') }}" name="duration" value="{{ $workflow->duration }}" required min="1">
                                <span class="fs-sm text-muted">
                                    {{ localize('Specifica la durata della lavorazione in giorni. Il valore deve essere un numero intero positivo.') }}
                                </span>
                            </div>

                            <!-- Resto del modulo omesso per brevità -->

                        </div>
                    </div>

                    <!-- Prodotti -->
                    <div class="card mb-4 ">
                        <div class="card-body ">
                            <h5 class="mb-4">{{ localize('A quali prodotti vuoi applicare questa lavorazione?') }}</h5>
                            <div class="mb-3">
                                <input type="text" id="searchProducts" placeholder="Cerca prodottii..." class="form-control">
                            </div>
                            <div class="card-fixed-height" id="products">
                            @foreach($products as $product)
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="products[]" id="product_{{ $product->id }}" value="{{ $product->id }}" {{ $workflow->products->contains($product->id) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="product_{{ $product->id }}">
                                        {{ $product->name }}
                                        @if($product->workflows->isNotEmpty())
                                            - <b class="text-success">{{ $product->workflows->first()->name }}</b>
                                            @endif
                                    </label>
                                </div>
                            </div>
                            @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- Varianti -->
                    <div class="card mb-4 ">
                        <div class="card-body ">
                            <h5 class="mb-4">{{ localize('A quali varianti vuoi applicare questa lavorazione?') }}</h5>
                            <div class="mb-3">
                                <input type="text" id="searchVariants" placeholder="Cerca varianti..." class="form-control">
                            </div>
                            <div class="card-fixed-height" id="variations">
                                @foreach($variations as $variation)
                                <div class="mb-3 ">
                                    <label class="form-label">{{ $variation->name }}</label>
                                    @foreach($variation->variationValues as $value)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="variation_values[]" id="variation_value_{{ $value->id }}" value="{{ $value->id }}" {{ $workflow->variationValues->contains($value->id) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="variation_value_{{ $value->id }}">
                                            {{ $value->name }} 
                                            @if($value->workflows->isNotEmpty())
                                            - <b class="text-success">{{ $value->workflows->first()->name }}</b>
                                            @endif
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                                @endforeach
                            </div>

                        </div>
                    </div>

                    <!-- Pulsante di invio -->
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-4">
                                <button class="btn btn-primary" type="submit">
                                    <i data-feather="save" class="me-1"></i> {{ localize('Salva Modifiche') }}
                                </button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
@endsection


@section('scripts')
@include('backend.inc.product-scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById("searchVariants").addEventListener("keyup", function() {
            let input = this;
            let filter = input.value.toUpperCase();
            let cardBody = document.getElementById("variations");
            let variants = cardBody.querySelectorAll(".mb-3");

            variants.forEach(function(variant) {
                let variantLabel = variant.querySelector(".form-label");
                let variantName = variantLabel.textContent || variantLabel.innerText;
                let values = variant.querySelectorAll(".form-check");
                let variantMatches = variantName.toUpperCase().includes(filter);

                let valueMatches = false;
                values.forEach(function(value) {
                    let valueLabel = value.querySelector(".form-check-label");
                    let valueText = valueLabel.textContent || valueLabel.innerText;

                    // Se il filtro corrisponde al nome della variante, mostra tutti i valori.
                    // Altrimenti, mostra solo i valori che corrispondono al filtro.
                    if (variantMatches || valueText.toUpperCase().includes(filter)) {
                        value.style.display = "";
                        valueMatches = true; // Imposta valueMatches a true se almeno un valore corrisponde
                    } else {
                        value.style.display = "none";
                    }
                });

                // Se il nome della variante corrisponde al filtro O se almeno un valore corrisponde, mostra la variante.
                variant.style.display = variantMatches || valueMatches ? "" : "none";
            });
        });
    });



    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById("searchProducts").addEventListener("keyup", function() {
            let input = this;
            let filter = input.value.toUpperCase();
            let productsContainer = document.getElementById("products");
            let productDivs = productsContainer.querySelectorAll(".mb-3"); // Seleziona direttamente i div dei prodotti

            productDivs.forEach(function(productDiv) {
                let productLabel = productDiv.querySelector(".form-check-label"); // Seleziona il label del prodotto
                let productName = productLabel.textContent || productLabel.innerText;

                // Mostra il prodotto se il nome corrisponde al filtro
                productDiv.style.display = productName.toUpperCase().includes(filter) ? "" : "none";
            });
        });
    });
</script>


@endsection