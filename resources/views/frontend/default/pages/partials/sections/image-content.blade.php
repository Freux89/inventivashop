<div class="{{ $item->type == 'content' ? 'pe-md-6' : '' }} {{ $columnLayout[$index] == 3 ? 'col-6' : 'col-12' }} col-md-{{ $columnLayout[$index] }} p-0 py-{{ $item->settings['columnPaddingY'] }} px-md-{{ $item->settings['columnPaddingX'] }}  mb-6 mb-md-0 {{ isset($item->settings['image']) && !isset($item->settings['title']) ? 'd-flex align-items-center justify-content-center' : '' }} {{ $index < count($section->items) - 1 && isset($section->settings['divider']) ? 'divider-border-right' : '' }}">
    @if (isset($item->settings['image']))
    
    <img src="{{ uploadedAsset($item->settings['image']) }}" alt="Image {{ $item->settings['title'] ?? 'Details' }}" class="img-fluid img-adaptive-height">
    @endif

    @if (isset($item->settings['title']) && $item->type == 'image-content')
    <div class="title fw-bold mt-8" style="color: {{ $item->settings['titleColor'] }}; font-size: {{ $item->settings['titleSize'] }}px">{{ $item->settings['title']  }}</div>
    @endif
    @if (isset($item->settings['starRating']))
    <ul class="star-rating fs-sm d-inline-flex text-warning w-100">
        {{ renderStarRatingFront($item->settings['starRating'], 5) }}
    </ul>
    @endif

    @if (isset($item->settings['buttonText']))
    <a href="{{ $item->settings['buttonUrl'] }}" class="{{ $item->type == 'image-content' ? 'btn btn-primary' : 'subtext-link mt-6' }}" title="{{ $item->settings['title']  }}" style="color:{{ $item->settings['buttonTextColor'] }}; border-color:{{ $item->settings['buttonTextColor'] }}">{{ localize($item->settings['buttonText']) }}</a>
    @endif
</div>