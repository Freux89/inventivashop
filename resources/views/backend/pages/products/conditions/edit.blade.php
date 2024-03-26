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

                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-4">

            <!--left sidebar-->
            <div class="col-xl-12 order-2 order-md-2 order-lg-2 order-xl-1">
                <form action="{{ route('admin.conditions.update',['id' => $conditionGroup->id])  }}" method="POST" class="pb-650" id="material-form">
                    @csrf
                    <!--basic information start-->

                    <!--basic information end-->

                    <div class="card mb-4 ">
                        <div class="card-body ">
                            <h5 class="mb-4">{{$conditionGroup->product->name}}</h5>

                            <input type="radio" style="display:none;" name="products" value="{{$conditionGroup->product_id}}" checked>


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
                                $variations = app('App\Http\Controllers\Backend\Products\ConditionGroupController')->getVariationsArray($conditionGroup->product_id);
                                @endphp
                                @foreach($conditionGroup->conditions as $conditionIndex => $condition)
                                @include('backend.pages.partials.conditions.conditionVariantSelect', [
                                'condition' => $condition,
                                'conditionIndex' => $conditionIndex,
                                'variations' => $variations, // Assicurati che questa variabile contenga tutte le varianti disponibili
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
    var variantsUrl = "{{ route('admin.product.variations') }}";
    var variantValuesUrl = "{{ route('admin.product.variant.values') }}";
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

<script src="{{ staticAsset('backend/assets/js/conditions.js') }}"></script>


@endsection