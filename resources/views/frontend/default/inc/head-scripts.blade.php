<script>
    'use strict'

    var TT = TT || {};
    TT.localize = {
        buyNow: '{{ localize('Buy Now') }}',
        addToCart: '{{ localize('Add to Cart') }}',
        outOfStock: '{{ localize('Out of Stock') }}',
        addingToCart: '{{ localize('Adding..') }}',
        optionsAlert: '{{ localize('Please choose all the available options') }}',
        applyCoupon: '{{ localize('Apply Coupon') }}',
        pleaseWait: '{{ localize('Please Wait') }}',
    }

    TT.ProductSliders = () => {
        let quickViewProductSlider = new Swiper(".quickview-product-slider", {
            slidesPerView: 1,
            centeredSlides: true,
            speed: 700,
            loop: true,
            loopedSlides: 6,
        });
        let productThumbnailSlider = new Swiper(".product-thumbnail-slider", {
            slidesPerView: 4,
            speed: 700,
            loop: true,
            spaceBetween: 20,
            slideToClickedSlide: true,
            loopedSlides: 6,
            centeredSlides: true,
            breakpoints: {
                0: {
                    slidesPerView: 2,
                },
                380: {
                    slidesPerView: 3,
                },
                576: {
                    slidesPerView: 4,
                },
            },
        });
        if (quickViewProductSlider && quickViewProductSlider.length > 0) {
            quickViewProductSlider.forEach(function(item, index) {
                item.controller.control = productThumbnailSlider[index];
                productThumbnailSlider[index].controller.control = item;
            });
        } else {
            quickViewProductSlider.controller.control = productThumbnailSlider;
            productThumbnailSlider.controller.control = quickViewProductSlider;
        }
    }
</script>
