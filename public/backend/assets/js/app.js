/*================
 Template Name: Grostore - eCommerce Admin Dashboard
 Description: Multipurpose eCommerce html template with admin dashboard. Multivendor responsive eCommerce template.
 Version: 1.0
 Author: https://themeforest.net/user/themetags
=======================*/
// TABLE OF CONTENTS

jQuery(function ($) {
    "use strict";

    var allDivider = document.querySelectorAll("#sidebar .divider");
    var toggleSide = document.querySelector(".tt-toggle-sidebar");
    var sidebar = document.getElementById("sidebar");
    toggleSide.addEventListener("click", function () {
        sidebar?.classList.toggle("collapse");
        if (sidebar?.classList.contains("collapse")) {
            allDivider.forEach((item) => {
                item.textContent = "-";
            });
        } else {
            allDivider.forEach((item) => {
                item.textContent = item.dataset.text;
            });
        }
    });
    sidebar?.addEventListener("mouseenter", function () {
        if (this.classList.contains("collapse")) {
            allDivider.forEach((item) => {
                item.textContent = item.dataset.text;
            });
        }
    });
    sidebar?.addEventListener("mouseleave", function () {
        if (this.classList.contains("collapse")) {
            allDivider.forEach((item) => {
                item.textContent = "-";
            });
        }
    });

    //simplebar js
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
    feather.replace();
    $("#menu-toggle-2").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled-2");
        $("#menu ul").hide();
    });

    //    dark light mood
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
        var theme = localStorage.getItem("theme", "light");
        if (theme == "dark") {
            setDarkMode(true);
        } else {
            setDarkMode(false);
        }
        var toggleButton = document.querySelector(".tt-theme-toggle");
        toggleButton.addEventListener("click", toggleDarkMode);
    };
    initDarkMode();
    if ($(".tt-side-nav").length) {
        var navCollapse = $(".tt-side-nav li .collapse");
        var navToggle = $(".tt-side-nav li [data-bs-toggle='collapse']");
        navToggle.on("click", function (e) {
            return false;
        });

        // open one menu at a time only
        navCollapse.on({
            "show.bs.collapse": function (event) {
                var parent = $(event.target).parents(".collapse.show");
                $(".tt-side-nav .collapse.show")
                    .not(event.target)
                    .not(parent)
                    .collapse("hide");
            },
        });

        // activate the menu in left side bar (Vertical Menu) based on url
        $(".tt-side-nav a").each(function () {
            var pageUrl = window.location.href.split(/[?#]/)[0];
            if (this.href == pageUrl) {
                $(this).addClass("active");
                $(this).parent().addClass("tt-menu-item-active");
                $(this).parent().parent().parent().addClass("show");
                $(this)
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .addClass("tt-menu-item-active"); // add active to li of the current link

                var firstLevelParent = $(this)
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .parent();
                if (firstLevelParent.attr("id") !== "sidebar-menu")
                    firstLevelParent.addClass("show");
                $(this)
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .addClass("tt-menu-item-active");
                var secondLevelParent = $(this)
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .parent();
                if (secondLevelParent.attr("id") !== "wrapper")
                    secondLevelParent.addClass("show");
                var upperLevelParent = $(this)
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .parent();
                if (!upperLevelParent.is("body"))
                    upperLevelParent.addClass("tt-menu-item-active");
            }
        });
    }

    //preloader
    $(window).ready(function () {
        $("#preloader").delay(100).fadeOut("fade");

        // sidebar active menu link
        var findActiveItem = $(".tt-side-nav .tt-menu-item-active .active");
        var activeOffsetTop =
            findActiveItem &&
            findActiveItem.offset() &&
            findActiveItem.offset().top - 150;
        $(".simplebar-content-wrapper").animate({
            scrollTop: activeOffsetTop,
        });
    });

    //    toastr js
    // Set the options that I want
    toastr.options = {
        closeButton: true,
        newestOnTop: false,
        progressBar: true,
        positionClass: "toast-top-center",
        preventDuplicates: false,
        onclick: null,
        showDuration: "3000",
        hideDuration: "1000",
        timeOut: "5000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
    };
    //    vertical step
    $(window).on("scroll", function () {
        var scrollBarPosition = $(window).scrollTop();
        $(".tt-vertical-step ul li a").each(function () {
            var navOffset = $(this.hash).offset().top - 90;
            if (scrollBarPosition > navOffset) {
                $(this).parents("ul").find("a.active").removeClass("active");
                $(this).addClass("active");
            }
        });
    });
    $(".tt-vertical-step ul li a").each(function () {
        $(this).on("click", function (e) {
            e.preventDefault();
            var hashOffset = $(this.hash).offset().top - 85;
            $("body,html").animate(
                {
                    scrollTop: hashOffset,
                },
                500
            );
        });
    });

    //    tooltip
    function initTooltip() {
        $('[data-bs-toggle="tooltip"]').tooltip();
    }
    initTooltip();

    // swipper slider for all
    var sliderSelector = ".custom-swiper",
        defaultOptions = {
            breakpointsInverse: true,
            observer: true,
        };
    var jSlider = $(sliderSelector);
    jSlider.each(function (i, slider) {
        var data = $(slider).attr("data-swiper") || {};
        if (data) {
            var dataOptions = JSON.parse(data);
        }
        slider.options = $.extend({}, defaultOptions, dataOptions);
        var swiper = new Swiper(slider, slider.options);

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
});
