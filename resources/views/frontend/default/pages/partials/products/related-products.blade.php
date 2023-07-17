<section class="related-product-slider pb-120">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-sm-8">
                <div class="section-title text-center text-sm-start">
                    <h2 class="mb-0">{{ localize('You may be interested') }}</h2>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="rl-slider-btns text-center text-sm-end mt-3 mt-sm-0">
                    <button class="rl-slider-btn slider-btn-prev"><i class="fas fa-arrow-left"></i></button>
                    <button class="rl-slider-btn slider-btn-next ms-3"><i class="fas fa-arrow-right"></i></button>
                </div>
            </div>
        </div>
        <div class="rl-products-slider swiper mt-8">
            <div class="swiper-wrapper">
                @forelse ($relatedProducts as $relatedProduct)
                    <!-- veritcal product card -->
                    @include('frontend.default.pages.partials.products.vertical-product-card', [
                        'product' => $relatedProduct,
                        'bgClass' => 'bg-white',
                    ])
                    <!-- veritcal product card -->
                @empty
                    <div class="mx-auto w-50 w-md-25">

                        <img src="{{ staticAsset('frontend/default/assets/img/empty-cart.svg') }}" alt=""
                            srcset="" class="img-fluid">
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</section>
