@extends('backend.layouts.master')

@section('title')
    {{ localize('Update Coupon') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-lg-0">{{ localize('Update Coupon') }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4 g-4">

                <!--left sidebar-->
                <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">
                    <form action="{{ route('admin.coupons.update') }}" method="POST" class="pb-650">
                        @csrf
                        <input type="hidden" name="id" value="{{ $coupon->id }}">
                        <!--basic information start-->
                        <div class="card mb-4" id="section-1">
                            <div class="card-body">
                                <h5 class="mb-4">{{ localize('Basic Information') }}</h5>

                                <div class="mb-4">
                                    <label for="code" class="form-label">{{ localize('Coupon Code') }}</label>
                                    <input class="form-control" type="text" id="code"
                                        placeholder="{{ localize('Type coupon code') }}" name="code" required
                                        value="{{ $coupon->code }}">
                                </div>

                                <div class="mb-4">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="discount_value"
                                                    class="form-label">{{ localize('Discount Amount') }}</label>
                                                <input class="form-control" type="number"
                                                    placeholder="{{ localize('Type discount amount') }}"
                                                    id="discount_value" step="0.001" name="discount_value" required
                                                    value="{{ $coupon->discount_value }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="discount_type"
                                                    class="form-label">{{ localize('Percent or Fixed') }}</label>
                                                <select class="select2 form-control" id="discount_type" name="discount_type"
                                                    required>
                                                    <option value="percent"
                                                        {{ $coupon->discount_type == 'percent' ? 'selected' : '' }}>
                                                        {{ localize('Percent') }} %
                                                    </option>
                                                    <option value="flat"
                                                        {{ $coupon->discount_type == 'flat' ? 'selected' : '' }}>
                                                        {{ localize('Fiexed') }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            @php
                                                $start_date = date('m/d/Y', $coupon->start_date);
                                                $end_date = date('m/d/Y', $coupon->end_date);
                                            @endphp
                                            <div class="mb-3">
                                                <label class="form-label">{{ localize('Date Range') }}</label>
                                                <div class="input-group">
                                                    <input class="form-control date-range-picker date-range" type="text"
                                                        placeholder="{{ localize('Start date - End date') }}"
                                                        name="date_range" data-startdate="'{{ $start_date }}'"
                                                        data-enddate="'{{ $end_date }}'">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <label for="discount_value"
                                                class="form-label mb-3">{{ localize('Free Shpping?') }}</label>
                                            <div class="d-flex align-items-center">
                                                <div class="form-check form-switch">
                                                    <label class="form-check-label fw-semibold text-primary"
                                                        for="is_free_shipping">{{ localize('Allow Free Shipping?') }}</label>
                                                    <input type="checkbox" class="form-check-input" id="is_free_shipping"
                                                        name="is_free_shipping"
                                                        {{ $coupon->is_free_shipping ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">{{ localize('Banner') }}</label>
                                    <div class="tt-image-drop rounded">
                                        <span class="fw-semibold">{{ localize('Choose Coupon Banner') }}</span>
                                        <!-- choose media -->
                                        <div class="tt-product-thumb show-selected-files mt-3">
                                            <div class="avatar avatar-xl cursor-pointer choose-media"
                                                data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
                                                onclick="showMediaManager(this)" data-selection="single">
                                                <input type="hidden" name="banner" value="{{ $coupon->banner }}">
                                                <div class="no-avatar rounded-circle">
                                                    <span><i data-feather="plus"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- choose media -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--basic information end-->


                        <!-- products & categories -->
                        <div class="card mb-4" id="section-2">
                            <div class="card-body">
                                <h5 class="">{{ localize('Products & Categories') }}</h5>
                                <div class="mb-4"><small
                                        class="text-warning">{{ localize('Coupon will be applicable only for the products, categories if selected.') }}</small>
                                </div>

                                <div class="mb-4">
                                    @php
                                        $coupon_categories = null;
                                        if (!is_null(json_decode($coupon->category_ids))) {
                                            $coupon_categories = App\Models\Category::whereIn('id', json_decode($coupon->category_ids))->pluck('id');
                                        }
                                    @endphp

                                    <label class="form-label">{{ localize('Categories') }}</label>
                                    <select class="form-control select2" class="w-100" data-toggle="select2"
                                        data-placeholder="{{ localize('Select Categories') }}" name="category_ids[]"
                                        multiple>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                @if (!is_null($coupon_categories)) {{ $coupon_categories->contains($category->id) ? 'selected' : '' }} @endif>
                                                {{ $category->name }}
                                            </option>
                                            @foreach ($category->childrenCategories as $childCategory)
                                                @include('backend.pages.products.products.subCategory', [
                                                    'subCategory' => $childCategory,
                                                    'coupon_categories' => $coupon_categories,
                                                ])
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-4">
                                    @php
                                        $coupon_products = null;
                                        if (!is_null(json_decode($coupon->product_ids))) {
                                            $coupon_products = App\Models\Product::whereIn('id', json_decode($coupon->product_ids))->pluck('id');
                                        }
                                    @endphp
                                    <label for="parent_id" class="form-label">{{ localize('Products') }}</label>
                                    <select class="form-control select2" class="w-100" data-toggle="select2"
                                        data-placeholder="{{ localize('Select Products') }}" name="product_ids[]"
                                        multiple>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                @if (!is_null($coupon_products)) {{ $coupon_products->contains($product->id) ? 'selected' : '' }} @endif>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>
                        <!-- products & categories -->



                        <!-- configurations -->
                        <div class="card mb-4" id="section-3">
                            <div class="card-body">
                                <h5 class="mb-4">{{ localize('Coupon Configurations') }}</h5>
                                <div class="mb-4">
                                    <label class="form-label">{{ localize('Minimum Spend') }}</label>
                                    <input type="number" min="0" step="0.001" class="form-control"
                                        id="min_spend" name="min_spend" required value="{{ $coupon->min_spend }}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">{{ localize('Maximun Discount Amount') }}</label>
                                    <input type="number" min="0" step="0.001" class="form-control"
                                        id="max_discount_amount" name="max_discount_amount" required
                                        value="{{ $coupon->max_discount_amount }}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">{{ localize('Total Usage Limit Count') }}</label>
                                    <input type="number" min="1" class="form-control" id="total_usage_limit"
                                        name="total_usage_limit" required value="{{ $coupon->total_usage_limit }}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">{{ localize('Usage Limit Per Customer') }}</label>
                                    <input type="number" min="1" class="form-control" id="customer_usage_limit"
                                        name="customer_usage_limit" required value="{{ $coupon->customer_usage_limit }}">
                                </div>
                            </div>
                        </div>
                        <!-- configurations -->

                        <!-- submit button -->
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-4">
                                    <button class="btn btn-primary" type="submit">
                                        <i data-feather="save" class="me-1"></i> {{ localize('Save Changes') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- submit button end -->

                    </form>
                </div>

                <!--right sidebar-->
                <div class="col-xl-3 order-1 order-md-1 order-lg-1 order-xl-2">
                    <div class="card tt-sticky-sidebar d-none d-xl-block">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Coupon Information') }}</h5>
                            <div class="tt-vertical-step">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="#section-1" class="active">{{ localize('Basic Information') }}</a>
                                    </li>
                                    <li>
                                        <a href="#section-2">{{ localize('Products & Categories') }}</a>
                                    </li>
                                    <li>
                                        <a href="#section-3">{{ localize('Coupon Configuration') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        "use strict";

        // runs when the document is ready --> for media files
        $(document).ready(function() {
            getChosenFilesCount();
            showSelectedFilePreviewOnLoad();
        });
    </script>
@endsection
