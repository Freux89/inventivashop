@extends('backend.layouts.master')

@section('title')
    {{ localize('Pos') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    <section class="tt-section py-3">
        <div class="container-fluid">
            <div class="row g-3">
                <!--left sidebar start-->
                <div class="col-12 col-lg-8">

                    <form action="" class="pos-product-form">
                        @csrf
                        <!-- category brand start-->
                        @include('backend.pages.pos.inc.category-brands')
                        <!-- category brand end-->

                        <!-- products start-->
                        <div class="tt-pos-products-wrap">
                            <div class="row justify-content-between align-items-center g-3 mb-3">
                                <div class="col-auto flex-grow-1">
                                    <h2 class="h5 mb-0">{{ localize('All Listed Products') }}</h2>
                                </div>
                                <div class="col-auto">
                                    <div class="tt-search-box">
                                        <div class="input-group">
                                            <span class="position-absolute top-50 start-0 translate-middle-y ms-2"> <i
                                                    data-feather="search"></i></span>
                                            <input class="form-control rounded-start w-100" type="text" name="search"
                                                placeholder="{{ localize('Search') }}...">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-secondary" onclick="getPosProducts()">
                                        {{ localize('Search') }}
                                    </button>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-soft-primary" data-bs-toggle="modal"
                                        data-bs-target="#addItemCode">
                                        <i data-feather="plus"></i> {{ localize('Add Item by Code') }}
                                    </button>
                                </div>
                            </div>
                            <div class="tt-pos-products" data-simplebar>
                                <div
                                    class="row g-3 row-cols-xl-5 row-cols-lg-4 row-cols-sm-2 row-cols-1 row-cols-md-4 pos-products">
                                    {{-- products will be appended via ajax response --}}
                                </div>

                                <button type="button" class="mt-3 btn btn-primary d-block mx-auto pos-load-more d-none"
                                    onclick="getNextPosProducts()">
                                    <span> <i data-feather="refresh-cw" class="me-2"
                                            width="18"></i>{{ localize('Load More') }}</span>
                                </button>

                            </div>
                        </div>
                        <!-- products end-->
                    </form>

                </div>
                <!--left sidebar end-->

                <!--right sidebar start-->
                <div class="col-12 col-lg-4">
                    <div class="tt-pos-right card border-0 flex-column h-100 p-3">

                        <form action="" class="d-flex flex-column h-100 pos-cart-list-form">
                            @csrf
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h5 class="mb-0">{{ localize('Billing Section') }}</h5>
                                <div class="d-flex flex-wrap align-items-center">
                                    <div class="me-2 mb-1 mb-md-0">
                                        <select class="form-select py-1" name="delivery_status">
                                            <option value="{{ orderDeliveredStatus() }}" selected>
                                                {{ localize('Delivered') }}</option>
                                            <option value="{{ orderPlacedStatus() }}">{{ localize('Order Placed') }}
                                            </option>
                                        </select>
                                    </div>

                                    <button type="button" class="btn btn-soft-primary py-1 px-2 me-2 mb-1 mb-md-0"
                                        onclick="showCustomerModal()"><i data-feather="user-plus"
                                            class="me-1"></i>{{ localize('Customer') }}</button>
                                    <a href="{{ route('admin.pos.index') }}" target="_blank"
                                        class="btn btn-soft-accent py-1 px-2 mb-1 mb-md-0"><i data-feather="plus-circle"
                                            class="me-1"></i>{{ localize('New Order') }}</a>
                                </div>
                            </div>

                            <!-- selected customer -->
                            <div class="tt-pos-customer bg-soft-primary rounded p-2 px-3 mb-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-md">
                                            <img class="rounded-circle selected_customer_avatar" src=""
                                                alt=""
                                                onerror="this.onerror=null;this.src='{{ staticAsset('backend/assets/img/placeholder-thumb.png') }}';" />
                                        </div>
                                        <div class="ms-2">
                                            <input type="hidden" class="selected_customer_id" name="selected_customer_id"
                                                value="">
                                            <input type="hidden" class="selected_customer_address"
                                                name="selected_customer_address" value="">

                                            <h6 class="mb-0 fs-md selected_customer_name">Customer</h6>
                                            <span class="text-muted fs-sm selected_customer_phone">+xxxxxxxxxx</span>

                                        </div>
                                    </div>
                                    <h6 class="mb-0 fs-sm text-muted selected_customer_address_view"></h6>
                                </div>
                            </div>
                            <!-- selected customer -->


                            <div class="tt-pos-added-item" data-simplebar>
                                <table class="table tt-footable align-middle" data-use-parent-width="true">
                                    <thead class="sticky-top bg-secondary-subtle">
                                        <tr>
                                            <th>{{ localize('Item') }}</th>
                                            <th data-breakpoints="xs sm" class="text-center">{{ localize('Qty') }}</th>
                                            <th data-breakpoints="xs sm md">{{ localize('Price') }}</th>
                                            <th data-breakpoints="xs sm md" class="text-end">{{ localize('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="pos-cart-list">
                                        {{-- @include('backend.pages.pos.inc.pos-cart') via ajax response --}}
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-auto pos-summary">
                                {{-- @include('backend.pages.pos.inc.posSummary') via ajax response --}}
                            </div>
                        </form>
                    </div>
                </div>
                <!--right sidebar end-->

                <!-- customer modal -->
                @include('backend.pages.pos.inc.customerModal')
                <!-- customer modal end -->

                <!-- product variation modal start -->
                <form action="" class="add-to-cart-form">
                    @csrf
                    <input type="hidden" name="product_variation_id" class="generated_product_variation_id">
                    @include('backend.pages.pos.inc.variationModal')
                </form>
                <!-- product variation modal end -->

                <!-- add item by code modal start -->
                @include('backend.pages.pos.inc.codeModal')
                <!-- add item by code modal end -->
            </div>
        </div>
    </section>
@endsection


@section('scripts')
    <script>
        "use strict";

        $('.pos-product-form').on('submit', function(e) {
            e.preventDefault();
            getPosProducts();
        });

        TT.nextPosPageUrl = null;
        // runs when the document is ready
        $(document).ready(function() {
            getPosProducts();
        });

        // get pos products
        function getPosProducts() {
            let url = '{{ route('admin.pos.products') }}';
            $('.pos-products').empty();
            $('.pos-load-more').addClass('d-none')

            let data = $('.pos-product-form').serializeArray();
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                success: function(data) {
                    $('.pos-products').append(data.products);

                    TT.nextPosPageUrl = data.productsQuery.next_page_url;
                    if (data.productsQuery.next_page_url == null) {
                        $('.pos-load-more').addClass('d-none')
                    } else {
                        $('.pos-load-more').removeClass('d-none')
                    }
                }
            });
        }

        // get next pos products
        function getNextPosProducts() {
            if (TT.nextPosPageUrl != null) {
                $('.pos-load-more').addClass('d-none')

                let data = $('.pos-product-form').serializeArray();
                $.ajax({
                    type: "POST",
                    url: TT.nextPosPageUrl,
                    data: data,
                    success: function(data) {
                        $('.pos-products').append(data.products);
                        TT.nextPosPageUrl = data.productsQuery.next_page_url;
                        if (data.productsQuery.next_page_url == null) {
                            $('.pos-load-more').addClass('d-none')
                        } else {
                            $('.pos-load-more').removeClass('d-none')
                        }
                    }
                });
            }
        }

        // show customer modal
        function showCustomerModal() {
            $('#pos_customer_modal .customer-info').html(null);
            $('#pos_customer_modal .data-preloader-wrapper>div').addClass('spinner-border');
            $('#pos_customer_modal .data-preloader-wrapper').addClass('min-h-400');
            $('#pos_customer_modal').modal('show');

            $.post('{{ route('admin.pos.customers') }}', {
                _token: '{{ csrf_token() }}'
            }, function(data) {
                setTimeout(() => {
                    $('#pos_customer_modal .data-preloader-wrapper>div').removeClass('spinner-border');
                    $('#pos_customer_modal .data-preloader-wrapper').removeClass('min-h-400');

                    $('#pos_customer_modal .customer-info').html(data.customers);
                    $('.modalSelect2').select2({
                        dropdownParent: $('.modalParentSelect2')
                    });
                    initScripts()
                }, 200);
            });
        }

        $('#pos_customer_modal').on('hide.bs.modal', function(e) {
            $('#pos_customer_modal .customer-info').html(null);
        });

        // customer selection 
        function initScripts() {
            $('.existing-customer-form').on('submit', function(e) {
                e.preventDefault();
                handleExistingCustomerSelection();
            })

            $('.pos-new-customer').on('submit', function(e) {
                e.preventDefault();
                handleNewCustomerSelection();
            })
        }
        initScripts();

        // handleExistingCustomerSelection
        function handleExistingCustomerSelection() {
            var customer_id = $('select[name=pos_customer_id] option').filter(':selected').val()
            var address = $('[name=pos_customer_address]').val()

            $('.selected_customer_name').empty('');
            $('.selected_customer_phone').empty('');

            $.post('{{ route('admin.pos.customerInfo') }}', {
                _token: '{{ csrf_token() }}',
                customer_id: customer_id
            }, function(data) {
                $('.selected_customer_id').val(data.customer.id);

                $('.selected_customer_name').html(data.customer.name);
                $('.selected_customer_phone').html(data.customer.phone);
                $('.selected_customer_address_view').empty();

                if (data.customer.avatar != null) {
                    $('.selected_customer_avatar').prop('src', data.customer.avatar);
                }

                $('.selected_customer_address').val(address);
                $('.selected_customer_address_view').html(address);
                $('#pos_customer_modal').modal('hide');
            });
        }

        // handle New Customer Selection
        function handleNewCustomerSelection() {

            var address = $('[name=new_customer_address]').val()

            $('.save-select-btn').prop('disabled', true);

            $('.selected_customer_name').empty('');
            $('.selected_customer_phone').empty('');

            let data = $('.pos-new-customer').serializeArray();
            let url = '{{ route('admin.pos.newCustomer') }}';

            $.ajax({
                type: "POST",
                url: url,
                data: data,
                success: function(data) {
                    $('.selected_customer_id').val(data.customer.id);

                    $('.selected_customer_name').html(data.customer.name);
                    $('.selected_customer_phone').html(data.customer.phone);
                    $('.selected_customer_address_view').empty();

                    if (data.customer.avatar != null) {
                        $('.selected_customer_avatar').prop('src', data.customer.avatar);
                    }

                    $('.selected_customer_address').val(address);
                    $('.selected_customer_address_view').html(address);
                    $('#pos_customer_modal').modal('hide');
                }
            });
        }

        // show variant modal
        function showVariantModal(product_id) {
            $('#productVariationModal .product-info').html(null);
            $('#productVariationModal .data-preloader-wrapper>div').addClass('spinner-border');
            $('#productVariationModal .data-preloader-wrapper').addClass('min-h-400');

            $('#productVariationModal').modal('show');

            $.post('{{ route('admin.pos.productInfo') }}', {
                _token: '{{ csrf_token() }}',
                id: product_id
            }, function(data) {
                setTimeout(() => {
                    $('#productVariationModal .data-preloader-wrapper>div').removeClass('spinner-border');
                    $('#productVariationModal .data-preloader-wrapper').removeClass('min-h-400');
                    $('#productVariationModal .product-info').html(data);

                    // on selection of variation
                    $('.product-radio-btn input').on('change', function() {
                        getVariationInfo();
                    });
                }, 200);
            });

        }

        // add variation product to cart
        function addVariationProductToCart() {
            var product_variation_id = $('.generated_product_variation_id').val();
            if (isValidForAddingToCart()) {
                addToPosCart(product_variation_id);
            } else {
                notifyMe('warning', '{{ localize('Please select all the options') }}');
            }
        }

        // addToPosCart
        function addToPosCart(product_variation_id) {
            let listData = $('.pos-cart-list-form').serializeArray();

            var newItem = {
                name: "product_variation_id",
                value: product_variation_id
            }

            listData.push(newItem);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: "POST",
                url: '{{ route('admin.pos.addToList') }}',
                data: listData,
                success: function(data) {
                    $('.pos-cart-list').empty();
                    $('.pos-summary').empty();

                    $('.pos-cart-list').append(data.carts);
                    $('.pos-summary').append(data.posSummary);


                    if (data.status == false) {
                        notifyMe("warning", data.message);
                    } else {
                        $('#productVariationModal').modal('hide');
                        $('#addItemCode').modal('hide');
                    }

                    $("table.tt-footable").footable();
                    feather.replace();
                    $('.select2').select2();

                    $('[name=additional_discount_value], [name=total_shipping_cost]').on('focus', function() {
                        $('.complete-order-btn').prop('disabled', true)
                    })

                    $('[name=additional_discount_value], [name=total_shipping_cost]').on('focusout',
                        function() {
                            $('.complete-order-btn').prop('disabled', false)
                            // calculate pos summary
                            calculatePosSummary();
                        })
                }
            });

        }

        // check if it can be added to cart
        function isValidForAddingToCart() {
            var count = 0;
            $('.variation-for-cart').each(function() {
                // how many variations
                count++;
            });
            if ($('.product-radio-btn input:radio:checked').length == count) {
                return true;
            }
            return false;
        }

        // get selected variation information
        function getVariationInfo() {
            if (isValidForAddingToCart()) {
                let data = $('.add-to-cart-form').serializeArray();
                $.ajax({
                    type: "POST",
                    url: '{{ route('products.getVariationInfo') }}',
                    data: data,
                    success: function(response) {
                        $('.generated_product_variation_id').val(response.data.id);
                    }
                });
            }
        }

        // deleteFromCart
        function deleteFromCart(product_variation_id) {

            let listData = $('.pos-cart-list-form').serializeArray();

            var newItem = {
                name: "product_variation_id",
                value: product_variation_id
            }

            listData.push(newItem);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: "POST",
                url: '{{ route('admin.pos.deleteFromCart') }}',
                data: listData,
                success: function(data) {
                    $('.pos-cart-list').empty();
                    $('.pos-summary').empty();

                    $('.pos-cart-list').append(data.carts);
                    $('.pos-summary').append(data.posSummary);

                    $("table.tt-footable").footable();
                    feather.replace();
                    $('.select2').select2();

                    $('[name=additional_discount_value], [name=total_shipping_cost]').on('focus', function() {
                        $('.complete-order-btn').prop('disabled', true)
                    })

                    $('[name=additional_discount_value], [name=total_shipping_cost]').on('focusout',
                        function() {
                            $('.complete-order-btn').prop('disabled', false)
                            // calculate pos summary
                            calculatePosSummary();
                        })
                }
            });
        }

        // increase / decrease qty
        function handleQty(product_variation_id, action) {
            let listData = $('.pos-cart-list-form').serializeArray();

            var item = {
                name: "product_variation_id",
                value: product_variation_id
            }

            var action = {
                name: "action",
                value: action
            }

            listData.push(item);
            listData.push(action);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: "POST",
                url: '{{ route('admin.pos.handleQty') }}',
                data: listData,
                success: function(data) {
                    $('.pos-cart-list').empty();
                    $('.pos-summary').empty();

                    $('.pos-cart-list').append(data.carts);
                    $('.pos-summary').append(data.posSummary);

                    if (data.status == false) {
                        notifyMe('warning', data.message);
                    }

                    $("table.tt-footable").footable();
                    feather.replace();
                    $('.select2').select2();

                    $('[name=additional_discount_value], [name=total_shipping_cost]').on('focus', function() {
                        $('.complete-order-btn').prop('disabled', true)
                    })

                    $('[name=additional_discount_value], [name=total_shipping_cost]').on('focusout',
                        function() {
                            $('.complete-order-btn').prop('disabled', false)
                            // todo:: calculate pos summary
                            calculatePosSummary();
                        })
                }
            });
        }

        // add to cart by code
        $('.add-item-by-code-form').on('submit', function(e) {
            e.preventDefault();
            addToListByCode();
        });
        $('#addItemCode').on('show.bs.modal', function(e) {
            $('.cancel-code-btn').prop('disabled', false);
            $('.add-item-by-code-btn').prop('disabled', false);
            $('.product_variation_code').val('');
        });

        function addToListByCode() {
            // get variation id by code
            $('.cancel-code-btn').prop('disabled', true);
            $('.add-item-by-code-btn').prop('disabled', true);

            let code = $('.product_variation_code').val();
            $.post('{{ route('admin.pos.getVariationId') }}', {
                _token: '{{ csrf_token() }}',
                code: code
            }, function(data) {
                if (data.success == true) {
                    addToPosCart(data.variation.id);
                } else {
                    // notify 
                    notifyMe('warning', data.message);
                }
            });

            setTimeout(() => {
                $('.cancel-code-btn').prop('disabled', false);
                $('.add-item-by-code-btn').prop('disabled', false);
            }, 200);
        }

        // calculatePosSummary
        function calculatePosSummary() {
            let listData = $('.pos-cart-list-form').serializeArray();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: "POST",
                url: '{{ route('admin.pos.updatePosSummary') }}',
                data: listData,
                success: function(data) {
                    $('.pos-summary').empty();
                    $('.pos-summary').append(data.posSummary);
                    $('.select2').select2();

                    $('[name=additional_discount_value], [name=total_shipping_cost]').on('focus', function() {
                        $('.complete-order-btn').prop('disabled', true)
                    })
                    $('[name=additional_discount_value], [name=total_shipping_cost]').on('focusout',
                        function() {
                            $('.complete-order-btn').prop('disabled', false)
                            calculatePosSummary();
                        })
                }
            });
        }

        // submit order
        $('.pos-cart-list-form').on('submit', function(e) {
            e.preventDefault();
            submitOrder();
        })

        function submitOrder() {
            let listData = $('.pos-cart-list-form').serializeArray();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: "POST",
                url: '{{ route('admin.pos.completeOrder') }}',
                data: listData,
                success: function(data) {
                    $('.pos-cart-list').empty();
                    $('.pos-summary').empty();
                    $('.selected_customer_name').empty('');
                    $('.selected_customer_phone').empty('');
                    $('.selected_customer_id').val('');
                    $('.selected_customer_address_view').empty();

                    let url = '{{ route('home') }}' + '/admin/pos/invoice-download/' + data
                    window.open(
                        url,
                        '_blank' // <- This is what makes it open in a new window.
                    );
                }
            });
        }
    </script>
@endsection
