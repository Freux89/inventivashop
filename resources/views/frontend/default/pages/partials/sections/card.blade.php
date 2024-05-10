<div class="{{ $item->type == 'only-content' ? 'pe-md-6' : '' }} col-12 col-md-{{ $columnLayout[$index] }} p-0 py-0  mb-6 mb-md-0 {{ isset($item->settings['image']) && !isset($item->settings['title']) ? 'd-flex align-items-center justify-content-center' : '' }} {{ $index < count($section->items) - 1 && isset($section->settings['divider']) ? 'divider-border-right' : '' }}">

    <div class="card mx-md-4">
        <div class="img-container" style="height: 0; padding-top: 75%; position: relative; overflow: hidden;">
            <img src="{{ uploadedAsset($item->settings['image']) }}" alt="{{ $item->settings['title'] ?? 'Details' }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
        </div>

        <div class="card-body p-6" style="font-size:20px;">
            @if (isset($item->settings['title']))
            <div class="card-title fw-bold mt-4" style="color:#105862;">{{ $item->settings['title'] }}</div>
            @endif
            <p class="card-text">{{$item->settings['description']}}</p>
            <a href="{{$item->settings['url']}}" class="subtext-link mt-6">{{$item->settings['textUrl']}}</a>
        </div>
    </div>
</div>