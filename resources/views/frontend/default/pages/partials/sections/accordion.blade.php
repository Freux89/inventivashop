<div class="{{ $item->type == 'only-content' ? 'pe-md-6' : '' }} col-12 col-md-{{ $columnLayout[$index] }} p-0 py-{{ $item->settings['columnPaddingY'] }} px-md-{{ $item->settings['columnPaddingX'] }}  mb-6 mb-md-0 {{ isset($item->settings['image']) && !isset($item->settings['title']) ? 'd-flex align-items-center justify-content-center' : '' }} {{ $index < count($section->items) - 1 && isset($section->settings['divider']) ? 'divider-border-right' : '' }}">



    <div class="accordion pe-md-5" id="faqAccordion">
        @foreach($item->settings['items'] as $indexItem => $subItem)
        <div class="accordion-item {{ $indexItem === 0 ? 'border-top' : '' }} border-bottom">
            <div class="accordion-header" id="heading{{ $index }}-{{ $indexItem }}">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}-{{ $indexItem }}" aria-expanded="false" aria-controls="collapse{{ $index }}-{{ $indexItem }}" style="font-size:{{$item->settings['titleSizeAccordion']}}px; color:{{$item->settings['titleColorAccordion']}};">
                    {{ $subItem['title'] }}
                </button>
            </div>
            <div id="collapse{{ $index }}-{{ $indexItem }}" class="accordion-collapse collapse " aria-labelledby="heading{{ $index }}-{{ $indexItem }}" data-bs-parent="#faqAccordion{{ $index }}">
                <div class="accordion-body" style="font-size:{{$item->settings['descriptionSizeAccordion']}}px; color:{{$item->settings['descriptionColorAccordion']}};">
                {!! $subItem['description'] !!}

                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>