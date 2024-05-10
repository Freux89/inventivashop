<div class="{{ $item->type == 'only-content' ? 'pe-md-6' : '' }} {{ $columnLayout[$index] == 3 ? 'col-6' : 'col-12' }} col-md-{{ $columnLayout[$index] }} p-0 py-{{ $item->settings['columnPaddingY'] }} px-md-{{ $item->settings['columnPaddingX'] }}  mb-6 mb-md-0 {{ isset($item->settings['image']) && !isset($item->settings['title']) ? 'd-flex align-items-center justify-content-center' : '' }} {{ $index < count($section->items) - 1 && isset($section->settings['divider']) ? 'divider-border-right' : '' }}">

@if (isset($item->settings['image']))
    <a href="{{ $item->settings['imageUrl'] }}" title="{{ $item->settings['titleUrl'] }}">
        <img src="{{ uploadedAsset($item->settings['image']) }}" class="img-fluid img-adaptive-height" alt="{{ $item->settings['altImage'] }}">
    </a>
    @endif

</div>