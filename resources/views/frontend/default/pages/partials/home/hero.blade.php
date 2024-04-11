<section class="gshop-hero pt-4 bg-white position-relative z-1 overflow-hidden">
    

    <div class="container">
    <div class="promo-banner text-center py-1">
        Spedizioni gratuite per ordini a partire da 50€!
    </div>
        <div class="gshop-hero-slider swiper">
            <div class="swiper-wrapper">

                @foreach ($sliders as $slider)
                    <div class="swiper-slide gshop-hero-single">
                        <div class="row align-items-center justify-content-between">
                        <div class="col-7 p-0">
                                <div class="hero-left text-center position-relative z-1 mt-6 mt-xl-0">

                                    <img src="{{ uploadedAsset($slider->image) }}" alt=""
                                        class="img-fluid position-absolute end-0 top-50 hero-img">

                                   
                                </div>
                            </div>
                            <div class="col-5 p-0">
                                <div class="hero-right-content bg-secondary-9 p-9">
                                   {{--
                                    <span
                                        class="gshop-subtitle fs-5 text-secondary mb-2 d-block">{{ $slider->sub_title }}</span>
                                    --}}
                                    <h1 class="display-4 mb-3">{{ $slider->title }}</h1>
                                    <p class="mb-9 fs-6">{{ $slider->text }}</p>

                                    <div class="hero-btns d-flex align-items-center gap-3 gap-sm-5 flex-wrap">
                                        <a href="{{ $slider->link }}"
                                            class="btn btn-primary">{{ localize('Scopri') }}</a>
                                        <a href="{{ route('home.pages.aboutUs') }}"
                                            class="btn btn-primary">{{ localize('Crea') }}</a>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    {{-- 
        <div class="at-header-social d-none d-xl-flex align-items-center position-absolute">
        <span class="title fw-medium">{{ localize('Follow on') }}</span>
        <ul class="social-list ms-3">
            <li>
                <a href="{{ getSetting('facebook_link') }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
            </li>
            <li><a href="{{ getSetting('twitter_link') }}" target="_blank"><i class="fab fa-twitter"></i></a></li>
            <li><a href="{{ getSetting('linkedin_link') }}" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
            <li><a href="{{ getSetting('youtube_link') }}" target="_blank"><i class="fab fa-youtube"></i></a></li>
        </ul>
    </div>
        --}}
    
    <div class="gshop-hero-slider-pagination theme-slider-control position-absolute top-50 translate-middle-y z-5">
    </div>
</section>
