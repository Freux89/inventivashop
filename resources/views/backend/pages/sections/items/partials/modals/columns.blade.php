<!-- Modal tipi di colonne -->
<div class="modal fade" id="columnTypeModal" tabindex="-1" role="dialog" aria-labelledby="columnTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="columnTypeModalLabel">{{ localize('Seleziona il tipo di colonna') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <select class="form-control" id="typeSelect">
                        <option value="">Seleziona un tipo</option>
                        <option value="image-content">Immagine + Contenuto</option>
                        <option value="only-image">Solo Immagine</option>
                        <option value="only-content">Solo Contenuto</option>
                        <option value="video">Video</option>
                        <option value="card">Card</option>
                        <option value="accordion">Accordion</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ localize('Chiudi') }}</button>
                    <button type="button" class="btn btn-primary" onclick="redirectToCreateItem()">{{ localize('Crea Colonna') }}</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showColumnModal() {
      
      var maxColumnsCount = {{ $maxColumnsCount }};
      var currentItemsCount = {{ $currentItemsCount }};
  
      // Verifica se è stato definito un layout di colonne
      if (maxColumnsCount === 0) {
          alert("Per favore, seleziona prima una disposizione di colonne nella configurazione della sezione e salva.");
          return; // Impedisce l'apertura del modal se non è stato definito un layout
      }
  
      if (currentItemsCount >= maxColumnsCount) {
          alert("Hai selezionato su disposizione colonne " + maxColumnsCount + " colonne. Se vuoi inserire altre colonne, cambia la disposizione e salva.");
      } else {
          $('#columnTypeModal').modal('show');
      }
  }
    </script>