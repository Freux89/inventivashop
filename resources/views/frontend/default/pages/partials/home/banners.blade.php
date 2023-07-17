<section class="banner-section position-relative z-1 overflow-hidden bg-white">
    <img src="{{ staticAsset('frontend/default/assets/img/shapes/bg-shape-3.png') }}" alt="bg shape"
        class="position-absolute start-0 bottom-0 z--1 w-100">
    <div class="container">
        <div class="row align-items-center g-4">
            @foreach ($banner_section_one_banners as $banner)
                <div class="col-xl-4 col-md-6">
                    <a href="{{ $banner->link }}" class="d-block">
                        <img src="{{ uploadedAsset($banner->image) }}" class="img-fluid" alt="" srcset="">
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
