@php

$section = App\Models\Section::with('items')->findOrFail($sectionId);
$categoriesString = $section->settings['categories'] ?? '';
$categories = explode(',', $categoriesString);

@endphp

<section class="filters-bar-section py-{{$section->settings['paddingY']}} position-relative z-1 overflow-hidden" style="background-color:{{ $section->settings['backgroundColor'] }};">

    <div class="content-wrapper">
        <div class="row align-items-center">
            <div class="col-xl-12">
                <div class="section-title">
                    {{localize($section->settings['title'])}}
                </div>
            </div>
            <div class="col-xl-12">
                <div class="filter-btns gshop-filter-btn-group d-flex  mt-4 mt-xl-0 py-3">
                    <svg class="ms-4 ms-sm-9 me-2 me-sm-7" width="18" id="b9067e2b-d9ac-445b-a5d6-c960926dd638" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.23 122.88">
                        <path d="M122.23,12.35V22.89a2.55,2.55,0,0,1-2.69,2.35H77.85a17.62,17.62,0,0,1-31.79,0H2.69A2.55,2.55,0,0,1,0,22.89V12.35A2.55,2.55,0,0,1,2.69,10H46.06a17.62,17.62,0,0,1,31.78,0h41.69a2.55,2.55,0,0,1,2.7,2.35ZM49.57,112.88a17.63,17.63,0,0,1-31.79,0H2.69A2.55,2.55,0,0,1,0,110.53V100a2.55,2.55,0,0,1,2.69-2.35H17.78a17.62,17.62,0,0,1,31.78,0h70a2.55,2.55,0,0,1,2.69,2.35v10.54a2.55,2.55,0,0,1-2.69,2.35Zm54.55-43.15a17.62,17.62,0,0,1-31.79,0H2.69A2.55,2.55,0,0,1,0,67.38V56.85A2.55,2.55,0,0,1,2.69,54.5H72.33a17.62,17.62,0,0,1,31.78,0h15.42a2.55,2.55,0,0,1,2.69,2.35V67.38a2.55,2.55,0,0,1-2.69,2.35Z" transform="translate(0)" style="fill:#fff;fill-rule:evenodd" />
                    </svg>

                    <div class="filter-options">
                        @foreach($categories as $index => $category)
                        <button data-filter=".{{ str_replace(' ', '-', $category) }}" class="{{ $index == 0 ? 'active' : '' }}">{{ $category }}</button>
                        @endforeach
                    </div>
                    <i class="fas fa-chevron-right arrow-indicator text-light"></i> <!-- Icona di freccia visibile solo su mobile -->

                </div>
            </div>
        </div>
        <div class="row justify-content-center g-4 mt-5 filter_group">

            @foreach ($section->items as $item)
            @php
            // Trasforma gli elementi dell'array rimuovendo spazi e aggiungendo trattini.
            $classArray = array_map(function($value) {
            return str_replace(' ', '-', $value);
            }, $item->settings['categories_item']);

            // Unisci gli elementi dell'array in una stringa separata da spazi.
            $classString = implode(' ', $classArray);
            @endphp
            <div class="col-xxl-2 col-xl-3 col-md-4 col-sm-6 col-6 filter_item {{$classString}}">
                <div class="item-filter">
                    <img src="{{ uploadedAsset($item->settings['image']) }}" alt="{{ $item->settings['title'] }}" class="img-fluid mb-3">
                    <a href="{{$item->settings['url']}}" class="title" title="{{ $item->settings['title'] }}">{{ $item->settings['title'] }}</a>
                    <span>{{localize('Scopri di più')}}</span>
                </div>
            </div>

            @endforeach
            <!-- Devo capire come salvare l'url di ogni categoria -->
            @if (!empty($categoryDetails['url']))
            <div class="col-12 text-center mt-4 filter_item {{ str_replace(' ', '-', $categoryName ) }}">
                <a href="{{ $categoryDetails['url'] }}" class="btn btn-primary">Scoprili tutti</a>
            </div>
            @endif
        </div>
    </div>

</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterOptions = document.querySelector('.filter-options');
        const arrowIndicator = document.querySelector('.arrow-indicator');

        function checkOverflow() {
            const filterOptions = document.querySelector('.filter-options');
            if (filterOptions.offsetWidth < filterOptions.scrollWidth) {
                arrowIndicator.style.display = 'inline';
                filterOptions.style.overflowX = 'auto';
                filterOptions.style.overflowY = 'hidden';
            } else {
                arrowIndicator.style.display = 'none';
                filterOptions.style.overflowX = 'visible';
                filterOptions.style.overflowY = 'visible';
            }
        }

        // Esegui la verifica al caricamento della pagina
        checkOverflow();

        // Aggiungi un listener per verificare l'overflow quando la finestra viene ridimensionata
        window.addEventListener('resize', checkOverflow);
    });
</script>