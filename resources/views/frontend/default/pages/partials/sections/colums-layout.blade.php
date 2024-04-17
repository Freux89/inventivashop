@php
$section = [
'sectionTitle' => 'Nome della Sezione',
'sectionTitleColor' => '#FFFFFF', // Colore del titolo della sezione
'sectionBackgroundColor' => '#404647', // Colore dello sfondo della sezione
'columns' => [
[
'columnWidth' => 6,
'imageId' => 65,
'columnTitle' => 'Titolo Colonna Uno',
'columnTitleColor' => '#FFFFFF',
'starRating' => 4,
'buttonText' => 'APRI',
'buttonTextColor' => '#FFFFFF',
'buttonUrl' => '#' // URL del pulsante
],
[
'columnWidth' => 3,
'imageId' => 62,
'columnTitle' => 'Titolo Colonna Due',
'columnTitleColor' => '#FFFFFF',
'starRating' => 4,
'buttonText' => 'APRI',
'buttonTextColor' => '#FFFFFF',
'buttonUrl' => '#'
],
[
'columnWidth' => 3,
'imageId' => 64,
'columnTitle' => 'Titolo Colonna Tre',
'columnTitleColor' => '#FFFFFF',
'starRating' => 4,
'buttonText' => 'APRI',
'buttonTextColor' => '#FFFFFF',
'buttonUrl' => '#'
]
]
];
@endphp

<section class="colums-layout-section  py-9 position-relative z-1 overflow-hidden" style="background-color:{{$section['sectionBackgroundColor']}}">

    <div class="content-wrapper">
        <div class="section-title" style="color: {{$section['sectionTitleColor']}} ;"> {{localize($section['sectionTitle'])}} </div>
        <div class="row m-0">


            @foreach ($section['columns'] as $column)
            <div class="col-6 col-md-{{ $column['columnWidth'] }} p-0">
                <img src="{{ uploadedAsset($column['imageId']) }}" alt="Image {{ $loop->index + 1 }}" class="img-fluid img-adaptive-height">
                <div class="title fw-bold" style="color: {{ $column['columnTitleColor'] }}">{{ $column['columnTitle'] }}</div>
                <ul class="star-rating fs-sm d-inline-flex text-warning w-100">
                    {{ renderStarRatingFront($column['starRating'],5) }}
                </ul>
                @if ($column['buttonText'])
                <a href="{{ $column['buttonUrl'] }}" class="btn btn-primary" style="color:{{ $column['buttonTextColor'] }}; border-color:{{ $column['buttonTextColor'] }}">{{ localize($column['buttonText']) }}</a>
                @endif
            </div>
            @endforeach
        </div>


    </div>
</section>