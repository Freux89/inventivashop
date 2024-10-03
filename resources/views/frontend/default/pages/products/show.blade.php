@extends('frontend.default.layouts.master')

@php
$detailedProduct = $product;
@endphp

@section('title')
@if ($detailedProduct->meta_title)
{{ $detailedProduct->meta_title }}
@else
{{ localize('Product Details') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endif
@endsection

@section('meta_description')
{{ $detailedProduct->meta_description }}
@endsection

@section('meta_keywords')
@foreach ($detailedProduct->tags as $tag)
{{ $tag->name }} @if (!$loop->last)
,
@endif
@endforeach
@endsection

@section('meta')
<!-- Schema.org markup for Google+ -->
<meta itemprop="name" content="{{ $detailedProduct->meta_title }}">
<meta itemprop="description" content="{{ $detailedProduct->meta_description }}">
<meta itemprop="image" content="{{ uploadedAsset($detailedProduct->meta_img) }}">

<!-- Twitter Card data -->
<meta name="twitter:card" content="product">
<meta name="twitter:site" content="@publisher_handle">
<meta name="twitter:title" content="{{ $detailedProduct->meta_title }}">
<meta name="twitter:description" content="{{ $detailedProduct->meta_description }}">
<meta name="twitter:creator" content="@author_handle">
<meta name="twitter:image" content="{{ uploadedAsset($detailedProduct->meta_img) }}">
<meta name="twitter:data1" content="{{ formatPrice($detailedProduct->min_price) }}">
<meta name="twitter:label1" content="Price">

<!-- Open Graph data -->
<meta property="og:title" content="{{ $detailedProduct->meta_title }}" />
<meta property="og:type" content="og:product" />
<meta property="og:url" content="{{ route('products.show', $detailedProduct->slug) }}" />
<meta property="og:image" content="{{ uploadedAsset($detailedProduct->meta_img) }}" />
<meta property="og:description" content="{{ $detailedProduct->meta_description }}" />
<meta property="og:site_name" content="{{ getSetting('meta_title') }}" />
<meta property="og:price:amount" content="{{ formatPrice($detailedProduct->min_price) }}" />
<meta property="product:price:currency" content="{{ env('DEFAULT_CURRENCY') }}" />
<meta property="fb:app_id" content="{{ env('FACEBOOK_PIXEL_ID') }}">
<link rel="canonical" href="{{ route('products.show', $product->slug) }}">
@endsection






@section('contents')
<!--breadcrumb-->

<!--breadcrumb-->

<!--product details start-->
@include('frontend.default.pages.partials.sections.hook',['hook_name' => 'hook_before_content'])
@php
// Crea il percorso breadcrumb concatenando gli slug delle categorie
$breadcrumbPath = $breadcrumbs->pluck('slug')->implode('/');
@endphp
<section class="product-details-area ptb-4">
    <div class="content-wrapper">
        <div class="row g-4">
            <div class="col-xl-12">
                <div class="product-details">
                    <!-- product-view-box -->

                    @include('frontend.default.pages.partials.products.product-view-box',
                    compact('product'))
                    <!-- product-view-box -->

                    <!-- description -->
                    @include(
                    'frontend.default.pages.partials.products.description',
                    compact('product'))
                    <!-- description -->
                </div>

                <!-- <div class="col-xl-3 col-lg-6 col-md-8 d-none d-xl-block">
                    <div class="gshop-sidebar">
                        <div class="sidebar-widget info-sidebar bg-white rounded-3 py-3">
                            @foreach ($product_page_widgets as $widget)
                            <div class="sidebar-info-list d-flex align-items-center gap-3 p-4">
                                <span class="icon-wrapper d-inline-flex align-items-center justify-content-center rounded-circle text-primary">
                                    <img src="{{ uploadedAsset($widget->image) }}" class="img-fluid" alt="">
                                </span>
                                <div class="info-right">
                                    <h6 class="mb-1 fs-md">{{ $widget->title }}</h6>
                                    <span class="fw-medium fs-xs">{{ $widget->sub_title }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="sidebar-widget banner-widget mt-4">
                            <a href="{{ getSetting('product_page_banner_link') }}">
                                <img src="{{ uploadedAsset(getSetting('product_page_banner')) }}" alt="" class="img-fluid">
                            </a>
                        </div>

                    </div>
                </div> -->
            </div>
        </div>
</section>
<!--product details end-->
@if (!empty($relatedProducts) && count($relatedProducts) > 0)
<!--related product slider start -->
{{--
@include('frontend.default.pages.partials.products.related-products', [
    'relatedProducts' => $relatedProducts,
])
--}}

@endif
<!--related products slider end-->
@include('frontend.default.pages.partials.sections.hook',['hook_name' => 'hook_after_content'])
@endsection


@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sticky-kit/1.1.3/sticky-kit.min.js"></script>

<script>
    let isAutoSelecting = false;
    const viewModes = {}; // Oggetto per tracciare la modalità di visualizzazione per ogni variante



    function showLoading() {
        $('.loading-overlay').css('visibility', 'visible').addClass('visible');
    }

    function hideLoading() {
        $('.loading-overlay').removeClass('visible');
        // Attendi la fine della transizione prima di impostare `visibility` su `hidden`
        $('.loading-overlay').css('visibility', 'hidden');

    }

    function initializeSwiper() {
        const swiperViews = [];




        function updateArrows(swiperInstance) {
            const totalSlides = swiperInstance.slides.length;
            const activeIndex = swiperInstance.activeIndex;

            const prevArrow = swiperInstance.el.querySelector('.swiper-button-prev');
            const nextArrow = swiperInstance.el.querySelector('.swiper-button-next');

            prevArrow.style.display = activeIndex === 0 ? 'none' : 'flex';
            nextArrow.style.display = (activeIndex >= totalSlides - swiperInstance.params.slidesPerView) ? 'none' : 'flex';
        }

        function selectFirstEnabledSlide(swiperInstance) {
            const slides = swiperInstance.el.querySelectorAll('.swiper-slide .gallery-item-block');
            let firstEnabledSlide = null;

            slides.forEach(slide => {
                if (!slide.classList.contains('disabled') && !firstEnabledSlide) {
                    firstEnabledSlide = slide;
                }
            });

            if (firstEnabledSlide) {
                slides.forEach(s => s.classList.remove('selected'));
                firstEnabledSlide.classList.add('selected');
                firstEnabledSlide.querySelector('input[type="radio"]').checked = true;
                isAutoSelecting = true;
            }
        }

        document.querySelectorAll('.swiper-container').forEach(swiperContainer => {
            const variationId = swiperContainer.getAttribute('data-variation-id');
            const swiper = new Swiper(swiperContainer, {
                slidesPerView: 5,
                spaceBetween: 0,
                threshold: 30,
                    navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    300: {
                        slidesPerView: 2,
                        spaceBetween: 0
                    },
                    576: {
                        slidesPerView: 3,
                        spaceBetween: 0
                    },
                    768: {
                        slidesPerView: 4,
                        spaceBetween: 0
                    },
                    992: {
                        slidesPerView: 4,
                        spaceBetween: 0
                    },
                    1200: {
                        slidesPerView: 5,
                        spaceBetween: 0
                    }
                },
                on: {
                    init: function() {
                        const slides = this.el.querySelectorAll('.swiper-slide .gallery-item-block');
                        slides.forEach(slide => {
                            slide.addEventListener('click', function() {
                                if (!this.classList.contains('disabled')) {
                                    slides.forEach(s => s.classList.remove('selected'));
                                    this.classList.add('selected');
                                    this.querySelector('input[type="radio"]').checked = true;
                                    if (!isAutoSelecting) {
                                        showLoading();
                                        getVariationInfo();
                                    }
                                    isAutoSelecting = false;
                                    syncGridWithSwiper(this.dataset.valueId);
                                }
                            });
                        });
                        updateArrows(this);
                    },
                    slideChange: function() {
                        updateArrows(this);
                    },
                }
            });
            const selectedSlide = swiperContainer.querySelector('.swiper-slide[data-selected="true"]');

if (selectedSlide) {
    // Trovare l'indice dell'elemento selezionato
    const selectedIndex = Array.from(swiperContainer.querySelectorAll('.swiper-slide')).indexOf(selectedSlide);

    // Scorrere verso l'elemento selezionato
    swiper.slideTo(selectedIndex);
}

            // Ripristina la modalità di visualizzazione corretta
            if (viewModes[variationId] === 'grid') {
                const gridContainer = document.querySelector(`.grid-container[data-variation-id="${variationId}"]`);
                const showButton = document.querySelector(`.variant-block[data-variation-id="${variationId}"] .toggle-view[data-action="show"]`);
                const hideButton = document.querySelector(`.variant-block[data-variation-id="${variationId}"] .toggle-view[data-action="hide"]`);


                if (gridContainer) {
                    gridContainer.classList.remove('d-none');
                    swiperContainer.classList.add('d-none');
                    showButton.classList.add('d-none');
                    hideButton.classList.remove('d-none');
                }
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        initializeSwiper();
        initializeGrid();
        setupToggleView();
        initializeInfoIconEvents();
        initializeGridInfoIconEvents();
        initializeSelectInfoIconEvents();
    });



    // Funzione per inizializzare la griglia
    function initializeGrid() {
        const gridItems = document.querySelectorAll('.grid-item');
        gridItems.forEach(item => {
            item.addEventListener('click', function() {
                if (!this.classList.contains('disabled')) {
                    gridItems.forEach(i => i.classList.remove('selected'));
                    this.classList.add('selected');
                    syncSwiperWithGrid(this.dataset.valueId);
                }
            });
        });

    }

    // Funzione per sincronizzare la griglia con lo swiper
    function syncGridWithSwiper(valueId) {
        const gridItems = document.querySelectorAll('.grid-item');
        gridItems.forEach(item => {
            if (item.dataset.valueId === valueId) {
                item.classList.add('selected');
            } else {
                item.classList.remove('selected');
            }
        });
    }

    // Funzione per sincronizzare lo swiper con la griglia
    function syncSwiperWithGrid(valueId) {
        const swiperItems = document.querySelectorAll('.swiper-slide .gallery-item-block');
        swiperItems.forEach(item => {
            if (item.dataset.valueId === valueId) {
                item.classList.add('selected');
                item.querySelector('input[type="radio"]').checked = true;
            } else {
                item.classList.remove('selected');
            }
        });
        showLoading();
        getVariationInfo();
    }

    // Funzione per impostare il pulsante di cambio vista
    function setupToggleView() {
        document.querySelectorAll('.toggle-view').forEach(button => {
            button.addEventListener('click', function() {

                const variationId = button.closest('[data-variation-id]').getAttribute('data-variation-id');
                const swiperContainer = document.querySelector(`.swiper-container[data-variation-id="${variationId}"]`);
                const gridContainer = document.querySelector(`.grid-container[data-variation-id="${variationId}"]`);

                const showButton = button.closest('.toggle-buttons').querySelector('.toggle-view[data-action="show"]');
                const hideButton = button.closest('.toggle-buttons').querySelector('.toggle-view[data-action="hide"]');
                // Gestione del modal associato allo swiper
// Gestione del modal associato allo swiper
const infoModal = document.querySelector('#info-description-modal');
if (infoModal) {
    infoModal.remove();
}
const infoGridModal = document.querySelector('#grid-info-description');
if (infoGridModal) {
    infoGridModal.innerHTML = '';
    infoGridModal.style.display = 'none';
}

                if (gridContainer.classList.contains('d-none')) {
                    gridContainer.classList.remove('d-none');
                    swiperContainer.classList.add('d-none');
                    viewModes[variationId] = 'grid';
                    showButton.classList.add('d-none');
                    hideButton.classList.remove('d-none');
                    // Aggiorna la modalità corrente per la variante
                } else {
                    gridContainer.classList.add('d-none');
                    swiperContainer.classList.remove('d-none');
                    viewModes[variationId] = 'swiper'; // Aggiorna la modalità corrente per la variante

                    showButton.classList.remove('d-none');
                    hideButton.classList.add('d-none');
                }
            });
        });
    }

    function initializeInfoIconEvents() {
    document.querySelectorAll('.swiper-slide .info-icon').forEach(function (element) {
        element.addEventListener('click', function (event) {
            event.stopPropagation(); // Impedisce la propagazione dell'evento
            var valueId = this.getAttribute('data-value-id');
            var swiperContainer = this.closest('.variant-block');
            var existingModal = swiperContainer.querySelector('#info-description-modal');

            // Controlla se il modal è già aperto per questa icona
            if (existingModal && existingModal.getAttribute('data-info-id') === valueId) {
                $(existingModal).stop(true, true).slideUp(500, function () {
                    existingModal.remove();
                });
                return; // Esci dalla funzione perché il modal è stato chiuso
            }

            fetch(`/variation-value-info/${valueId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.html) {
                        // Rimuovi eventuali vecchi modali per evitare duplicati
                        document.querySelectorAll('#info-description-modal').forEach(function (modal) {
                            modal.remove();
                        });

                        // Inserisci l'HTML del modal restituito dal server
                        const modal = document.createElement('div');
                        modal.id = 'info-description-modal'; // Assegna l'ID qui
                        modal.setAttribute('data-info-id', valueId); // Salva l'id dell'info nel modal
                        modal.innerHTML = data.html;
                        swiperContainer.appendChild(modal);

                        $(modal).stop(true, true).slideDown(500);

                        // Inizializza Swiper per lo slider delle immagini info
                        new Swiper('.info-swiper', {
                            slidesPerView: 1,
                            centeredSlides: true,
                            speed: 700,
                            loop: true,
                            loopedSlides: 6,
                            navigation: {
                                nextEl: '.swiper-button-next',
                                prevEl: '.swiper-button-prev',
                            },
                        });

                        // Aggiungi l'evento di chiusura al bottone del modal
                        modal.querySelector('#close-info-description').addEventListener('click', function () {
                            $(modal).stop(true, true).slideUp(500, function () {
                                modal.remove();
                            });
                        });
                    }
                });
        });
    });
    
}


// Funzione per inizializzare l'evento del click sull'icona info
function initializeSelectInfoIconEvents() {
        document.querySelectorAll('.info-icon-select').forEach(function (element) {
            element.addEventListener('click', function (event) {
                event.stopPropagation(); // Impedisce la propagazione dell'evento
                var valueId = this.getAttribute('data-value-id');
                var variantContainer = this.closest('.variant-select-block'); 
                var modalContainer = variantContainer.nextElementSibling; // Il div immediatamente successivo


                
            if (!modalContainer || !modalContainer.classList.contains('modal-container')) {
                modalContainer = document.createElement('div');
                modalContainer.classList.add('modal-container');
                variantContainer.insertAdjacentElement('afterend', modalContainer);
            }
                var existingModal = modalContainer.querySelector('#info-description-modal');

                // Controlla se il modal è già aperto per questa icona
                if (existingModal && existingModal.getAttribute('data-info-id') === valueId) {
                    $(existingModal).stop(true, true).slideUp(500, function () {
                        existingModal.remove();
                    });
                    return; // Esci dalla funzione perché il modal è stato chiuso
                }

                // Fetch dei dati del valore selezionato
                fetch(`/variation-value-info/${valueId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.html) {
                            // Rimuovi eventuali vecchi modali per evitare duplicati
                            document.querySelectorAll('#info-description-modal').forEach(function (modal) {
                                modal.remove();
                            });

                            // Inserisci l'HTML del modal restituito dal server
                            const modal = document.createElement('div');
                            modal.id = 'info-description-modal'; // Assegna l'ID qui
                            modal.setAttribute('data-info-id', valueId); // Salva l'id dell'info nel modal
                            modal.innerHTML = data.html;
                            modalContainer.appendChild(modal);

                            $(modal).stop(true, true).slideDown(500);

                            // Inizializza Swiper per lo slider delle immagini info se presente
                            new Swiper('.info-swiper', {
                                slidesPerView: 1,
                                centeredSlides: true,
                                speed: 700,
                                loop: true,
                                loopedSlides: 6,
                                navigation: {
                                    nextEl: '.swiper-button-next',
                                    prevEl: '.swiper-button-prev',
                                },
                            });

                            // Aggiungi l'evento di chiusura al bottone del modal
                            modal.querySelector('#close-info-description').addEventListener('click', function () {
                                $(modal).stop(true, true).slideUp(500, function () {
                                    modal.remove();
                                });
                            });
                        }
                    });
            });
        });
    }


function initializeGridInfoIconEvents() {
    document.querySelectorAll('.grid-item .info-icon').forEach(function (element) {
        element.addEventListener('click', function (event) {
            event.stopPropagation(); // Impedisce la propagazione dell'evento
            var valueId = this.getAttribute('data-value-id');
            var gridItem = this.closest('.grid-item');
            var gridContainer = gridItem.closest('.grid-container'); // Ottenere il contenitore della griglia
            var modal = $('#grid-info-description');

            // Controlla se il modal è già aperto
            if (modal.is(':visible') && modal.data('info-id') === valueId) {
                modal.stop(true, true).slideUp(500);
                return; // Esci dalla funzione perché il modal è stato chiuso
            }

            fetch(`/variation-value-info/${valueId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.html) {
                        const content = $('#grid-info-description');
                        
                        content.html(data.html);
                        const $gridItem = $(gridItem);
                        const $gridContainer = $(gridContainer); // Convertire in oggetto jQuery

                        modal.insertAfter($gridItem);
                        modal.css({
                            top: $gridItem.position().top + $gridItem.outerHeight(),
                            left: $gridContainer.position().left, // Posizionare a sinistra rispetto al contenitore
                            width: $gridContainer.outerWidth() // Impostare la larghezza uguale a quella del contenitore
                        });

                        modal.data('info-id', valueId); // Salva l'id dell'info nel modal
                        modal.stop(true, true).slideDown(500);

                        new Swiper('.info-swiper', {
                            slidesPerView: 1,
                            centeredSlides: true,
                            speed: 700,
                            loop: true,
                            loopedSlides: 6,
                            navigation: {
                                nextEl: '.swiper-button-next',
                                prevEl: '.swiper-button-prev',
                            },
                        });

                        $('#close-info-description').on('click', function () {
                            $('#grid-info-description').stop(true, true).slideUp(500);
                        });

                        // Rimuovi l'evento di click fuori dal modal
                        $(document).off('click.gridInfoModal');
                    }
                });
        });
    });
}



    document.addEventListener('DOMContentLoaded', function() {
        var summaryContent = document.getElementById('summaryContent');
        var toggleIcon = document.getElementById('toggleSummaryIcon');

        summaryContent.addEventListener('show.bs.collapse', function() {
            toggleIcon.classList.remove('fa-chevron-down');
            toggleIcon.classList.add('fa-chevron-up');
        });

        summaryContent.addEventListener('hide.bs.collapse', function() {
            toggleIcon.classList.remove('fa-chevron-up');
            toggleIcon.classList.add('fa-chevron-down');
        });
    });
</script>



@endsection