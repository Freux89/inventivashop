<section class="position-relative banner-section z-1 overflow-hidden">
   
    <div class="container">
        <div class="row g-4">
            <div class="col-xl-8">
                <a href="{{ getSetting('banner_section_two_banner_one_link') }}">
                    <img src="img-fluid w-100 h-100" alt=""
                        srcset="{{ uploadedAsset(getSetting('banner_section_two_banner_one')) }}" class="img-fluid w-100 h-100">
                </a>
            </div>
            <div class="col-xl-4 d-none d-xl-block">
                <a href="{{ getSetting('banner_section_two_banner_two_link') }}">
                    <img src="{{ uploadedAsset(getSetting('banner_section_two_banner_two')) }}" alt=""
                        srcset="" class="img-fluid w-100 h-100">
                </a>
            </div>
        </div>
    </div>
</section>
