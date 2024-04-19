@php
if ($sectionType == 1) {
    $section = [
        'sectionTitle' => 'Nome della Sezione',
        'sectionTitleColor' => '#FFFFFF',
        'showTitle' => true,
        'sectionBackgroundColor' => '#404647',
        'divider' => false, 
        'columns' => [
            [
                'type' => 'image',
                'columnWidth' => 6,
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
        'sectionTitle' => 'Altra Sezione',
        'sectionTitleColor' => '#FFFFFF',
        'showTitle' => false,
        'sectionBackgroundColor' => '#ffffff',
        'divider' => true, 
        'columns' => [
            [
                'type' => 'content',
                'columnWidth' => 6,
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
                'imageId' => 67,
            ]
        ]
    ];
}
@endphp

<section class="columns-layout-section py-9 position-relative z-1 overflow-hidden" style="background-color:{{ $section['sectionBackgroundColor'] }};">
    <div class="content-wrapper">
        @if ($section['showTitle'])
        <div class="section-title" style="color: {{ $section['sectionTitleColor'] }};">
            {{ localize($section['sectionTitle']) }}
        </div>
        @endif
        <div class="row m-0">
            @foreach ($section['columns'] as $index => $column)
                <div class="{{ $column['type'] == 'content' ? 'pe-md-6' : '' }} {{ $column['columnWidth'] == 3 ? 'col-6' : 'col-12' }} col-md-{{ $column['columnWidth'] }} p-0 mb-6 mb-md-0 {{ isset($column['imageId']) && !isset($column['titleImage']) ? 'd-flex align-items-center justify-content-center' : '' }} {{ $index < count($section['columns']) - 1 && $section['divider'] ? 'divider-border-right' : '' }}">
                    @if (isset($column['imageId']))
                        <img src="{{ uploadedAsset($column['imageId']) }}" alt="Image {{ $column['titleImage'] ?? 'Details' }}" class="img-fluid img-adaptive-height">
                    @endif
                    @if (isset($column['title']))
                        <div class="title fw-bold mb-0" style="color: {{ $column['titleColor'] }}; font-size: {{ $column['titleSize'] }}">{{ $column['title'] }}</div>
                    @endif
                    @if (isset($column['subtitle']))
                        <div class="subtitle fw-bold mb-6" style="color: {{ $column['subtitleColor'] }}; font-size: {{ $column['subtitleSize'] }}">{{ $column['subtitle'] }}</div>
                    @endif
                    @if (isset($column['description']))
                    <div class="description" style="color: {{ $column['descriptionColor'] }}; font-size: {{ $column['descriptionSize'] }}">{{ $column['description'] }}</div>
                    @endif
                    @if (isset($column['titleImage']))
                    <div class="title fw-bold" style="color: {{ $column['titleImageColor'] }}">{{ $column['titleImage']  }}</div>
                    @endif
                    @if (isset($column['starRating']))
                        <ul class="star-rating fs-sm d-inline-flex text-warning w-100">
                            {{ renderStarRatingFront($column['starRating'], 5) }}
                        </ul>
                    @endif
                    @if (isset($column['buttonText']))
                        <a href="{{ $column['buttonUrl'] }}" class="btn btn-primary" style="color:{{ $column['buttonTextColor'] }}; border-color:{{ $column['buttonTextColor'] }}">{{ localize($column['buttonText']) }}</a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
