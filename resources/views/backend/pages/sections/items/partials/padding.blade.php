<div class="col-md-6">
    <label for="columnPaddingY" class="form-label">{{ localize('Padding Verticale') }}</label>
    <select class="form-select" id="columnPaddingY" name="columnPaddingY">
        @for ($i = 0; $i <= 9; $i++)
            <option value="{{ $i }}" {{ isset($item->settings['columnPaddingY']) && $item->settings['columnPaddingY'] == $i ? 'selected' : '' }}>{{ $i }}</option>
        @endfor
    </select>
    <span class="fs-sm text-muted">{{ localize('Definisce lo spazio verticale all\'interno della colonna.') }}</span>
</div>

<div class="col-md-6">
    <label for="columnPaddingX" class="form-label">{{ localize('Padding Orizzontale') }}</label>
    <select class="form-select" id="columnPaddingX" name="columnPaddingX">
        @for ($i = 0; $i <= 9; $i++)
            <option value="{{ $i }}" {{ isset($item->settings['columnPaddingX']) && $item->settings['columnPaddingX'] == $i ? 'selected' : '' }}>{{ $i }}</option>
        @endfor
    </select>
    <span class="fs-sm text-muted">{{ localize('Definisce lo spazio orizzontale all\'interno della colonna.') }}</span>
</div>