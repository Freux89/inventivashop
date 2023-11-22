@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">

@endsection
<div class="quickview-double-slider">
    @php
        $galleryImages = explode(',', $product->gallery_images);
    @endphp
    <div class="quickview-product-slider swiper">
        <div class="swiper-wrapper">
            @foreach ($galleryImages as $galleryImage)
                <div class="swiper-slide text-center">
                <a href="{{ uploadedAsset($galleryImage) }}" data-lightbox="product-gallery">
                        <img src="{{ uploadedAsset($galleryImage) }}" alt="{{ $product->collectLocalization('name') }}" class="img-fluid">
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    <div class="product-thumbnail-slider swiper mt-80">
        <div class="swiper-wrapper">
            @foreach ($galleryImages as $galleryImage)
                <div
                    class="swiper-slide product-thumb-single rounded-2 d-flex align-items-center justify-content-center">
                    <img src="{{ uploadedAsset($galleryImage) }}?thumb"
                        alt="{{ $product->collectLocalization('name') }}" class="img-fluid">
                </div>
            @endforeach

        </div>
    </div>
</div>
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>


@endsection