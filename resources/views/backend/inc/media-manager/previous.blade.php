@forelse ($mediaFiles as $key => $mediaFile)
    <div class="tt-media-item" data-active-file-id="{{ $mediaFile->id }}" id="media-item-{{ $mediaFile->id }}"
        onclick="handleSelectedFiles({{ $mediaFile->id }})">
        <div class="tt-media-img">
    @if ($mediaFile->media_type == 'image')
        <!-- Anteprima dell'immagine -->
        <img src="{{ uploadedAsset($mediaFile->id) }}" class="img-fluid" />
    @elseif ($mediaFile->media_type == 'document')
        <!-- Icona per i documenti -->
        @if ($mediaFile->media_extension == 'pdf')
            <!-- Icona per PDF -->
            <i class="fas fa-file-pdf fa-3x text-danger"></i>
        @elseif ($mediaFile->media_extension == 'zip')
            <!-- Icona per ZIP -->
            <i class="fas fa-file-archive fa-3x text-warning"></i>
        @else
            <!-- Icona per altri tipi di documenti -->
            <i class="fas fa-file-alt fa-3x text-secondary"></i>
        @endif
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

                <!-- Pulsante per Copiare l'URL -->
<a class="btn btn-sm px-2 btn-info media-copy-url-btn me-2" data-bs-toggle="tooltip"
   data-bs-placement="top" data-bs-title="Copia URL"
   onclick="copyMediaUrl('{{ uploadedAsset($mediaFile->id) }}'); event.stopPropagation();">
    <i data-feather="link"></i>
</a>

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
