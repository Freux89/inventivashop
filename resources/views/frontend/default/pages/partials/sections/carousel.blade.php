<!-- Tipo 1 -->
@php

if (isset($carouselType) && $carouselType == 'rounded') {
$section = [
'sectionBackgroundColor' => '#f4f8f8',
'sectionTitle' => 'Categorie',
'titleFontSize' => '46px', // Dimensione del font del titolo della sezione
'titleAlignment' => 'center', // Allineamento del titolo della sezione
'carouselStyle' => 'rounded', // 'squared' o 'rounded' per gli item del carosello
'itemTitleFontSize' => '22px', // Dimensione del font del titolo degli item
'showStars' => false, // Booleano che indica se mostrare o meno le stelline
'items' => [
['imageId' => 32, 'title' => 'Categoria 1', 'stars' => 4],
['imageId' => 47, 'title' => 'Categoria 2', 'stars' => 3],
['imageId' => 58, 'title' => 'Categoria 3', 'stars' => 5],
['imageId' => 58, 'title' => 'Categoria 4', 'stars' => 4],
['imageId' => 58, 'title' => 'Categoria 5', 'stars' => 2],
['imageId' => 58, 'title' => 'Categoria 6', 'stars' => 3],
['imageId' => 58, 'title' => 'Categoria 7', 'stars' => 4],
['imageId' => 58, 'title' => 'Categoria 8', 'stars' => 5]
]
];
} else {
$section = [
'sectionBackgroundColor' => '#fff',
'sectionTitle' => 'I più venduti',
'titleFontSize' => '24px', // Dimensione del font del titolo della sezione
'titleAlignment' => 'left', // Allineamento del titolo della sezione
'carouselStyle' => 'squared', // 'squared' o 'rounded' per gli item del carosello
'itemTitleFontSize' => '18px', // Dimensione del font del titolo degli item
'showStars' => true, // Booleano che indica se mostrare o meno le stelline
'items' => [
['imageId' => 58, 'title' => 'Categoria 1', 'stars' => 4],
['imageId' => 58, 'title' => 'Categoria 2', 'stars' => 3],
['imageId' => 58, 'title' => 'Categoria 3', 'stars' => 5],
['imageId' => 58, 'title' => 'Categoria 4', 'stars' => 4],
['imageId' => 58, 'title' => 'Categoria 5', 'stars' => 2],
['imageId' => 58, 'title' => 'Categoria 6', 'stars' => 3],
['imageId' => 58, 'title' => 'Categoria 7', 'stars' => 4],
['imageId' => 58, 'title' => 'Categoria 8', 'stars' => 5]
]
];
}

@endphp

<!-- Swiper -->
<section class="carousel-section  py-9 position-relative z-1 overflow-hidden {{ $section['carouselStyle'] == 'rounded' ? 'rounded-style' : '' }}" style="background-color:{{$section['sectionBackgroundColor']}}">
    <div class="content-wrapper">
        <div class="section-title" style="font-size: {{ $section['titleFontSize'] }}; text-align: {{ $section['titleAlignment'] }};">
            {{ localize($section['sectionTitle']) }}
        </div>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                @foreach ($section['items'] as $item)
                <div class="swiper-slide"> <!-- Centratura del contenuto -->
                    <img src="{{ uploadedAsset($item['imageId']) }}" alt="Image {{ $item['title'] }}" class="img-fluid">
                    <div class="title" style="font-size: {{ $section['itemTitleFontSize'] }}">{{ $item['title'] }}</div>
                    @if ($section['showStars'])
                    <ul class="star-rating fs-sm d-inline-flex justify-content-center text-warning">
                        {{ renderStarRatingFront($item['stars'], 5) }}
                    </ul>
                    @endif
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>