@foreach ($mediaFiles as $mediaFile)
    <div class="avatar avatar-xl selected-file">
        <img class="rounded-circle" src="{{ uploadedAsset($mediaFile->id) }}" alt="">
        <span class="tt-remove" onclick="removeSelectedFile(this, {{ $mediaFile->id }})"><i
                data-feather="trash"></i></span>
    </div>
@endforeach
