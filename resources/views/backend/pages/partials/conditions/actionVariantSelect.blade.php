<div class="row shutdown-action-div mt-3 p-4" data-action-index="{{ $actionIndex }}">
    <h6>Azione <i class="fas fa-trash delete-action float-end btn p-0" style="cursor:pointer;" title="Elimina azione"></i></h6>
    

    <div class="col-12">
    <label class="value-label">Seleziona variante da spegnere:</label>
    </div>
        <div class="col-6">
            <!-- Select per scegliere quale variante "spegnere" -->
            <select class="form-control shutdown-variant-select" name="condition[{{ $conditionIndex }}][action][{{ $actionIndex }}][shutdownVariant]" required>
                <option value="">Seleziona variante da spegnere</option>
                @foreach($variations as $variant)
                <option value="{{ $variant['id'] }}" {{ isset($selectedVariantId) ? ($selectedVariantId == $variant['id'] ? 'selected' : '') : '' }}>{{ $variant['variation_name'] }}</option>
                @endforeach
            </select>
        </div>
        @if(isset($selectedVariantId))
        @include('backend.pages.partials.conditions.actionVariantValueSelect', [
                    'actionIndex' => $actionIndex,
                    'conditionIndex' => $conditionIndex,
                    'values' => $values,
                    'selectedValuesId' => $selectedValuesId
        ])
    @endif
</div>