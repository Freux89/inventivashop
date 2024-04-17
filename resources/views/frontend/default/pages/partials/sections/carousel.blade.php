<!-- Swiper -->
<section class="carousel-section bg-white py-9 position-relative z-1 overflow-hidden">

    <div class="content-wrapper">
        <div class="section-title"> {{localize('I più venduti')}} </div>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">

                @for ($i = 1; $i <= 8; $i++) 
                    <div class="swiper-slide">
                        <img src="{{ uploadedAsset(58) }}" alt="Image {{ $i }}" class="img-fluid">
                        <div class="title">Title {{ $i }}</div>
                        <ul class="star-rating fs-sm d-inline-flex text-warning">
                            {{ renderStarRatingFront(4,5) }}
                        </ul>
                    </div>
                @endfor

            </div>
       
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
<!-- Include Swiper's JS -->