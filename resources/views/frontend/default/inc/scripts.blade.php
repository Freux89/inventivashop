<script src="{{ staticAsset('frontend/default/assets/js/vendors/jquery-3.6.4.min.js') }}"></script>
<script src="{{ staticAsset('frontend/default/assets/js/vendors/jquery-ui.min.js') }}"></script>
<script src="{{ staticAsset('frontend/default/assets/js/vendors/bootstrap.bundle.min.js') }}"></script>
<script src="{{ staticAsset('frontend/default/assets/js/vendors/swiper-bundle.min.js') }}"></script>
<script src="{{ staticAsset('frontend/default/assets/js/vendors/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ staticAsset('frontend/default/assets/js/vendors/simplebar.min.js') }}"></script>
<script src="{{ staticAsset('frontend/default/assets/js/vendors/parallax-scroll.js') }}"></script>
<script src="{{ staticAsset('frontend/default/assets/js/vendors/isotop.pkgd.min.js') }}"></script>
<script src="{{ staticAsset('frontend/default/assets/js/vendors/countdown.min.js') }}"></script>
<script src="{{ staticAsset('frontend/default/assets/js/vendors/range-slider.js') }}"></script>
<script src="{{ staticAsset('frontend/default/assets/js/vendors/waypoints.js') }}"></script>
<script src="{{ staticAsset('frontend/default/assets/js/vendors/counterup.min.js') }}"></script>
<script src="{{ staticAsset('frontend/default/assets/js/vendors/clipboard.min.js') }}"></script>
<script src="{{ staticAsset('frontend/default/assets/js/vendors/feather.min.js') }}"></script>
<script src="{{ staticAsset('frontend/common/js/toastr.min.js') }}"></script>
<script src="{{ staticAsset('frontend/common/js/select2.js') }}"></script>
<script src="{{ staticAsset('frontend/default/assets/js/app.js') }}"></script>
<script src="{{ staticAsset('frontend/common/js/megamenu.min.js') }}"></script>
<script>
    "use strict"

    // runs when the document is ready
    $(document).ready(function() {
        initIsotop();
    });

    // tooltip
    $(function() {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });


    //isotop filter grid 
    function initIsotop() {
    var $filter_grid = $(".filter_group").isotope({
        itemSelector: '.filter_item',  // Assicurati di includere la selezione degli elementi
        layoutMode: 'fitRows'         // Questo mantiene gli elementi allineati correttamente
    });

    // Applica il filtro iniziale basato sul bottone con classe 'active'
    var initialFilter = $(".filter-btns button.active").attr("data-filter");
    $filter_grid.isotope({ filter: initialFilter });

    $(".filter-btns").on("click", "button", function() {
        var filterValue = $(this).attr("data-filter");
        $filter_grid.isotope({
            filter: filterValue,
        });
        $(this).siblings('button').removeClass("active");
        $(this).addClass("active");
    });
}

    // copy coupon code
    $(function() {
        new ClipboardJS('.copy-text');
    });
    $(".copyBtn").each(function() {
        $(this).on("click", function() {
            $(this).html('{{ 'Copied' }}');
        });
    });

    // change language
    function changeLocaleLanguage(e) {
    var locale = e.dataset.flag;
    $.post("{{ route('backend.changeLanguage') }}", {
        _token: '{{ csrf_token() }}',
        locale: locale,
        url: window.location.href // Passa l'URL corrente
    }, function(data) {
        if (data.success) {
            // Reindirizza all'URL localizzato
            window.location.href = data.url;
        }
    });
}

    // change currency
    function changeLocaleCurrency(e) {
        var currency_code = e.dataset.currency;
        $.post("{{ route('backend.changeCurrency') }}", {
            _token: '{{ csrf_token() }}',
            currency_code: currency_code
        }, function(data) {
            setTimeout(() => {
                location.reload();
            }, 300);
        });
    }

    // change location
    function changeLocation(e) {
        var location_id = e.dataset.location;
        $.post("{{ route('backend.changeLocation') }}", {
            _token: '{{ csrf_token() }}',
            location_id: location_id
        }, function(data) {
            setTimeout(() => {
                location.reload();
            }, 300);
        });
    }


    // showRejectionReason
    function showRejectionReason(reason) {
        $('.reason').empty();
        $('#refundRejectionModal').modal('show');
        $('.reason').html(reason);
    }

    // show product details in modal
    function showProductDetailsModal(productId) {
        $('#quickview_modal .product-info').html(null);
        $('.data-preloader-wrapper>div').addClass('spinner-border');
        $('.data-preloader-wrapper').addClass('min-h-400');
        $('#quickview_modal').modal('show');

        $.post('{{ route('products.showInfo') }}', {
            _token: '{{ csrf_token() }}',
            id: productId
        }, function(data) {
            setTimeout(() => {
                $('.data-preloader-wrapper>div').removeClass('spinner-border');
                $('.data-preloader-wrapper').removeClass('min-h-400');
                $('#quickview_modal .product-info').html(data);
                TT.ProductSliders();
                cartFunc();
            }, 200);
        });
    }

    $('#quickview_modal').on('hide.bs.modal', function(e) {
        $('#quickview_modal .product-info').html(null);
    });

    // address modal select2
    function addressModalSelect2(parent = '.addAddressModal') {
        $('.select2Address').select2({
            dropdownParent: $(parent)
        });
    }
    addressModalSelect2();

    
    // ajax toast 
    function notifyMe(level, message) {
        if (level == 'danger') {
            level = 'error';
        }
        toastr.options = {
            "timeOut": "5000",
            "closeButton": true,
            "positionClass": "toast-top-center",
        };
        toastr[level](message);
    }

    // laravel flash as toast messages
    @foreach (session('flash_notification', collect())->toArray() as $message)
        notifyMe("{{ $message['level'] }}", "{{ $message['message'] }}");
    @endforeach


    @if (!empty($errors->all()))
        @foreach ($errors->all() as $error)
            notifyMe("error", '{{ $error }}')
        @endforeach
    @endif


    // get selected variation information
    function getVariationInfo() {
    if ($('.add-to-cart-form input[name=quantity]').val()) {
        let data = $('.add-to-cart-form').serializeArray();

        const activeSlideData = [];
        document.querySelectorAll('.swiper-container').forEach(swiperContainer => {
            const selectedSlide = swiperContainer.querySelector('.swiper-slide .gallery-item-block.selected');
            const selectedSlideId = selectedSlide ? selectedSlide.getAttribute('data-value-id') : null;
            activeSlideData.push({
                index: swiperContainer.swiper.activeIndex,
                selectedSlideId: selectedSlideId
            });
        });

        $.ajax({
            type: "POST",
            url: '{{ route('products.getVariationInfo') }}',
            data: data,
            success: function(response) {
                $('.all-pricing').addClass('d-none');
                $('.variation-pricing').removeClass('d-none');
                $('.variation-pricing').html(response.data.recap_body_html);
                $('#quantity_discounts').html(response.data.quantity_discounts);
                $('.summary-box-mobile').html('');
                $('.summary-box-mobile').html(response.data.recap_body_mobile_html);
                $('#variants-container').html(response.data.variations_html);
                $('.add-to-cart-form input[name=product_variation_id]').val(response.data.filteredIds.join(','));
                $('.add-to-cart-form input[name=indicativeDeliveryDays]').val(response.data.indicativeDeliveryDays);
                $('.add-to-cart-btn').prop('disabled', false);
                $('.add-to-cart-btn .add-to-cart-text').html(TT.localize.addToCart);
                $('#summaryContent').html(response.data.summary_box_variants_html);
                initializeSwiper();
                initializeGrid();
                setupToggleView();
                initializeInfoIconEvents();
                initializeSelectInfoIconEvents();
                initializeGridInfoIconEvents();
                initializeToggleDetails();
                initializeQuantityDiscounts();
                initTooltip();
                 // Ripristina la modalità di visualizzazione
                 Object.keys(viewModes).forEach(variationId => {
                    if (viewModes[variationId] === 'grid') {
                        const swiperContainer = document.querySelector(`.swiper-container[data-variation-id="${variationId}"]`);
                        const gridContainer = document.querySelector(`.grid-container[data-variation-id="${variationId}"]`);
                        if (gridContainer && swiperContainer) {
                            gridContainer.classList.remove('d-none');
                            swiperContainer.classList.add('d-none');
                        }
                    }
                });

                
                if (!isAutoSelecting) {
    document.querySelectorAll('.swiper-container').forEach((swiperContainer, index) => {
        if (activeSlideData[index]) { // Controlla se activeSlideData[index] esiste
            swiperContainer.swiper.slideTo(activeSlideData[index].index, 0);
            
        }
    });
}
                
                    hideLoading();
                
            },
            error: function() {
                hideLoading();
            }
        });
    }
}

    // check if it can be added to cart
    function isValidForAddingToCart() {

        var count = 0;
        $('.variation-for-cart').each(function() {
            // how many variations
            count++;
        });

        var selectedOptions = $('.product-radio-btn input:radio:checked').length + $('select.product-select option:selected').length;

    if (selectedOptions == count) {
        return true;
    }

        return false;
    }

    function initializeQuantityDiscounts() {
    document.querySelectorAll('.tier-row').forEach(row => {
        row.addEventListener('click', function() {
            const quantity = this.getAttribute('data-quantity');
            $('.product-qty input[name=quantity]').val(quantity);
            getVariationInfo();
        });
    });
}

    function cartFunc() {
        // on selection of variation
        

        $('#variants-container').on('change', '.product-radio-btn input, .product-select', function() {
        
            getVariationInfo();
            
        });

        // increase qty
        $('.qty-increase-decrease .increase').on('click', function() {
            var prevValue = $('.product-qty input[name=quantity]').val();
            //var maxValue = $('.product-qty input[name=quantity]').attr('max');
            var maxValue = 9999;
            if (maxValue == undefined || parseInt(prevValue) < parseInt(maxValue)) {
                $('.qty-increase-decrease input[name=quantity]').val(parseInt(prevValue) + 1)
            }
            getVariationInfo();
        });

       

        // decrease qty
        $('.qty-increase-decrease .decrease').on('click', function() {
            var prevValue = $('.product-qty input[name=quantity]').val();
            if (prevValue > 1) {
                $('.qty-increase-decrease input[name=quantity]').val(parseInt(prevValue) - 1)
            }
            getVariationInfo();
        });

        // add to cart form submit
        $('.add-to-cart-form').on('submit', function(e) {
            e.preventDefault();
            if (isValidForAddingToCart()) {
                $('.add-to-cart-btn').prop('disabled', true);
                $('.add-to-cart-btn .add-to-cart-text').html(TT.localize.addingToCart);

                // add to cart here
                let data = $('.add-to-cart-form').serializeArray();
                $.ajax({
                    type: "POST",
                    url: '{{ route('carts.store') }}',
                    data: data,
                    success: function(data) {
                        $('.add-to-cart-btn').prop('disabled', false);
                        $('.add-to-cart-btn .add-to-cart-text').html(TT.localize.addToCart);
                        updateCarts(data);
                        notifyMe('success', data.message);
                    }
                });

            } else {
                optionsAlert();
            }
        })
    }
    cartFunc();

    // without variation form submit
    function directAddToCartFormSubmit($this) {
        // add to cart here
        let parent = $($this).closest('.direct-add-to-cart-form');

        parent.find('.direct-add-to-cart-btn').prop('disabled', true);

        let text = parent.find('.add-to-cart-text').html();
        parent.find('.add-to-cart-text').html(TT.localize.pleaseWait);


        let data = parent.serializeArray();
        $.ajax({
            type: "POST",
            url: '{{ route('carts.store') }}',
            data: data,
            success: function(data) {
                parent.find('.direct-add-to-cart-btn').prop('disabled', false);

                if (text.includes("Buy Now")) {
                    parent.find('.add-to-cart-text').html(TT.localize.buyNow);
                } else {
                    parent.find('.add-to-cart-text').html(TT.localize.addToCart);
                }
                updateCarts(data);
                notifyMe('success', data.message);
            }
        });
    }

    // please choose all the available options
    function optionsAlert() {
        notifyMe('warning', TT.localize.optionsAlert);
    }

    // handleCartItem
    function handleCartItem(action, id) {
        let data = {
            _token: "{{ csrf_token() }}",
            action: action,
            id: id,
        };

        $.ajax({
            type: "POST",
            url: '{{ route('carts.update') }}',
            data: data,
            success: function(data) {
                if (data.success == true) {

                    $('.apply-coupon-btn').removeClass('d-none');
                    $('.clear-coupon-btn').addClass('d-none');
                    $('.apply-coupon-btn').prop('disabled', false);
                    $('.apply-coupon-btn').html(TT.localize.applyCoupon);
                    updateCarts(data);

                }
            }
        });
    }

    // coupon-form form submit
    $('.coupon-form').on('submit', function(e) {
        e.preventDefault();
        $('.apply-coupon-btn').prop('disabled', true);
        $('.apply-coupon-btn').html(TT.localize.pleaseWait);

        // apply coupon here
        let data = $('.coupon-form').serializeArray();
        $.ajax({
            type: "POST",
            url: '{{ route('carts.applyCoupon') }}',
            data: data,
            success: function(data) {
                if (data.success == false) {
                    notifyMe('error', data.message);
                    $('.apply-coupon-btn').prop('disabled', false);
                    $('.apply-coupon-btn').html(TT.localize.applyCoupon);
                } else {
                    // append clear button 
                    $('.coupon-input').prop('disabled', false);
                    $('.apply-coupon-btn').addClass('d-none');
                    $('.clear-coupon-btn').removeClass('d-none');

                    $('.apply-coupon-btn').prop('disabled', false);
                    $('.apply-coupon-btn').html(TT.localize.applyCoupon);

                    updateCouponPrice(data);

                }
            }
        });
    })

    // clear-coupon-btn clicked
    $('.clear-coupon-btn').on('click', function(e) {
        e.preventDefault();
        // append clear button 
        $('.coupon-input').prop('disabled', false);
        $('.apply-coupon-btn').removeClass('d-none');
        $('.clear-coupon-btn').addClass('d-none');

        $.ajax({
            type: "GET",
            url: '{{ route('carts.clearCoupon') }}',
            success: function(data) {
                updateCouponPrice(data);
            }
        });
    })

    function updateCouponPrice(data) {
        $('.coupon-discount-wrapper').toggleClass('d-none');
        if(data.couponDetails.discount_value > 0) {
            $('.coupon-discount-price').html(data.couponDiscount);
        } else if(data.couponDetails.is_free_shipping && data.couponDetails.discount_value == 0) {
            $('.coupon-discount-price').html('{{ localize("Free Shipping") }}');
        }
    }

    // update carts markup
    function updateCarts(data) {
        $('.cart-counter').empty();
        $('.sub-total-price').empty();

        $('.cart-navbar-wrapper .simplebar-content').empty();
        $('.cart-listing').empty();

        if (data.cartCount > 0) {
            $('.cart-counter').removeClass('d-none');
        } else {
            $('.cart-counter').addClass('d-none');
        }

        $('.cart-counter').html(data.cartCount);
        $('.sub-total-price').html(data.subTotal);
        $('.cart-navbar-wrapper .simplebar-content').html(data.navCarts);
        $('.cart-listing').html(data.carts);
        $('.coupon-discount-wrapper').addClass('d-none');
        $('.checkout-sidebar').empty();

    }

    // get logistics to check out
    function getLogistics(country_id) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            url: "{{ route('checkout.getLogistic') }}",
            type: 'POST',
            data: {
                country_id: country_id
            },
            success: function(data) {
                $('.checkout-sidebar').empty();
                $('.checkout-logistics').empty();
                $('.checkout-logistics').html(data.logistics);
                $('.checkout-sidebar').html(data.summary);
            }
        });
    }

    //  get logistics to check out -- onchange
    $(document).on('change', '[name=chosen_logistic_zone_id]', function() {
        var chosen_logistic_zone_id = $(this).val();
        var isInsured = false;

        // Disabilita tutti i checkbox dell'assicurazione
        $('[name=insured_shipping]').prop('disabled', true);
        $('[name=insured_shipping]').prop('checked', false);
        // Abilita il checkbox dell'assicurazione corrispondente al corriere selezionato
        $('#insured_shipping_' + chosen_logistic_zone_id).prop('disabled', false);

        getShippingAmount(chosen_logistic_zone_id, isInsured);
    });


    $(document).on('change', '[name=insured_shipping]', function() {
        var chosen_logistic_zone_id = $('[name=chosen_logistic_zone_id]:checked').val();
        var isInsured = $(this).is(':checked');
        getShippingAmount(chosen_logistic_zone_id, isInsured);
    });

    // get logistics to check out
    function getShippingAmount(logistic_zone_id, isInsured) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            url: "{{ route('checkout.getShippingAmount') }}",
            type: 'POST',
            data: {
                logistic_zone_id: logistic_zone_id,
                insured_shipping: isInsured
            },
            success: function(data) {
                $('.checkout-sidebar').empty();
                $('.checkout-sidebar').html(data);
            }
        });
    }


    document.addEventListener('DOMContentLoaded', function () {
    const selectedRadio = document.querySelector('input[name="shipping_address_id"]:checked');

    if (selectedRadio) {
        const countryId = selectedRadio.getAttribute('data-country_id');
        getLogistics(countryId); // Esegui getLogistics per il radio selezionato
    }
});

    //  submit checkout form
    
    $(document).on('submit', '.checkout-form', function(e) {
        // shipping address not selected
        if ($('.checkout-form input[name=shipping_address_id]:checked').length == 0) {
            notifyMe('error', '{{ localize('Please select shipping address') }}');
            e.preventDefault();;
            return false;
        }

        // logistic not selected
        if ($('.checkout-form input[name=chosen_logistic_zone_id]:checked').length == 0) {
            notifyMe('error', '{{ localize('Please select logistic') }}');
            e.preventDefault();;
            return false;
        }

        // billing address not selected
        if ($('input[name="invoice_request"]:checked').val() == '1') {

        if ($('.checkout-form input[name=billing_address_id]:checked').length == 0) {
            notifyMe('error', '{{ localize('Please select billing address') }}');
            e.preventDefault();;
            return false;
        }
    }
    });

    // add to wishlist
    function addToWishlist(productId) {
        @if (auth()->check())
            @if (auth()->user()->user_type == 'customer')
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    type: "POST",
                    url: '{{ route('customers.wishlist.store') }}',
                    data: {
                        product_id: productId
                    },
                    success: function(data) {
                        notifyMe('success', data.message);
                    }
                });
            @else
                notifyMe('danger', '{{ localize('Only customer can add products to wishlist') }}');
            @endif
        @else
            notifyMe('warning', '{{ localize('Please login first') }}');
        @endif
    }

    function toggleBillingAddresses(display) {
    // Seleziona il contenitore degli indirizzi di fatturazione
    var billingAddressesContainer = document.getElementById('billing-addresses-container');

    // Imposta la proprietà display in base al valore passato alla funzione
    billingAddressesContainer.style.display = display ? 'block' : 'none';
}
document.addEventListener('DOMContentLoaded', function() {
    var savedChoice = localStorage.getItem('invoice_preference');
    if (savedChoice) {
        var radioButton = document.querySelector('input[name="invoice_request"][value="' + savedChoice + '"]');
        if (radioButton) {
            radioButton.checked = true;
            toggleBillingAddresses(savedChoice === '1');
        }
    }
});
    function saveInvoicePreference(choice) {
        localStorage.setItem('invoice_preference', choice);
    }

    function initFeather() {
        feather.replace();
    }
    initFeather();

    function initTooltip() {
            $('[data-bs-toggle="tooltip"]').tooltip();
        }
    initTooltip();

    document.addEventListener("DOMContentLoaded", function () {
            $(".summary").stick_in_parent();
        });


        document.addEventListener('DOMContentLoaded', function() {
            var breadcrumbContent = document.querySelector('.breadcrumb-content');
        //    breadcrumbContent.scrollLeft = breadcrumbContent.scrollWidth;
        });

        function initializeToggleDetails() {
    $('.toggle-quote-details').off('click').on('click', function() {
        var details = $('#quote-details');
        var arrow = $(this);
        if (details.is(':visible')) {
            details.slideUp(500, function() {
                arrow.removeClass('fa-arrow-down').addClass('fa-arrow-up');
            });
        } else {
            details.slideDown(500, function() {
                arrow.removeClass('fa-arrow-up').addClass('fa-arrow-down');
            });
        }
    });
}
document.addEventListener('DOMContentLoaded', function() {
    initializeToggleDetails();
    initializeQuantityDiscounts();
        });



    
    

</script>
