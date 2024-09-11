
<div class="{{ $item->type == 'only-content' ? 'pe-md-6' : '' }} col-12 col-md-{{ $columnLayout[$index] }} p-0 py-{{ $item->settings['columnPaddingY'] }} px-md-{{ $item->settings['columnPaddingX'] }}  mb-6 mb-md-0 {{ isset($item->settings['image']) && !isset($item->settings['title']) ? 'd-flex align-items-center justify-content-center' : '' }} {{ $index < count($section->items) - 1 && isset($section->settings['divider']) ? 'divider-border-right' : '' }}">
                
                
                @if (isset($item->settings['title']))
                <div class="title fw-bold mb-0" style="color: {{ $item->settings['titleColor'] }}; font-size: {{ $item->settings['titleSize'] }}px">{{ $item->settings['title'] }}</div>
                @endif

                @if (isset($item->settings['subtitle']))
                <div class="subtitle fw-bold" style="color: {{ $item->settings['subtitleColor'] }}; font-size: {{ $item->settings['subtitleSize'] }}px">{{ $item->settings['subtitle'] }}</div>
                @endif
                @if(isset($item->settings['titleSeparator']))
                <div class="line-below-title"></div>
                @endif

                @if (isset($item->settings['description']))
                <div class="description {{ isset($item->settings['titleSeparator']) ? 'mt-0' : 'mt-6' }}">{!! $item->settings['description'] !!}</div>
                @endif
             
                @if (isset($item->settings['buttonText']))
    <a href="{{ $item->settings['buttonUrl'] }}" 
       class="{{ $item->settings['buttonType'] == 'button' ? 'btn btn-primary' : 'subtext-link mt-6' }}" 
       style="color:{{ $item->settings['buttonTextColor'] }}; border-color:{{ $item->settings['buttonTextColor'] }}; font-size:19px;" 
       {{ isset($item->settings['buttonTarget']) ? 'target=' . $item->settings['buttonTarget'] : '' }}>
       {{ localize($item->settings['buttonText']) }}
    </a>
@endif

            </div>
      