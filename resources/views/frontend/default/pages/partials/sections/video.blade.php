<div class="{{ $item->type == 'only-content' ? 'pe-md-6' : '' }} {{ $columnLayout[$index] == 3 ? 'col-6' : 'col-12' }} col-md-{{ $columnLayout[$index] }} p-0 py-{{ $item->settings['columnPaddingY'] }} px-md-{{ $item->settings['columnPaddingX'] }}  mb-6 mb-md-0 {{ isset($item->settings['image']) && !isset($item->settings['title']) ? 'd-flex align-items-center justify-content-center' : '' }} {{ $index < count($section->items) - 1 && isset($section->settings['divider']) ? 'divider-border-right' : '' }}">

    @if (isset($item->settings['videoUrl']))

        @php
            $videoUrl = $item->settings['videoUrl'];
            $isYoutube = strpos($videoUrl, 'youtube.com') !== false || strpos($videoUrl, 'youtu.be') !== false;
            $isWistia = strpos($videoUrl, 'wistia.net') !== false;
        @endphp

        @if ($isYoutube)
    {{-- Embed YouTube con lazy loading nativo --}}
    <iframe loading="lazy" width="100%" height="100%" src="https://www.youtube.com/embed/{{ \Str::afterLast($videoUrl, '/') }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

@elseif ($isWistia)
    {{-- Embed Wistia con lazy loading nativo --}}
    <iframe loading="lazy" src="https://fast.wistia.net/embed/iframe/{{ \Str::afterLast($videoUrl, '/') }}" allow="autoplay; fullscreen" allowfullscreen width="100%" height="100%" style="border:none;"></iframe>

@else
    {{-- Local video con lazy loading nativo --}}
    <video controls width="100%" height="100%" style="background-color:black" poster="{{ uploadedAsset($item->settings['image']) }}">
        <source src="{{$item->settings['videoUrl']}}" type="video/mp4">
        Il tuo browser non supporta il tag video.
    </video>
@endif


    @endif

</div>
