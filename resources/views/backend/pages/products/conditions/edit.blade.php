@extends('backend.layouts.master')

@section('title')
{{ localize('Modifica Condizioni Prodotto') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection


@section('contents')
<section class="tt-section pt-4">
    <div class="container">
    <div class="row mb-3">
    <div class="col-12">
        <div class="card tt-page-header">
            <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                <div class="tt-page-title">
                    <h2 class="h5 mb-lg-0">{{ localize('Modifica Condizioni Prodotto') }}</h2>
                </div>
                <div>
                    <a href="{{ route('admin.conditions.index') }}" class="btn btn-link">
                        <i class="fas fa-arrow-left"></i> Torna all'elenco
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


        <div class="row mb-4 g-4">

            <!--left sidebar-->
            <div class="col-xl-12 order-2 order-md-2 order-lg-2 order-xl-1">
                <form action="{{ route('admin.conditions.update',['id' => $conditionGroup->id])  }}" method="POST" class="pb-650" id="conditionGroupForm">
                    @csrf
                    <!--basic information start-->

                    <!--basic information end-->

                    <div class="card mb-4">
    <div class="card-body">
        <h5 class="mb-4">{{ localize('Nome Condizione Gruppo') }}</h5>
        <div class="mb-3">
            <input type="text" name="name" placeholder="{{ localize('Inserisci il nome della condizione gruppo...') }}" class="form-control" value="{{ $conditionGroup->name }}" required>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <h5 class="mb-4">{{ localize('Vuoi associare questa condizione gruppo a un prodotto o salvarla come template?') }}</h5>

        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="group_type" id="associateProduct" value="product" {{ $conditionGroup->product_id ? 'checked' : '' }}>
                <label class="form-check-label" for="associateProduct">
                    {{ localize('Associare a un prodotto') }}
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="group_type" id="createTemplate" value="template" {{ is_null($conditionGroup->product_id) ? 'checked' : '' }}>
                <label class="form-check-label" for="createTemplate">
                    {{ localize('Rendi questa condizione un template') }}
                </label>
            </div>
        </div>

        <div id="productSelection" style="{{ is_null($conditionGroup->product_id) ? 'display: none;' : '' }}">
            <h5 class="mb-4">{{ localize('Seleziona un prodotto') }}</h5>
            <div class="mb-3">
                <input type="text" id="searchProducts" placeholder="{{ localize('Cerca prodotti...') }}" class="form-control">
            </div>
            <div class="card-fixed-height" id="products">
                @foreach($products as $product)
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="products" id="product_{{ $product->id }}" value="{{ $product->id }}" {{ $conditionGroup->product_id == $product->id ? 'checked' : '' }}>
                        <label class="form-check-label" for="product_{{ $product->id }}">
                            {{ $product->name }}
                        </label>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>


                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="mb-4">
                                {{localize('Elenco condizioni')}}
                            </h5>
                            <!-- Dopo l'elenco dei prodotti -->


                            <div id="conditionFields">
    @php
    $variations = app('App\Http\Controllers\Backend\Products\ConditionGroupController')->getAllVariationsArray();
    @endphp
    @foreach($conditionGroup->conditions as $conditionIndex => $condition)
    @include('backend.pages.partials.conditions.conditionVariantSelect', [
    'condition' => $condition,
    'conditionIndex' => $conditionIndex,
    'variations' => $variations, // Questa variabile ora contiene tutte le varianti disponibili
    'productId' => $conditionGroup->product_id
    ])
    @endforeach
</div>
                            <div id="addConditionContainer" class="text-center col-12" style="margin-top: 20px;">
                                <button id="addConditionBtn" type="button" class="btn btn-secondary mt-3">+ Aggiungi condizione</button>
                            </div>
                        </div>
                    </div>


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
<script type="text/javascript">
    var variantsUrl = "{{ route('admin.conditions.variations') }}";
    var variantValuesUrl = "{{ route('admin.conditions.variant.values') }}";
    var conditions = @json($conditionGroup->conditions);

    var selectedVariantValues = [];
    var selectedActionVariants = {};

    conditions.forEach(function(condition, conditionIndex) {
        // Supponendo che ogni condizione abbia un array di `variantValues`
        selectedVariantValues[conditionIndex] = condition.product_variation_id.toString();

        // Preparare l'oggetto delle azioni per questa condizione
        selectedActionVariants[conditionIndex] = {};

        // Supponendo che ogni condizione abbia un array di `actions`
        condition.actions.forEach(function(action, actionIndex) {
        if (action.variant_id) {
            // Ottieni il variation_key della prima product_variation associata
            
            selectedActionVariants[conditionIndex][actionIndex] = action.variant_id.toString();
                
            
        }
    });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const associateProduct = document.getElementById('associateProduct');
        const createTemplate = document.getElementById('createTemplate');
        const productSelection = document.getElementById('productSelection');

        associateProduct.addEventListener('change', function() {
            if (this.checked) {
                productSelection.style.display = 'block';
            }
        });

        createTemplate.addEventListener('change', function() {
            if (this.checked) {
                productSelection.style.display = 'none';
            }
        });
    });
</script>

<script>
    document.getElementById('conditionGroupForm').addEventListener('submit', function(e) {
        var groupType = document.querySelector('input[name="group_type"]:checked').value;
        var wasLinkedToTemplate = '{{ $conditionGroup->template ? true : false }}';

        if (groupType === 'product' && wasLinkedToTemplate) {
            var confirmed = confirm("La condizione è attualmente collegata a un template. Se la associ a un prodotto, verrà dissociata dal template. Vuoi continuare?");
            if (!confirmed) {
                e.preventDefault(); // Interrompe il submit se l'utente non conferma
            }
        }
    });

    document.querySelectorAll('input[name="group_type"]').forEach(function(input) {
        input.addEventListener('change', function() {
            var productSelection = document.getElementById('productSelection');
            if (this.value === 'product') {
                productSelection.style.display = '';
            } else {
                productSelection.style.display = 'none';
            }
        });
    });
</script>
<script src="{{ staticAsset('backend/assets/js/conditions.js') }}"></script>


@endsection