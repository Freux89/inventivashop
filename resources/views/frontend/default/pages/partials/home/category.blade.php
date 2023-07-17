<section class="gshop-category-section bg-white pt-120 position-relative z-1 overflow-hidden">
    <img src="{{ staticAsset('frontend/default/assets/img/shapes/bg-shape.png') }}" alt="bg shape"
        class="position-absolute bottom-0 start-0 w-100 z--1">
    <div class="container">
        <div class="gshop-category-box border-secondary rounded-3 bg-white">
            <div class="text-center section-title">
                <h4 class="d-inline-block px-2 bg-white mb-4">{{ localize('Our Top Categories') }}</h4>
            </div>
            <div class="row justify-content-center g-4">
                @php
                    $top_category_ids = getSetting('top_category_ids') != null ? json_decode(getSetting('top_category_ids')) : [];
                    $categories = \App\Models\Category::whereIn('id', $top_category_ids)->get();
                @endphp

                @foreach ($categories as $category)
                    @php
                        $productsCount = \App\Models\ProductCategory::where('category_id', $category->id)->count();
                    @endphp
                    <div class="col-xxl-2 col-lg-3 col-md-4 col-sm-6">
                        <div
                            class="gshop-animated-iconbox py-5 px-4 text-center border rounded-3 position-relative overflow-hidden {{ $loop->even ? 'color-2' : '' }}">
                            <div
                                class="animated-icon d-inline-flex align-items-center justify-content-center rounded-circle position-relative">
                                <img src="{{ uploadedAsset($category->collectLocalization('thumbnail_image')) }}"
                                    alt="" class="img-fluid">
                            </div>

                            <a href="{{ route('products.index') }}?&category_id={{ $category->id }}"
                                class="text-dark fs-sm fw-bold d-block mt-3">{{ $category->collectLocalization('name') }}</a>
                            <span
                                class="total-count position-relative ps-3 fs-sm fw-medium doted-primary">{{ $productsCount }}
                                {{ localize('Items') }}</span>

                            <a href="{{ route('products.index') }}?&category_id={{ $category->id }}"
                                class="explore-btn position-absolute"><i class="fa-solid fa-arrow-up"></i></a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
