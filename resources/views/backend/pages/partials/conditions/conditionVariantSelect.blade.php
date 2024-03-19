
@php
if(isset($condition)){
$productVariation = App\Models\ProductVariation::find($condition->product_variation_id);
$variationKeys = explode(':', rtrim($productVariation->variation_key, '/'));
$selectedVariantId = $variationKeys[0];
$values = app('App\Http\Controllers\Backend\Products\ConditionGroupController')->getVariantValuesArray($productId, $selectedVariantId);
$selectedValueId = $condition->product_variation_id;
}

@endphp

<div class="card condition-div mb-3" data-condition-index="{{ $conditionIndex }}">
    <div class="card-header" id="heading{{ $conditionIndex }}">
        <h5 class="mb-0">
            <button class="btn btn-link w-100 text-start" data-bs-toggle="collapse" type="button" data-bs-target="#collapse{{ $conditionIndex }}" aria-expanded="true" aria-controls="collapse{{ $conditionIndex }}">
                Condizione {{ $conditionIndex + 1 }} 
                <i class="fas fa-trash float-end ms-3 delete-condition" style="cursor:pointer;" title="Elimina condizione"></i>
                <i class="fas @if(!isset($selectedValueId)) fa-chevron-up @else fa-chevron-down @endif float-end"></i>
            </button>

        </h5>
    </div>

    <div id="collapse{{ $conditionIndex }}" class="collapse @if(!isset($selectedValueId)) show @endif" aria-labelledby="heading{{ $conditionIndex }}" data-parent="#conditionFields">
        <div class="card-body">
            <div class="condition-definition">
                <div class="row">
                    <div class="col-6">
                        <label>Quando: </label>
                        <select class="form-control variant-select" name="condition[{{ $conditionIndex }}][variant]" required>
                            <option value="">Seleziona una variante</option>
                            @foreach($variations as $variant)
                            <option value="{{ $variant['id'] }}" @if($variant['id']==$selectedVariantId) selected @endif>{{ $variant['variation_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if(isset($condition))


                    @include('backend.pages.partials.conditions.conditionVariantValueSelect', [
                    'conditionIndex' => $conditionIndex,
                    'values' => $values,
                    'selectedValueId' => $selectedValueId
                    ])

                    @endif
                </div>
            </div>
            <div class="condition-action p-4 mt-2" @if(!isset($condition)) style="display:none" @endif>
                @if(isset($condition))
                @forelse($condition->actions as $actionIndex => $action)
                @php
                $productVariation = $action->productVariations->first();
                $variationKeys = explode(':', rtrim($productVariation->variation_key, '/'));
                $selectedVariantId = $variationKeys[0];
                $values = app('App\Http\Controllers\Backend\Products\ConditionGroupController')->getVariantValuesArray($productId, $selectedVariantId);
                $selectedValuesId = $action->productVariations->pluck('id');
                @endphp
                @include('backend.pages.partials.conditions.actionVariantSelect', [
                    'actionIndex' => $actionIndex,
                    'conditionIndex' => $conditionIndex,
                    'selectedVariantId' => $selectedVariantId,
                    'variations' => $variations,
                    'action' => $action,
                    'values' => $values,
                    'selectedValuesId' => $selectedValuesId
                ])

                

                @empty

                @endforelse
                @endif
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <button type="button" class="btn btn-add-shutdown bg-white mt-3" @if(!isset($condition)) style="display:none;" @endif>+ Aggiungi azione</button>
                </div>
            </div>
        </div>
    </div>
</div>