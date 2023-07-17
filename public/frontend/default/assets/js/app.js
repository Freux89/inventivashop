/*================
 Template Name: gShop - Grocery eCommerce HTML Template
 Description: Multipurpose eCommerce html template a responsive eCommerce template.
 Version: 1.0
 Author: https://themeforest.net/user/themetags
=======================*/
// TABLE OF CONTENTS
// 1. preloader
// 2. swiper slider for all carousel

jQuery(function ($) {
    "use strict";

    //preloader
    $(window).ready(function () {
        $("#preloader").delay(100).fadeOut("fade");
    });

    //1. data background
    $("[data-background]").each(function () {
        var $data_bg = $(this).attr("data-background");
        $(this).css({
            "background-image": "url(" + $data_bg + ")",
        });
    });

    //2. Scroll to Top
    $(window).on("scroll", function () {
        let scrollbarPosition = $(this).scrollTop();
        if (scrollbarPosition > 150) {
            $(".scroll-top-btn").addClass("active");
        } else {
            $(".scroll-top-btn").removeClass("active");
        }
    });
    $(".scroll-top-btn").on("click", function () {
        $("body,html").animate({
            scrollTop: 0,
        });
    });

    //3.sticky header
    $(window).on("scroll", function () {
        let scrollbarPosition = $(this).scrollTop();
        if (scrollbarPosition > 100) {
            $(".header-sticky").addClass("sticky-on");
        } else {
            $(".header-sticky").removeClass("sticky-on");
        }
    });

    // 2. swiper slider for all carousel
    var sliderSelector = ".custom-swiper",
        defaultOptions = {
            breakpointsInverse: true,
            observer: true,
        };
    $(sliderSelector).each(function (i, slider) {
        var data = $(slider).attr("data-swiper") || {};
        if (data) {
            var dataOptions = JSON.parse(data);
        }
        slider.options = $.extend({}, defaultOptions, dataOptions);
        var swiper = new Swiper(slider, slider.options);

        /* stop on hover */
        if (typeof slider.options.autoplay !== "undefined") {
            $(slider).on(
                "hover",
                function () {
                    swiper.autoplay.stop();
                },
                function () {
                    swiper.autoplay.start();
                }
            );
        }

        /* stop on hover */
        if (
            typeof slider.options.autoplay !== "undefined" &&
            slider.options.autoplay !== false
        ) {
            slider.addEventListener("mouseenter", function () {
                swiper.autoplay.stop();
            });
            slider.addEventListener("mouseleave", function () {
                swiper.autoplay.start();
            });
        }
    });

    //3. All Carousel
    let gShopHeroSlider = new Swiper(".gshop-hero-slider", {
        slidesPerView: 1,
        autoplay: {
            delay: 5000,
        },
        delay: 2500,
        speed: 700,
        effect: "fade",
        fadeEffect: {
            crossFade: true,
        },
        pagination: {
            el: ".gshop-hero-slider-pagination",
            type: "bullets",
            clickable: true,
        },
    });
    let gshopFeedbackControl = new Swiper(".gshop-feedback-thumb-slider", {
        slidesPerView: 5,
        loop: true,
        centeredSlides: true,
        effect: "coverflow",
        slideToClickedSlide: true,
        autoplay: true,
        coverflowEffect: {
            rotate: 0,
            stretch: 90,
            depth: 120,
            modifier: 1.5,
            slideShadows: false,
        },
    });
    let gshopFeedbackSlider = new Swiper(".gshop-feedback-slider", {
        slidesPerView: 1,
        centeredSlides: true,
        autoplay: true,
        speed: 700,
        loop: true,
        loopedSlides: 6,
    });
    gshopFeedbackSlider.controller.control = gshopFeedbackControl;
    gshopFeedbackControl.controller.control = gshopFeedbackSlider;
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
        quickViewProductSlider.forEach(function (item, index) {
            item.controller.control = productThumbnailSlider[index];
            productThumbnailSlider[index].controller.control = item;
        });
    } else {
        quickViewProductSlider.controller.control = productThumbnailSlider;
        productThumbnailSlider.controller.control = quickViewProductSlider;
    }
    let rlProductSlider = new Swiper(".rl-products-slider", {
        slidesPerView: 4,
        speed: 700,
        autoplay: true,
        spaceBetween: 24,
        loop: true,
        navigation: {
            prevEl: ".rl-slider-btn.slider-btn-prev",
            nextEl: ".rl-slider-btn.slider-btn-next",
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
            992: {
                slidesPerView: 3,
            },
            1400: {
                slidesPerView: 4,
            },
        },
    });
    let blogCarousel = new Swiper(".blog-carousel", {
        slidesPerView: 1,
        speed: 700,
        autoplay: true,
        spaceBetween: 24,
        loop: true,
        pagination: {
            el: ".blog-carousel-control",
            clickable: true,
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            992: {
                slidesPerView: 2,
            },
            1200: {
                slidesPerView: 1,
            },
        },
    });
    let feedbackSlider2 = new Swiper(".feedback-slider-2", {
        slidesPerView: 1,
        speed: 700,
        autoplay: true,
        spaceBetween: 24,
        loop: true,
        navigation: {
            prevEl: ".fd2-arrow-left",
            nextEl: ".fd2-arrow-right",
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
            1200: {
                slidesPerView: 1,
            },
        },
    });
    let brandSlider = new Swiper(".brands-slider", {
        slidesPerView: 5,
        speed: 700,
        autoplay: true,
        spaceBetween: 24,
        loop: true,
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            550: {
                slidesPerView: 2,
            },
            992: {
                slidesPerView: 3,
            },
            1200: {
                slidesPerView: 4,
            },
            1400: {
                slidesPerView: 5,
            },
        },
    });
    let teamSlider = new Swiper(".team-slider", {
        slidesPerView: 3,
        autoplay: true,
        speed: 700,
        spaceBetween: 24,
        navigation: {
            nextEl: ".team-slider-next-btn",
            prevEl: ".team-slider-prev-btn",
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            550: {
                slidesPerView: 2,
            },
            1200: {
                slidesPerView: 3,
            },
        },
    });
    let healthCareHeroSlider = new Swiper(".healthcare-hero-slider", {
        slidesPerView: 1,
        autoplay: true,
        speed: 1000,
        spaceBetween: 24,
        loop: true,
        loopedSlides: 6,
    });
    let healthCareThumbnailSlider = new Swiper(
        ".healthcare-hero-thumbnail-slider",
        {
            slidesPerView: 3,
            centeredSlides: true,
            autoplay: true,
            slideToClickedSlide: true,
            loop: true,
            loopedSlides: 6,
            spaceBetween: -24,
            speed: 1000,
        }
    );
    healthCareHeroSlider.controller.control = healthCareThumbnailSlider;
    healthCareThumbnailSlider.controller.control = healthCareHeroSlider;
    let offerProductSlider = new Swiper(".offer-product-slider", {
        slidesPerView: 4,
        autoplay: true,
        speed: 700,
        spaceBetween: 24,
        loop: true,
        navigation: {
            nextEl: ".ofp-slider-next",
            prevEl: ".ofp-slider-prev",
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
            992: {
                slidesPerView: 3,
            },
            1400: {
                slidesPerView: 4,
            },
        },
    });
    let hm3FeaturedProductsSlider = new Swiper(
        ".hm3-featured-products-slider",
        {
            slidesPerView: 3,
            autoplay: true,
            spaceBetween: 24,
            speed: 700,
            loop: true,
            navigation: {
                prevEl: ".hm3_product_slider_prev",
                nextEl: ".hm3_product_slider_next",
            },
            breakpoints: {
                0: {
                    slidesPerView: 1,
                },
                576: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 1,
                },
                992: {
                    slidesPerView: 2,
                },
                1400: {
                    slidesPerView: 3,
                },
            },
        }
    );

    //4.card progress bar
    $(".card-progressbar").each(function () {
        let data_target = $(this).find(".card-progress");
        let data_width = data_target.attr("data-progress");
        data_target.css({
            width: data_width,
        });
    });

    //5.countdown timer
    $(".countdown-timer").each(function () {
        var $data_date = $(this).data("date");
        $(this).countdown({
            date: $data_date,
        });
    });

    //5. check password
    $(".check-password").each(function () {
        var eyeIcon = $(this).find(".eye-icon");
        eyeIcon.on("click", function () {
            $(this).hide();
            $(this).next().show();
            $(this).siblings("input[type='password']").attr("type", "text");
        });
        var eyeSlash = $(this).find(".eye-slash");
        eyeSlash.on("click", function () {
            $(this).hide();
            $(this).prev().show();
            $(this).siblings("input[type='text']").attr("type", "password");
        });
    });

    //6. category dropdown
    $(".category-dropdown-btn").on("click", function () {
        $(this).siblings(".category-dropdown-box").toggleClass("active");
    });
    $(document).on("mouseup", function (e) {
        var categoryDropdownBox = $(".category-dropdown");
        if (
            !categoryDropdownBox.is(e.target) &&
            categoryDropdownBox.has(e.target).length === 0
        ) {
            $(".category-dropdown-box").removeClass("active");
        }
    });

    //7.offcanvas menu
    function offCanvas() {
        $(".offcanvas-toggle").on("click", function () {
            $(".offcanvas_menu").addClass("active");
        });
        $(".offcanvas-close").on("click", function () {
            $(".offcanvas_menu").removeClass("active");
        });
        $(document).on("mouseup", function (e) {
            var offCanvasMenu = $(".offcanvas_menu");
            if (
                !offCanvasMenu.is(e.target) &&
                offCanvasMenu.has(e.target).length === 0
            ) {
                $(".offcanvas_menu").removeClass("active");
            }
        });
    }
    offCanvas();

    //mobile menu
    $(".mobile-menu-toggle").on("click", function () {
        $(".offcanvas-left-menu").addClass("active");
    });
    $(".offcanvas-left-menu .offcanvas-close").on("click", function () {
        $(".offcanvas-left-menu").removeClass("active");
    });
    $(document).on("mouseup", function (e) {
        var offCanvasMenu = $(".offcanvas-left-menu");
        if (
            !offCanvasMenu.is(e.target) &&
            offCanvasMenu.has(e.target).length === 0
        ) {
            $(".offcanvas-left-menu").removeClass("active");
        }
    });
    $(".mobile-menu ul li.has-submenu a").each(function () {
        $(this).on("click", function () {
            $(this).siblings("ul").slideToggle();
            $(this).toggleClass("icon-rotate");
        });
    });

    //simple bar
    Array.from(document.querySelectorAll(".scrollbar")).forEach(
        (el) =>
            new SimpleBar(el, {
                autoHide: false,
                classNames: {
                    // defaults
                    content: "simplebar-content",
                    scrollContent: "simplebar-scroll-content",
                    scrollbar: "simplebar-scrollbar",
                    track: "simplebar-track",
                },
            })
    );

    //widget gallery popup
    $(".widget-gallery-thumb").magnificPopup({
        delegate: "a",
        type: "image",
        gallery: {
            enabled: true,
        },
    });

    //file upload
    $(".file-upload").each(function () {
        var FileInput = $(this).children("input");
        var FileNameOutput = $(this).children(".file-name");
        FileInput.on("change", function () {
            var FileName = this.files[0].name;
            FileNameOutput.text(FileName);
            console.log($(this));
        });
    });

    //counterup
    $(".counter").counterUp({
        delay: 10,
        time: 1000,
    });

    //video popup
    $(".video-popup-btn").magnificPopup({
        type: "iframe",
    });

    //  dark light mood
    var setDarkMode = (active = false) => {
        var wrapper = document.querySelector(":root");
        if (active) {
            wrapper.setAttribute("data-bs-theme", "dark");
            localStorage.setItem("theme", "dark");
        } else {
            wrapper.setAttribute("data-bs-theme", "light");
            localStorage.setItem("theme", "light");
        }
    };
    var toggleDarkMode = () => {
        var theme = document
            .querySelector(":root")
            .getAttribute("data-bs-theme");
        // If the current theme is "light", we want to activate dark
        setDarkMode(theme === "light");
    };
    var initDarkMode = () => {
        var theme = localStorage.getItem("theme");
        if (theme == "dark") {
            setDarkMode(true);
        } else {
            setDarkMode(false);
        }
        var toggleButton = document.querySelector(".tt-theme-toggle");
        toggleButton && toggleButton.addEventListener("click", toggleDarkMode);
    };
    initDarkMode();
});
