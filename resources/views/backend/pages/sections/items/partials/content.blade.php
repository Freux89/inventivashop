<div class="card-body">
    <!-- Colonna -->
    <div class="row mb-4">
        <div class="col-12">
            <strong>{{ localize('Colonna') }}</strong>
        </div>
        @include('backend.pages.sections.items.partials.padding')
    </div>

    <!-- Titolo -->
    @include('backend.pages.sections.items.partials.title')
    <!-- Separatore titolo -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <label for="titleSeparator" class="form-label">{{ localize('Linea sotto al titolo') }}</label>
            <div class="form-check form-switch">
                <input type="checkbox" class="form-check-input wh-x2" id="titleSeparator" name="titleSeparator" {{ $item->settings['titleSeparator'] ?? false ? 'checked' : '' }}>
            </div>

        </div>
    </div>
    <!-- Sottotitolo -->
    <div class="row mb-4">
        <div class="col-12">
            <strong>{{ localize('Sottotitolo') }}</strong>
        </div>
        <div class="col-md-6">
            <label for="subtitle" class="form-label">{{ localize('Sottotitolo') }}</label>
            <input class="form-control" type="text" id="subtitle" name="subtitle" value="{{ isset($item->settings['subtitle']) ? $item->settings['subtitle'] : '' }}">
            <span class="fs-sm text-muted">{{ localize('Inserisci un titolo per la colonna.') }}</span>
        </div>
        <div class="col-md-3">
            <label for="subtitleSize" class="form-label">{{ localize('Grandezza Sottotitolo') }}</label>
            <input class="form-control" type="number" id="subtitleSize" name="subtitleSize" value="{{ isset($item->settings['subtitleSize']) ? $item->settings['subtitleSize'] : '' }}" min="10" max="72">
            <span class="fs-sm text-muted">{{ localize('Imposta la grandezza del sottotitolo in px.') }}</span>
        </div>
        <div class="col-md-3">
            <x-color-picker
                id="subtitleColor"
                name="subtitleColor"
                value="{{ old('subtitleColor', $item->settings['subtitleColor'] ?? '') }}"
                label="{{ localize('Colore del Sottotitolo') }}" />
            <span class="fs-sm text-muted">{{ localize('Scegli il colore del titolo.') }}</span>
        </div>

    </div>

    <!-- Descrizione -->
    <div class="row mb-4">
        <div class="col-12">
            <strong>{{ localize('Descrizione') }}</strong>
        </div>
        <div class="col-md-12">
            <label for="title" class="form-label">{{ localize('Descrizione') }}</label>
            <textarea id="description" class="editor" name="description">{{ isset($item->settings['description']) ? $item->settings['description'] : '' }}</textarea>
        </div>

    </div>
    <!-- Pulsante -->
    <div class="row mb-4">
        <div class="col-12">
            <strong>{{ localize('Pulsante') }}</strong>
        </div>
        <div class="col-md-3">
            <label for="buttonText" class="form-label">{{ localize('Tipo di pulsante') }}</label>
            <select class="form-select" id="buttonType" name="buttonType">

                <option value="button" {{ isset($item->settings['buttonType']) && $item->settings['buttonType'] == 'button' ? 'selected' : '' }}>Pulsante</option>
                <option value="link" {{ isset($item->settings['buttonType']) && $item->settings['buttonType'] == 'link' ? 'selected' : '' }}>Link</option>

            </select>
            <span class="fs-sm text-muted">{{ localize('Inserisci il testo che apparirà sul pulsante.') }}</span>
        </div>
        <div class="col-md-3">
            <label for="buttonText" class="form-label">{{ localize('Testo del Pulsante') }}</label>
            <input class="form-control" type="text" id="buttonText" name="buttonText" value="{{ isset($item->settings['buttonText']) ? $item->settings['buttonText'] : '' }}">
            <span class="fs-sm text-muted">{{ localize('Inserisci il testo che apparirà sul pulsante.') }}</span>
        </div>
        <div class="col-md-2">
            <x-color-picker
                id="buttonTextColor"
                name="buttonTextColor"
                value="{{ old('buttonTextColor', $item->settings['buttonTextColor'] ?? '') }}"
                label="{{ localize('Colore Pulsante') }}" />
            <span class="fs-sm text-muted">{{ localize('Scegli il colore del testo del pulsante.') }}</span>
        </div>
        <div class="col-md-3">
            <label for="buttonUrl" class="form-label">{{ localize('URL del Pulsante') }}</label>
            <input class="form-control" type="text" id="buttonUrl" name="buttonUrl" value="{{ isset($item->settings['buttonUrl']) ? $item->settings['buttonUrl'] : '' }}">
            <span class="fs-sm text-muted">{{ localize('Inserisci l\'URL a cui il pulsante dovrebbe puntare.') }}</span>
        </div>

        <div class="col-md-3 mt-3">
        <label for="buttonTarget" class="form-label">{{ localize('Azione di apertura') }}</label>
        <select class="form-select" id="buttonTarget" name="buttonTarget">
            <option value="_self" {{ isset($item->settings['buttonTarget']) && $item->settings['buttonTarget'] == '_self' ? 'selected' : '' }}>{{ localize('Stessa finestra') }}</option>
            <option value="_blank" {{ isset($item->settings['buttonTarget']) && $item->settings['buttonTarget'] == '_blank' ? 'selected' : '' }}>{{ localize('Nuova finestra') }}</option>
        </select>
        <span class="fs-sm text-muted">{{ localize('Scegli se aprire il link nella stessa finestra o in una nuova finestra.') }}</span>
    </div>
    </div>
</div>