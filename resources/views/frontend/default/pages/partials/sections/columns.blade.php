@php
$columnLayout =  explode("-", $section->settings['columnLayout']);
@endphp

<section class="columns-layout-section py-{{$section->settings['paddingY']}} position-relative z-1 overflow-hidden" style="background-color:{{ $section->settings['backgroundColor'] }};">
    <div class="content-wrapper">
        @if (isset($section->settings['title']) && $section->settings['title'] !== '')
        <div class="section-title" style="{{ isset($section->settings['titleSize']) ? 'font-size: ' . $section->settings['titleSize'] . 'px;' : '' }}
       {{ isset($section->settings['titleAlignment']) ? 'text-align: ' . $section->settings['titleAlignment'] . ';' : '' }}
       {{ isset($section->settings['titleColor']) ? 'color: ' . $section->settings['titleColor'] . ';' : '' }}">
            {{ localize($section->settings['title']) }}
        </div>
        @endif
        <div class="row m-0">
            @foreach ($section->items as $index => $item)
                @if($item->type == 'image-content')
                    @include('frontend.default.pages.partials.sections.image-content')
                @elseif($item->type == 'only-image')
                    @include('frontend.default.pages.partials.sections.image')
                @elseif($item->type == 'only-content')
                    @include('frontend.default.pages.partials.sections.content')
                @elseif($item->type == 'video')
                    @include('frontend.default.pages.partials.sections.video')
                @elseif($item->type == 'card')
                    @include('frontend.default.pages.partials.sections.card')
                @elseif($item->type == 'accordion')
                    @include('frontend.default.pages.partials.sections.accordion')    
                @endif
            @endforeach
        </div>
    </div>
</section>