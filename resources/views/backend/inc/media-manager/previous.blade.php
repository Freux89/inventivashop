@forelse ($mediaFiles as $key => $mediaFile)
    <div class="tt-media-item" data-active-file-id="{{ $mediaFile->id }}"
        onclick="handleSelectedFiles({{ $mediaFile->id }})">
        <div class="tt-media-img">
            @if ($mediaFile->media_type == 'image')
                <img src={{ uploadedAsset($mediaFile->id) }} class="img-fluid" />
            @else
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
                <a class="tt-remove btn btn-sm px-2 btn-danger media-delete-btn" data-bs-toggle="tooltip"
                    data-bs-placement="top" data-bs-title="Remove this file"
                    data-href="{{ route('uppy.delete', $mediaFile->id) }}" onclick="confirmDelete(this)"><i
                        data-feather="trash"></i></a>
            </div>
        @endcan


    </div>

@empty
    <div class="text-center text-danger p-5">{{ localize('No data found') }}</div>
@endforelse
