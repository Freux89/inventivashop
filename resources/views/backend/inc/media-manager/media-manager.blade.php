<div class="offcanvas offcanvas-bottom" id="offcanvasBottom" tabindex="-1">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">{{ localize('Media Files') }}</h5>
        <button class="btn-close" type="button" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body bg-secondary-subtle" data-simplebar>

        <!-- content -->
        @include('backend.inc.media-manager.media-manager-content')
        <!-- content -->

        <div class="d-grid g-3 tt-media-select">
            <button class="btn btn-primary" onclick="showSelectedFilePreview()"
                data-bs-dismiss="offcanvas">{{ localize('Select') }}</button>
        </div>

    </div>
</div>

<!-- Modal di conferma cancellazione -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmDeleteModalLabel">Conferma Cancellazione</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Sei sicuro di voler cancellare questa immagine?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteButton">Conferma</button>
      </div>
    </div>
  </div>
</div>

<!-- Modale per l'Editing -->
<div class="modal fade" id="editMediaModal" tabindex="-1" aria-labelledby="editMediaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMediaModalLabel">Modifica Dettagli Immagine</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
            </div>
            <div class="modal-body">
                <form id="editMediaForm">
                    <div class="mb-3">
                        <label for="mediaAltText" class="form-label">Testo Alternativo (Alt)</label>
                        <input type="text" class="form-control" id="mediaAltText" name="alt_text" placeholder="Inserisci il testo alternativo">
                    </div>
                    <div class="mb-3">
                        <label for="mediaDescription" class="form-label">Descrizione</label>
                        <textarea class="form-control" id="mediaDescription" name="description" placeholder="Inserisci la descrizione"></textarea>
                    </div>
                    <input type="hidden" id="mediaId" name="media_id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                <button type="button" class="btn btn-primary" onclick="saveMediaDetails()">Salva Modifiche</button>
            </div>
        </div>
    </div>
</div>