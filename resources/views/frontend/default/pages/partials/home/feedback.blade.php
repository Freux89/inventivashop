<section class="ptb-120 bg-shade position-relative overflow-hidden z-1 feedback-section">
   
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6">
                <div class="section-title text-center">
                    <h2 class="mb-6">{{ localize('What Our Clients Say') }}</h2>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="gshop-feedback-slider-wrapper">
                    <div class="swiper gshop-feedback-thumb-slider">
                        <div class="swiper-wrapper">
                            @foreach ($client_feedback as $feedback)
                                <div class="swiper-slide control-thumb">
                                  
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="swiper gshop-feedback-slider mt-4">
                        <div class="swiper-wrapper">
                            @foreach ($client_feedback as $feedback)
                                <div class="swiper-slide feedback-single text-center">
                                    <p class="mb-5">{{ $feedback->review }}</p>
                                    <span
                                        class="clients_name text-dark fw-bold d-block mb-1">{{ $feedback->name }}</span>
                                    <ul class="star-rating fs-sm d-inline-flex align-items-center text-warning">
                                        {{ renderStarRatingFront($feedback->rating) }}
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
