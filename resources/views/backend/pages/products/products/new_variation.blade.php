<div class="row g-3 mt-2">
    <div class="col-lg-6">
        <div class="mb-0">
            <select class="form-select select2" onchange="getVariationValues(this)" name="chosen_variations[]">
                <option value="">{{ localize('Select a Variation') }}
                </option>
                @foreach ($variations as $key => $variation)
                    <option value="{{ $variation->id }}">
                        {{ $variation->collectLocalization('name') }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="d-flex">
            <div class="row flex-grow-1">
                <div class="variationvalues">
                    <input type="text" class="form-control"
                        placeholder="{{ localize('Select variation values') }}" />
                </div>
            </div>

            <button type="button" data-toggle="remove-parent" class="btn btn-link px-2" data-parent=".row">
                <i data-feather="trash-2" class="text-danger"></i>
            </button>
        </div>
        <span class="text-danger fw-medium fs-xs">
            {{ localize('Before clicking on delete button, clear the selected variations if selected') }}
        </span>
    </div>

</div>
