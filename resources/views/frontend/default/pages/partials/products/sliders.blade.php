@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
@endsection
@php
        $galleryImages = explode(',', $product->gallery_images);
    @endphp
    <div class="quickview-double-slider d-flex" >
    <!-- Slider principale del prodotto -->
    <div class="quickview-product-slider swiper me-1" style="width: 80%;">
        <div class="swiper-wrapper">
            @foreach ($galleryImages as $galleryImage)
            @php
        // Recupera i dettagli dell'immagine dalla tabella media_managers
        $media = \App\Models\MediaManager::find($galleryImage);
        // Imposta l'alt con il nome del prodotto se l'alt dell'immagine non è presente
        $altText = $media && $media->alt_text ? $media->alt_text : $product->collectLocalization('name');
        // Ottieni la descrizione dell'immagine
        $description = $media ? $media->description : '';
    @endphp
    <div class="swiper-slide text-center">
        <a href="{{ uploadedAsset($galleryImage) }}" data-lightbox="product-gallery" data-title="{{ $description }}">
            <img src="{{ uploadedAsset($galleryImage) }}" alt="{{ $altText }}" class="img-fluid">
        </a>
    </div>
            @endforeach
        </div>
    </div>
    <!-- Slider delle thumbnails -->
    <div class="product-thumbnail-slider swiper" style="width: 20%;">
        <div class="swiper-wrapper">
            @foreach ($galleryImages as $galleryImage)
                <div class="swiper-slide product-thumb-single rounded-2 d-flex align-items-center justify-content-center">
                    <img src="{{ uploadedAsset($galleryImage) }}?thumb" alt="{{ $product->collectLocalization('name') }}" class="img-fluid">
                </div>
            @endforeach
        </div>
    </div>
</div>
<script>
  function adjustThumbnailHeight() {
    const productSliderHeight = document.querySelector('.quickview-product-slider .swiper-slide-active img').clientHeight;
    const thumbnailSlider = document.querySelector('.product-thumbnail-slider');

    if (thumbnailSlider) {
        thumbnailSlider.style.height = `${productSliderHeight}px`; // Imposta l'altezza delle thumbnails uguale allo slider principale

        const slides = document.querySelectorAll('.product-thumbnail-slider .swiper-slide');
        slides.forEach(slide => {
            slide.style.height = `calc((100% - 40px) / 4)`; // Distribuisce equamente l'altezza per 4 slides
        });
    }
}



</script>

