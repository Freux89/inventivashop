@extends('backend.layouts.master')

@section('title')
{{ localize('Aggiungi Lavorazione') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
<section class="tt-section pt-4">
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">{{ localize('Aggiungi lavorazione') }}</h2>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-4">

            <!--left sidebar-->
            <div class="col-xl-12 order-2 order-md-2 order-lg-2 order-xl-1">
                <form action="{{ route('admin.workflows.store') }}" method="POST" class="pb-650" id="material-form">
                    @csrf
                    <!--basic information start-->
                    <div class="card mb-4" id="section-1">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Basic Information') }}</h5>

                            <div class="mb-4">
                                <label for="name" class="form-label">{{ localize('Nome') }}</label>
                                <input class="form-control" type="text" id="name" placeholder="{{ localize('Digita il nome della lavorazione') }}" name="name" required>
                                <span class="fs-sm text-muted">
                                    {{ localize('Il nome della lavorazione è obbligatorio e si consiglia di renderlo unico.') }}
                                </span>
                            </div>

                            <div class="mb-4">
                                <label for="duration" class="form-label">{{ localize('Durata Lavorazione (giorni)') }}</label>
                                <input class="form-control" type="number" id="duration" placeholder="{{ localize('Inserisci la durata in giorni') }}" name="duration" required min="1">
                                <span class="fs-sm text-muted">
                                    {{ localize('Specifica la durata della lavorazione in giorni. Il valore deve essere un numero intero positivo.') }}
                                </span>
                            </div>
                            <div class="mb-4">
    <label for="quantity" class="form-label">{{ localize('Quantità per Aumento Durata') }}</label>
    <input class="form-control" type="number" id="quantity" placeholder="{{ localize('Inserisci la quantità per aumentare la durata') }}" name="quantity" required min="1" value="{{ old('quantity', $workflow->quantity ?? 1) }}">
    <span class="fs-sm text-muted">
        {{ localize('Specifica ogni quante unità di quantità deve aumentare la durata della lavorazione. Il valore deve essere un numero intero positivo.') }}
    </span>
</div>

<div class="mb-4">
    <label for="increase_duration" class="form-label">{{ localize('Aumento Durata (giorni)') }}</label>
    <input class="form-control" type="number" id="increase_duration" placeholder="{{ localize('Inserisci l\'aumento di durata in giorni') }}" name="increase_duration" required min="0" value="{{ old('increase_duration', $workflow->increase_duration ?? 0) }}">
    <span class="fs-sm text-muted">
        {{ localize('Specifica quanti giorni deve aumentare la durata della lavorazione per ogni quantità specificata. Il valore deve essere un numero intero.') }}
    </span>
</div>
                        </div>
                    </div>
                    <!--basic information end-->

<!-- Nuova Sezione per le Categorie -->
<div class="card mb-4 ">
    <div class="card-body ">
        <h5 class="mb-4">{{ localize('A quali categorie vuoi applicare questa lavorazione?') }}</h5>
        <div class="mb-3">
            <input type="text" id="searchCategories" placeholder="Cerca categorie..." class="form-control">
        </div>
        <div class="card-fixed-height" id="categories">
            @foreach($categories as $category)
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="categories[]" id="category_{{ $category->id }}" value="{{ $category->id }}">
                    <label class="form-check-label" for="category_{{ $category->id }}">
                        {{ $category->name }}
                        @if($category->workflows->isNotEmpty())
                                            - <b class="text-success">{{ $category->workflows->first()->name }}</b>
                                            @endif
                    </label>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

                    <div class="card mb-4 ">
                        <div class="card-body ">
                            <h5 class="mb-4">{{ localize('A quali prodotti vuoi applicare questa lavorazione?') }}</h5>
                            <div class="mb-3">
                                <input type="text" id="searchProducts" placeholder="Cerca prodottii..." class="form-control">
                            </div>
                            <div class="card-fixed-height" id="products">
                                @foreach($products as $product)
                                <div class="mb-3 ">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="products[]" id="product_{{ $product->id }}" value="{{ $product->id }}">
                                        <label class="form-check-label" for="variation_value_{{ $product->id }}">
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
                                        <input class="form-check-input" type="checkbox" name="variation_values[]" id="variation_value_{{ $value->id }}" value="{{ $value->id }}">
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


        document.getElementById("searchCategories").addEventListener("keyup", function() {
            let input = this;
            let filter = input.value.toUpperCase();
            let categoriesContainer = document.getElementById("categories");
            let categoryDivs = categoriesContainer.querySelectorAll(".mb-3");

            categoryDivs.forEach(function(categoryDiv) {
                let categoryLabel = categoryDiv.querySelector(".form-check-label");
                let categoryName = categoryLabel.textContent || categoryLabel.innerText;

                categoryDiv.style.display = categoryName.toUpperCase().includes(filter) ? "" : "none";
            });
        });
    });
</script>


@endsection