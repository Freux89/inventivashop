@php
if ($sectionType == 1) {
$section = [
'sectionTitle' => 'Nome della Sezione',
'sectionTitleColor' => '#FFFFFF',
'showTitle' => false,
'sectionBackgroundColor' => '#fff',
'sectionPaddingY' => 12,
'divider' => false,
'columns' => [
[
'type' => 'content',
'columnWidth' => 3,
'columnPaddingY' => 0,
'title' => 'Settore hotel lasciati ispirare',
'titleColor' => '#801854',
'titleSize' => '28px',
'description' => 'Trova spunti interessanti per il tuo marchio e per far crescere la tua attività con le Cartoline A6.',
'descriptionSize' => '26px',
'descriptionColor' => '#404647',
'buttonText' => 'BLOG',
'buttonTextSize' => '19px',
'buttonTextColor' => '#017480',
'buttonUrl' => '#'
],
[
'type' => 'card',
'columnWidth' => 3,
'columnPaddingY' => 0,
'imageId' => 70,
'titleImage' => 'Titolo Colonna Due',
'titleImageColor' => '#105862',
'buttonText' => 'Scopri di più',
'buttonTextSize' => '19px',
'buttonTextColor' => '#FFFFFF',
'buttonUrl' => '#'
],
[
'type' => 'card',
'columnWidth' => 3,
'columnPaddingY' => 0,
'imageId' => 64,
'titleImage' => 'Titolo Colonna Tre',
'titleImageColor' => '#105862',
'buttonText' => 'Scopri di più',
'buttonTextSize' => '19px',
'buttonTextColor' => '#FFFFFF',
'buttonUrl' => '#'
],
[
'type' => 'card',
'columnWidth' => 3,
'columnPaddingY' => 0,
'imageId' => 64,
'titleImage' => 'Titolo Colonna Tre',
'titleImageColor' => '#105862',
'buttonText' => 'Scopri di più',
'buttonTextSize' => '19px',
'buttonTextColor' => '#FFFFFF',
'buttonUrl' => '#'
]
]
];
}
@endphp

<section class="columns-layout-section py-{{$section['sectionPaddingY']}} position-relative z-1 overflow-hidden" style="background-color:{{ $section['sectionBackgroundColor'] }};">
    <div class="content-wrapper">
        @if ($section['showTitle'])
        <div class="section-title" style="color: {{ $section['sectionTitleColor'] }};">
            {{ localize($section['sectionTitle']) }}
        </div>
        @endif
        <div class="row m-0">
            @foreach ($section['columns'] as $index => $column)
            <div class="{{ $column['type'] == 'content' ? 'pe-md-6' : '' }} {{ $column['columnWidth'] == 3 ? 'col-6' : 'col-12' }} col-md-{{ $column['columnWidth'] }} p-0 py-{{ $column['columnPaddingY'] }}  mb-6 mb-md-0 {{ isset($column['imageId']) && !isset($column['titleImage']) ? 'd-flex align-items-center justify-content-center' : '' }} {{ $index < count($section['columns']) - 1 && $section['divider'] ? 'divider-border-right' : '' }}">

                @if ($column['type']== 'card')
                <div class="card mx-4">
                    <div class="img-container" style="height: 0; padding-top: 75%; position: relative; overflow: hidden;">
                        <img src="{{ uploadedAsset($column['imageId']) }}" alt="Image {{ $column['titleImage'] ?? 'Details' }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                    </div>

                    <div class="card-body p-6" style="font-size:20px;">
                        @if (isset($column['titleImage']))
                        <div class="card-title fw-bold mt-4" style="color: {{ $column['titleImageColor'] }}; ">{{ $column['titleImage'] }}</div>
                        @endif
                        <p class="card-text">Questa è una breve descrizione che descrive i dettagli della card.</p>
                        <a href="https://example.com" class="btn btn-primary">Scopri di più</a>
                    </div>
                </div>

                @endif
                @if (isset($column['videoUrl']))
                <video controls width="100%" height="100%" style="background-color:black" poster="{{ uploadedAsset(70) }}">
                    <source src="{{$column['videoUrl']}}" type="video/mp4">
                    Il tuo browser non supporta il tag video.
                </video>
                @endif
                @if (isset($column['title']))
                <div class="title fw-bold mb-5" style="color: {{ $column['titleColor'] }}; font-size: {{ $column['titleSize'] }}">{{ $column['title'] }}</div>
                @endif
                @if (isset($column['subtitle']))
                <div class="subtitle fw-bold mb-6" style="color: {{ $column['subtitleColor'] }}; font-size: {{ $column['subtitleSize'] }}">{{ $column['subtitle'] }}</div>

                @endif
                @if (isset($column['description']))
                <div class="description" style="color: {{ $column['descriptionColor'] }}; font-size: {{ $column['descriptionSize'] }}">{{ $column['description'] }}</div>
                @endif

                @if (isset($column['starRating']))
                <ul class="star-rating fs-sm d-inline-flex text-warning w-100">
                    {{ renderStarRatingFront($column['starRating'], 5) }}
                </ul>
                @endif

                @if (isset($column['buttonText']))
                <a href="{{ $column['buttonUrl'] }}" class="{{ $column['type'] == 'content' ? 'btn btn-primary' : 'subtext-link mt-6' }}" style="color:{{ $column['buttonTextColor'] }}; font-size:{{ $column['buttonTextSize'] }}; border-color:{{ $column['buttonTextColor'] }}">{{ localize($column['buttonText']) }}</a>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>