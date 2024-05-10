@php
if ($sectionType == 1) {
$section = [
'sectionTitle' => 'Nome della Sezione',
'sectionTitleColor' => '#FFFFFF',
'showTitle' => true,
'sectionBackgroundColor' => '#404647',
'sectionPaddingY' => 9,
'divider' => false,
'columns' => [
[
'type' => 'image',
'columnWidth' => 6,
'columnPaddingY' => 0,
'imageId' => 65,
'titleImage' => 'Titolo Colonna Uno',
'titleImageColor' => '#FFFFFF',
'starRating' => 4,
'buttonText' => 'APRI',
'buttonTextColor' => '#FFFFFF',
'buttonUrl' => '#'
],
[
'type' => 'image',
'columnWidth' => 3,
'columnPaddingY' => 0,
'imageId' => 62,
'titleImage' => 'Titolo Colonna Due',
'titleImageColor' => '#FFFFFF',
'starRating' => 4,
'buttonText' => 'APRI',
'buttonTextColor' => '#FFFFFF',
'buttonUrl' => '#'
],
[
'type' => 'image',
'columnWidth' => 3,
'columnPaddingY' => 0,
'imageId' => 64,
'titleImage' => 'Titolo Colonna Tre',
'titleImageColor' => '#FFFFFF',
'starRating' => 4,
'buttonText' => 'APRI',
'buttonTextColor' => '#FFFFFF',
'buttonUrl' => '#'
]
]
];
} else if ($sectionType == 2) {
$section = [

'sectionBackgroundColor' => '#ffffff',
'sectionPaddingY' => 9,
'divider' => true,
'columns' => [
[
'type' => 'content',
'columnWidth' => 6,
'columnPaddingY' => 9,
'title' => 'Inventivashop',
'titleColor' => '#801854',
'titleSize' => '46px',
'subtitle' => 'Incisione e stampa online per la produzione di signage design',
'subtitleColor' => '#105862',
'subtitleSize' => '22px',
'description' => 'InventivaShop si rivolge a piccole e grandi aziende con soluzioni personalizzate legate al mondo della comunicazione visiva. Incisione e stampa online per la comunicazione visiva, con manufatti realizzati artigianalmente su misura. Affianchiamo il mercato della pubblicità, con un esperienza iniziata nel 2005 mediante la produzione e fornitura di targhette personalizzate, insegne, cartelli personalizzati, segnaletica ed espositori.',
'descriptionSize' => '20px',
'descriptionColor' => '20px',
'titleImageColor' => '#FFFFFF',
'buttonText' => 'SCOPRI',
'buttonTextColor' => '#FFFFFF',
'buttonUrl' => '#'
],
[
'type' => 'only-image',
'columnWidth' => 6,
'columnPaddingY' => 0,
'imageId' => 67,
]
]
];
}
else if ($sectionType == 3) {
$section = [
'sectionTitle' => '',
'sectionTitleColor' => '#FFFFFF',
'sectionBackgroundColor' => '#F4F8F8',
'divider' => false,
'sectionPaddingY' => 0,
'columns' => [
[
'type' => 'content',
'columnWidth' => 7,
'columnPaddingY' => 9,
'title' => 'Scopri di più sui nostri articoli per hotel',
'titleColor' => '#801854',
'titleSize' => '28px',
'description' => 'Nel competitivo settore alberghiero, la prima impressione è fondamentale per impressionare i clienti e fidelizzarli. La segnaletica all’interno di un hotel svolge un ruolo cruciale nell’orientare gli ospiti, creare un’esperienza di soggiorno piacevole e garantire un flusso efficiente all’interno della struttura.',
'descriptionSize' => '20px',
'descriptionColor' => '20px',
'titleImageColor' => '#FFFFFF',
'buttonText' => 'Scopri di più',
'buttonTextColor' => '#017480',
'buttonUrl' => '#'
],
[
'type' => 'video',
'columnWidth' => 5,
'columnPaddingY' => 0,
'videoUrl' => 'https://immaginepubblicita.com/video_inventivashop/yt5s.io-InventivaShop.mp4',
]
]
];
}
@endphp




<section class="columns-layout-section py-{{$section['sectionPaddingY']}} position-relative z-1 overflow-hidden" style="background-color:{{ $section['sectionBackgroundColor'] }};">
    <div class="content-wrapper">
    @if (isset($section->settings['title']) && $section->settings['title'] !== '')
        <div class="section-title" style="color: {{ $section['sectionTitleColor'] }};">
            {{ localize($section['sectionTitle']) }}
        </div>
        @endif
        <div class="row m-0">
            @foreach ($section['columns'] as $index => $column)
            <div class="{{ $column['type'] == 'content' ? 'pe-md-6' : '' }} {{ $column['columnWidth'] == 3 ? 'col-6' : 'col-12' }} col-md-{{ $column['columnWidth'] }} p-0 py-{{ $column['columnPaddingY'] }}  mb-6 mb-md-0 {{ isset($column['imageId']) && !isset($column['titleImage']) ? 'd-flex align-items-center justify-content-center' : '' }} {{ $index < count($section['columns']) - 1 && $section['divider'] ? 'divider-border-right' : '' }}">
                @if (isset($column['imageId']))
                <img src="{{ uploadedAsset($column['imageId']) }}" alt="Image {{ $column['titleImage'] ?? 'Details' }}" class="img-fluid img-adaptive-height">
                @endif
                @if (isset($column['videoUrl']))
                <video controls width="100%" height="100%" style="background-color:black" poster="{{ uploadedAsset(70) }}">
                    <source src="{{$column['videoUrl']}}" type="video/mp4">
                    Il tuo browser non supporta il tag video.
                </video> 
                @endif
                @if (isset($column['title']))
                <div class="title fw-bold mb-0" style="color: {{ $column['titleColor'] }}; font-size: {{ $column['titleSize'] }}">{{ $column['title'] }}</div>
                @endif
                @if (isset($column['subtitle']))
                <div class="subtitle fw-bold mb-6" style="color: {{ $column['subtitleColor'] }}; font-size: {{ $column['subtitleSize'] }}">{{ $column['subtitle'] }}</div>
                @elseif(isset($column['title']))
                <div class="line-below-title"></div>
                @endif
                @if (isset($column['description']))
                <div class="description" style="color: {{ $column['descriptionColor'] }}; font-size: {{ $column['descriptionSize'] }}">{{ $column['description'] }}</div>
                @endif
                @if (isset($column['titleImage']))
                <div class="title fw-bold mt-8" style="color: {{ $column['titleImageColor'] }}">{{ $column['titleImage']  }}</div>
                @endif
                @if (isset($column['starRating']))
                <ul class="star-rating fs-sm d-inline-flex text-warning w-100">
                    {{ renderStarRatingFront($column['starRating'], 5) }}
                </ul>
                @endif
                
                @if (isset($column['buttonText']))
                <a href="{{ $column['buttonUrl'] }}" class="{{ $column['type'] == 'image' ? 'btn btn-primary' : 'subtext-link mt-6' }}" style="color:{{ $column['buttonTextColor'] }}; border-color:{{ $column['buttonTextColor'] }}">{{ localize($column['buttonText']) }}</a>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>