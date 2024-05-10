<div class="row mb-4">
        <div class="col-12">
            <strong>{{ localize('Titolo') }}</strong>
        </div>
        <div class="col-md-6">
            <label for="title" class="form-label">{{ localize('Titolo') }}</label>
            <input class="form-control" type="text" id="title" name="title" value="{{ isset($item->settings['title']) ? $item->settings['title'] : '' }}">
            <span class="fs-sm text-muted">{{ localize('Inserisci un titolo per la colonna.') }}</span>
        </div>
        @if($type !== 'card' && $section->type !== 'filtergrid')
        <div class="col-md-3">
            <label for="titleSize" class="form-label">{{ localize('Grandezza Titolo') }}</label>
            <input class="form-control" type="number" id="titleSize" name="titleSize" value="{{ isset($item->settings['titleSize']) ? $item->settings['titleSize'] : '' }}" min="10" max="72">
            <span class="fs-sm text-muted">{{ localize('Imposta la grandezza del titolo in px.') }}</span>
        </div>
        <div class="col-md-3">
            <label for="titleColor" class="form-label">{{ localize('Colore del Titolo') }}</label>
            <input class="form-control color-picker" type="color" id="titleColor" name="titleColor" value="{{ isset($item->settings['titleColor']) ? $item->settings['titleColor'] : '' }}">
            <span class="fs-sm text-muted">{{ localize('Scegli il colore del titolo.') }}</span>
        </div>
        
       @endif
    </div>