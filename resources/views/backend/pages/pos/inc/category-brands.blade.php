<div class="tt-pos-category-brand-wrap position-relative mb-4">
    <div class="d-flex align-items-center justify-content-between flex-wrap mb-3">
        <ul class="nav nav-pills tt-category-brand-tab d-flex align-items-center" id="pills-tab" role="tablist">
            <li class="nav-item me-2" role="presentation">
                <button class="nav-link px-3 py-1 fs-md active" id="pills-home-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                    aria-selected="true">{{ localize('Categories') }}</button>
            </li>
            <li class="nav-item me-2" role="presentation">
                <button class="nav-link px-3 py-1 fs-md" id="pills-profile-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                    aria-selected="false">{{ localize('Brands') }}</button>
            </li>


        </ul>

        @if (\App\Models\Location::count() > 1)
            @php
                if (Session::has('stock_location_id')) {
                    $location_id = session('stock_location_id');
                } else {
                    $location_id = \App\Models\Location::where('is_default', 1)->first()->id;
                }
                $location = \App\Models\Location::where('id', $location_id)->first();
            @endphp

            <div class="dropdown tt-tb-dropdown">
                <button type="button" class="btn btn-light px-3 py-1" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ $location->name }}<i data-feather="chevron-down" class="ms-1"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end shadow">


                    @foreach (\App\Models\Location::where('is_published', 1)->get() as $key => $location)
                        <a class="dropdown-item" href="javascript:void(0);" onclick="changeLocation(this)"
                            data-location="{{ $location->id }}">
                            <i data-feather="map-pin" class="me-2"></i>{{ $location->name }}
                        </a>
                    @endforeach

                </div>
            </div>
        @endif

    </div>


    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
            tabindex="0">
            <div class="tt-category-slider">
                <div class="swiper custom-swiper left-right-arrow"
                    data-swiper='{
  "slidesPerView": 4,
  "centeredSlides": false,
  "speed": 1000,
  "loop": false,
  "spaceBetween": 15,
  "breakpoints":{"320":{"slidesPerView":2},  "540":{"slidesPerView":4}, "768":{"slidesPerView":5}, "991":{"slidesPerView":5}, "1200":{"slidesPerView":6}, "1440":{"slidesPerView":7}},
  "navigation": {"nextEl": ".swiper-button-next", "prevEl": ".swiper-button-prev"}
  }'>

                    <div class="swiper-wrapper">
                        @php
                            $borderArray = ['tt-b-first', 'tt-b-second', 'tt-b-third'];
                            $sl = 0;
                        @endphp

                        <div class="swiper-slide">
                            <div class="text-center tt-single-category-brand">
                                <input type="radio" class="tt-custom-radio" name="category_id" id="tt-category-0"
                                    value="" checked onchange="getPosProducts()">
                                <label class="tt-category-brand-info tt-b-third card border-0 p-3 cursor-pointer"
                                    for="tt-category-0">
                                    <div class="tt-icon-box rounded-circle mb-3">
                                        <img src="{{ staticAsset('backend/assets/img/placeholder-thumb.png') }}"
                                            alt="category" class="img-fluid rounded-circle"
                                            onerror="this.onerror=null;this.src='{{ staticAsset('backend/assets/img/placeholder-thumb.png') }}';">
                                    </div>
                                    <h6 class="fs-sm mb-1">
                                        {{ localize('All Categories') }}
                                    </h6>
                                    <span
                                        class="fs-xs tt-available-item">{{ \App\Models\Product::isPublished()->count() }}
                                        {{ localize('Items') }}
                                    </span>
                                </label>
                            </div>
                        </div>

                        @foreach ($categories as $category)
                            <div class="swiper-slide">
                                <div class="text-center tt-single-category-brand">
                                    <input type="radio" class="tt-custom-radio" name="category_id"
                                        id="tt-category-{{ $category->id }}" value="{{ $category->id }}"
                                        onchange="getPosProducts()">
                                    <label
                                        class="tt-category-brand-info {{ $borderArray[$sl] }} card border-0 p-3 cursor-pointer"
                                        for="tt-category-{{ $category->id }}">
                                        <div class="tt-icon-box rounded-circle mb-3">
                                            <img src="{{ uploadedAsset($category->collectLocalization('thumbnail_image')) }}"
                                                alt="category" class="img-fluid">
                                        </div>
                                        <h6 class="fs-sm mb-1">
                                            {{ $category->collectLocalization('name') }}</h6>
                                        <span
                                            class="fs-xs tt-available-item">{{ \App\Models\ProductCategory::where('category_id', $category->id)->count() }}
                                            {{ localize('Items') }}
                                        </span>
                                    </label>
                                </div>
                            </div>

                            @if ($sl == 2)
                                @php
                                    $sl = 0;
                                @endphp
                            @else
                                @php
                                    $sl += 1;
                                @endphp
                            @endif
                        @endforeach

                    </div>
                </div>
                <!--navigation buttons-->
                <div class="tt-slider-indicator">
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
            tabindex="0">
            <div class="tt-category-slider">
                <div class="swiper custom-swiper left-right-arrow"
                    data-swiper='{
  "slidesPerView": 4,
  "centeredSlides": false,
  "speed": 1000,
  "loop": false,
  "spaceBetween": 15,
  "breakpoints":{"320":{"slidesPerView":2},  "540":{"slidesPerView":4}, "768":{"slidesPerView":5}, "991":{"slidesPerView":5}, "1200":{"slidesPerView":6}, "1440":{"slidesPerView":7}},
  "navigation": {"nextEl": ".swiper-button-next", "prevEl": ".swiper-button-prev"}
  }'>

                    <div class="swiper-wrapper">
                        @php
                            $borderArray = ['tt-b-first', 'tt-b-second', 'tt-b-third'];
                            $slBrand = 0;
                        @endphp

                        <div class="swiper-slide">
                            <div class="text-center tt-single-category-brand">
                                <input type="radio" class="tt-custom-radio" name="brand_id" id="tt-brand-0"
                                    value="" checked onchange="getPosProducts()">
                                <label class="tt-category-brand-info tt-b-third card border-0 p-3 cursor-pointer"
                                    for="tt-brand-0">
                                    <div class="tt-icon-box rounded-circle mb-3">
                                        <img src="{{ staticAsset('backend/assets/img/placeholder-thumb.png') }}"
                                            alt="category" class="img-fluid rounded-circle"
                                            onerror="this.onerror=null;this.src='{{ staticAsset('backend/assets/img/placeholder-thumb.png') }}';">
                                    </div>
                                    <h6 class="fs-sm mb-1">
                                        {{ localize('All Brands') }}
                                    </h6>
                                    <span
                                        class="fs-xs tt-available-item">{{ \App\Models\Product::isPublished()->count() }}
                                        {{ localize('Items') }}
                                    </span>
                                </label>
                            </div>
                        </div>

                        @foreach ($brands as $brand)
                            <div class="swiper-slide">
                                <div class="text-center tt-single-category-brand">
                                    <input type="radio" class="tt-custom-radio" name="brand_id"
                                        id="tt-brand-{{ $brand->id }}" onchange="getPosProducts()"
                                        value="{{ $brand->id }}">
                                    <label
                                        class="tt-category-brand-info {{ $borderArray[$sl] }} card border-0 p-3 cursor-pointer"
                                        for="tt-brand-{{ $brand->id }}">
                                        <div class="tt-icon-box rounded-circle mb-3">
                                            <img src="{{ uploadedAsset($brand->collectLocalization('brand_image')) }}"
                                                alt="brand" class="img-fluid">
                                        </div>
                                        <h6 class="fs-sm mb-1">
                                            {{ $brand->collectLocalization('name') }}</h6>
                                        <span
                                            class="fs-xs tt-available-item">{{ \App\Models\Product::where('brand_id', $brand->id)->count() }}
                                            {{ localize('Items') }}
                                        </span>
                                    </label>
                                </div>
                            </div>

                            @if ($slBrand == 2)
                                @php
                                    $slBrand = 0;
                                @endphp
                            @else
                                @php
                                    $slBrand += 1;
                                @endphp
                            @endif
                        @endforeach
                    </div>
                </div>
                <!--navigation buttons-->
                <div class="tt-slider-indicator">
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
    </div>
</div>
