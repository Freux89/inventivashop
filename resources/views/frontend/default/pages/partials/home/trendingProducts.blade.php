<section class="pt-8 pb-100 bg-white position-relative overflow-hidden z-1 trending-products-area">
    <img src="{{ staticAsset('frontend/default/assets/img/shapes/garlic.png') }}" alt="garlic"
        class="position-absolute garlic z--1" data-parallax='{"y": 100}'>
    <img src="{{ staticAsset('frontend/default/assets/img/shapes/carrot.png') }}" alt="carrot"
        class="position-absolute carrot z--1" data-parallax='{"y": -100}'>
    <img src="{{ staticAsset('frontend/default/assets/img/shapes/mashrom.png') }}" alt="mashrom"
        class="position-absolute mashrom z--1" data-parallax='{"x": 100}'>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-5">
                <div class="section-title text-center text-xl-start">
                    <h3 class="mb-0">{{ localize('Top Trending Products') }}</h3>
                </div>
            </div>
            <div class="col-xl-7">
                <div class="filter-btns gshop-filter-btn-group text-center text-xl-end mt-4 mt-xl-0">

                    @php
                        $trending_product_categories = getSetting('trending_product_categories') != null ? json_decode(getSetting('trending_product_categories')) : [];
                        $categories = \App\Models\Category::whereIn('id', $trending_product_categories)->get();
                    @endphp
                    <button class="active" data-filter="*">{{ localize('All Products') }}</button>
                    @foreach ($categories as $category)
                        <button data-filter=".{{ $category->id }}">{{ $category->collectLocalization('name') }}</button>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row justify-content-center g-4 mt-5 filter_group">

            @php
                $trending_products = getSetting('top_trending_products') != null ? json_decode(getSetting('top_trending_products')) : [];
                $products = \App\Models\Product::whereIn('id', $trending_products)->get();
            @endphp

            @foreach ($products as $product)
                <div
                    class="col-xxl-3 col-lg-4 col-md-6 col-sm-10 filter_item
                    @php
if($product->categories()->count() > 0){ 
                            foreach ($product->categories as $category) {
                               echo $category->id .' ';
                            }
                        } @endphp">
                    @include('frontend.default.pages.partials.products.trending-product-card', [
                        'product' => $product,
                    ])
                </div>
            @endforeach
        </div>
    </div>
</section>
