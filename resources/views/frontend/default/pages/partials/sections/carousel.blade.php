@php

$section = App\Models\Section::with('items')->findOrFail($sectionId);


@endphp

<!-- Swiper -->
<section class="carousel-section  py-9 position-relative z-1 overflow-hidden {{ $section->settings['layout'] == 'rounded' ? 'rounded-style' : '' }}" style="background-color:{{$section->settings['backgroundColor']}}">
    <div class="content-wrapper">
        <div class="section-title" style="font-size: {{ $section->settings['titleSize'] }}px; text-align: {{ $section->settings['titleAlignment'] }};color: {{ $section->settings['titleColor'] }};">
            {{ localize($section->settings['title']) }}
        </div>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                @foreach ($section->items as $item)
                <div class="swiper-slide"> <!-- Centratura del contenuto -->
                    <img src="{{ uploadedAsset($item->settings['image']) }}" alt="Image {{ $item->settings['title'] }}" class="img-fluid">
                    <a class="title" style="font-size: {{ $item->settings['titleSize'] }}px; color: {{ $item->settings['titleColor'] }};" href="{{ $item->settings['url'] }}">
                        {{ $item->settings['title'] }}
                    </a>
                    @if (isset($item->settings['starRating']))
                    <ul class="star-rating fs-sm d-inline-flex justify-content-center text-warning">
                        {{ renderStarRatingFront($item->settings['starRating'], 5) }}
                    </ul>
                    @endif
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>