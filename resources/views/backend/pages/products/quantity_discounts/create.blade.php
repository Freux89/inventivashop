@extends('backend.layouts.master')

@section('title')
{{ localize('Aggiungi Sconto per Quantità') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
<section class="tt-section pt-4">
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">{{ localize('Aggiungi Sconto per Quantità') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-4">
            <div class="col-xl-12">
                <form action="{{ route('quantity_discounts.store') }}" method="POST" class="pb-650">
                    @csrf
                    <!-- Informazioni di base -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Informazioni di Base') }}</h5>

                            <div class="mb-4">
                                <label for="name" class="form-label">{{ localize('Nome') }}</label>
                                <input class="form-control" type="text" id="name" placeholder="{{ localize('Digita il nome dello sconto') }}" name="name" required>
                                <span class="fs-sm text-muted">{{ localize('Il nome dello sconto è obbligatorio e si consiglia di renderlo unico.') }}</span>
                            </div>

                            <div class="mb-4">
                                <label for="status" class="form-label">{{ localize('Stato') }}</label>
                                <select name="status" class="form-control" required>
                                    <option value="1">{{ localize('Attivo') }}</option>
                                    <option value="0">{{ localize('Disattivato') }}</option>
                                </select>
                                <span class="fs-sm text-muted">{{ localize('Specifica se lo sconto è attivo o disattivato.') }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- Informazioni di base end -->

                    <!-- Associazione dei Prodotti -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('A quali prodotti vuoi applicare questo sconto?') }}</h5>
                            <div class="mb-3">
                                <input type="text" id="searchProducts" placeholder="Cerca prodotti..." class="form-control">
                            </div>
                            <div class="card-fixed-height" id="products">
                                @foreach($products as $product)
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="product_ids[]" id="product_{{ $product->id }}" value="{{ $product->id }}">
                                        <label class="form-check-label" for="product_{{ $product->id }}">
                                            {{ $product->name }}
                                            @if($product->quantityDiscounts->isNotEmpty())
                                                - <b class="text-success">{{ $product->quantityDiscounts->first()->name }}</b>
                                            @endif
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- Associazione dei Prodotti end -->

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

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById("searchProducts").addEventListener("keyup", function() {
            let input = this;
            let filter = input.value.toUpperCase();
            let productsContainer = document.getElementById("products");
            let productDivs = productsContainer.querySelectorAll(".mb-3");

            productDivs.forEach(function(productDiv) {
                let productLabel = productDiv.querySelector(".form-check-label");
                let productName = productLabel.textContent || productLabel.innerText;

                productDiv.style.display = productName.toUpperCase().includes(filter) ? "" : "none";
            });
        });
    });
</script>
@endsection