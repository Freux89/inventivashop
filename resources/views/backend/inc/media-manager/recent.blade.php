@forelse ($recentFiles as $key => $mediaFile)
    <div class="tt-media-item" data-active-file-id="{{ $mediaFile->id }}" id="media-item-{{ $mediaFile->id }}"
        onclick="handleSelectedFiles({{ $mediaFile->id }})">
        <div class="tt-media-img">
            @if ($mediaFile->media_type == 'image')
                <img src="{{ uploadedAsset($mediaFile->id) }}" class="img-fluid" />
            @endif
        </div>
        <div class="tt-media-info-wrap p-2">
            <div class="tt-media-info">
                <p class="fs-base mb-0 text-truncate">{{ $mediaFile->media_name }}</p>
                <span class="text-muted fs-sm text-truncate">{{ $mediaFile->media_extension }}</span>
            </div>
        </div>
        @can('delete_media')
            <div class="tt-media-action-wrap d-flex align-items-center justify-content-center">
                <!-- Pulsante Modifica -->
                <a class="btn btn-sm px-2 btn-warning media-edit-btn me-2" data-bs-toggle="tooltip"
                   data-bs-placement="top" data-bs-title="Modifica file"
                   onclick="openEditModal({{ $mediaFile->id }}, '{{ $mediaFile->alt_text }}', '{{ $mediaFile->description }}'); event.stopPropagation();">
                    <i data-feather="edit"></i>
                </a>

                <!-- Pulsante Elimina -->
                <a class="tt-remove btn btn-sm px-2 btn-danger media-delete-btn" data-bs-toggle="tooltip"
                   data-bs-placement="top" data-bs-title="Rimuovi file"
                   data-href="{{ route('uppy.delete', $mediaFile->id) }}" onclick="deleteMedia(this, {{ $mediaFile->id }}); event.stopPropagation();">
                    <i data-feather="trash"></i>
                </a>
            </div>
        @endcan
    </div>
@empty
    <div class="text-center text-danger p-5">{{ localize('No data found') }}</div>
@endforelse


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

