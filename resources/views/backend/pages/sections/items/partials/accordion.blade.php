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


    

    <div class="row mb-4">
        <div class="col-12 mb-3">
            <strong>{{ localize('Accordion') }}</strong>
        </div>
        <!-- Stile titoli accordion -->

    <div class="row mb-4">
       
        
       
        <div class="col-md-3">
            <label for="titleSizeAccordion" class="form-label">{{ localize('Grandezza Titolo') }}</label>
            <input class="form-control" type="number" id="titleSizeAccordion" name="titleSizeAccordion" value="{{ isset($item->settings['titleSizeAccordion']) ? $item->settings['titleSizeAccordion'] : '' }}" min="10" max="72">
            <span class="fs-sm text-muted">{{ localize('Imposta la grandezza dei titoli presenti nell\'accordion') }}</span>
        </div>
        <div class="col-md-3">
            <label for="titleColorAccordion" class="form-label">{{ localize('Colore') }}</label>
            <input class="form-control color-picker" type="color" id="titleColorAccordion" name="titleColorAccordion" value="{{ isset($item->settings['titleColorAccordion']) ? $item->settings['titleColorAccordion'] : '' }}">
            <span class="fs-sm text-muted">{{ localize('Scegli il colore dei titoli presenti nell\'accordion.') }}</span>
        </div>
      
    </div>

    <!-- Stile descrizione accordion -->

    <div class="row mb-4">
      
        
       
        <div class="col-md-3">
            <label for="descriptionSizeAccordion" class="form-label">{{ localize('Grandezza Descrizione') }}</label>
            <input class="form-control" type="number" id="descriptionSizeAccordion" name="descriptionSizeAccordion" value="{{ isset($item->settings['descriptionSizeAccordion']) ? $item->settings['descriptionSizeAccordion'] : '' }}" min="10" max="72">
            <span class="fs-sm text-muted">{{ localize('Imposta la grandezza della descrizione presenti nell\'accordion') }}</span>
        </div>
        <div class="col-md-3">
            <label for="descriptionColorAccordion" class="form-label">{{ localize('Colore') }}</label>
            <input class="form-control color-picker" type="color" id="descriptionColorAccordion" name="descriptionColorAccordion" value="{{ isset($item->settings['descriptionColorAccordion']) ? $item->settings['descriptionColorAccordion'] : '' }}">
            <span class="fs-sm text-muted">{{ localize('Scegli il colore della descrizione presenti nell\'accordion.') }}</span>
        </div>
      
    </div>
        <div class="col-md-12">
        <div id="accordionItems">
        @if(isset($item->settings['items']) && is_array($item->settings['items']))
                @foreach($item->settings['items'] as $index => $item)
                <div class="accordion-item" data-index="{{ $index }}" style="padding: 20px; border: 1px solid #ccc; margin-bottom: 10px;">
                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <div>
                                <label for="items[{{ $index }}][title]" class="form-label">Titolo</label>
                                <input type="text" class="form-control" name="items[{{ $index }}][title]" placeholder="Inserisci il titolo" value="{{ $item['title'] }}">
                            </div>
                            <button type="button" class="btn btn-link text-danger removeItem" style="border: none; background: none;">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                        <div class="mb-3">
                            <label for="items[{{ $index }}][description]" class="form-label">Descrizione</label>
                            <textarea class="form-control" name="items[{{ $index }}][description]" placeholder="Inserisci la descrizione">{{ $item['description'] }}</textarea>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <button type="button" class="btn btn-primary my-5" id="addItem">Aggiungi Item</button>

        </div>
    </div>

</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var maxIndex = 0; // Inizializza un contatore per tenere traccia dell'indice massimo
    // Cerca l'indice massimo esistente nel DOM al caricamento
    $('#accordionItems .accordion-item').each(function() {
        var index = parseInt($(this).data('index'));
        if (index > maxIndex) {
            maxIndex = index;
        }
    });

    $('#addItem').on('click', function() {
        maxIndex++; // Incrementa l'indice per ogni nuovo item aggiunto
        $('#accordionItems').append(`
        <div class="accordion-item" data-index="${maxIndex}" style="padding: 20px; border: 1px solid #ccc; margin-bottom: 10px;">
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <div>
                        <label for="items[${maxIndex}][title]" class="form-label">Titolo</label>
                        <input type="text" class="form-control" name="items[${maxIndex}][title]" placeholder="Inserisci il titolo">
                    </div>
                    <button type="button" class="btn btn-link text-danger removeItem" style="border: none; background: none;">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <div class="mb-3">
                    <label for="items[${maxIndex}][description]" class="form-label">Descrizione</label>
                    <textarea class="form-control" name="items[${maxIndex}][description]" placeholder="Inserisci la descrizione"></textarea>
                </div>
            </div>
        `);
       
    });

    $('#accordionItems').on('click', '.removeItem', function() {
        $(this).closest('.accordion-item').remove();
    });

    
});
</script>

@endsection