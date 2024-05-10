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
                <select class="form-control" id="TypeSelect">
                    <option value="">Seleziona un tipo</option>
                    <option value="content-static">Contenuto statico</option>
                    <option value="category">Categoria</option>
                    <option value="product">Prodotto</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ localize('Chiudi') }}</button>
                <button type="button" class="btn btn-primary" onclick="redirectToCreateItem()">{{ localize('Crea Elemento') }}</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showColumnModal() {

        $('#columnTypeModal').modal('show');

    }
</script>