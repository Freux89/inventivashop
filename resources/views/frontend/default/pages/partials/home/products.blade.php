<section class="pt-80 pb-120">
    <div class="container">
        <div class="row justify-content-center g-4">
            <!--New Products-->
            <div class="col-xxl-4 col-lg-6">
                <div class="product-listing-box bg-white rounded-2">
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-5 flex-wrap">
                        <h4 class="mb-0">{{ localize('New Products') }}</h4>
                        <a href="{{ route('products.index') }}"
                            class="explore-btn text-secondary fw-bold">{{ localize('View More') }}<span class="ms-2"><i
                                    class="fas fa-arrow-right"></i></span></a>
                    </div>

                    @foreach (\App\Models\Product::isPublished()->latest()->take(3)->get() as $product)
                        <div class="mb-3">

                            @include('frontend.default.pages.partials.products.horizontal-product-card', [
                                'product' => $product,
                            ])
                        </div>
                    @endforeach
                </div>
            </div>
            <!--New Products-->

            <div class="col-xxl-4 col-lg-6">
                <div class="product-listing-box bg-white rounded-2">
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-5 flex-wrap">
                        <h4 class="mb-0">{{ localize('Best Selling') }}</h4>
                        <a href="{{ route('products.index') }}"
                            class="explore-btn text-secondary fw-bold">{{ localize('All Products') }}<span
                                class="ms-2"><i class="fas fa-arrow-right"></i></span></a>
                    </div>
                    @php
                        $best_selling_products = getSetting('best_selling_products') != null ? json_decode(getSetting('best_selling_products')) : [];
                        $products = \App\Models\Product::whereIn('id', $best_selling_products)->get();
                    @endphp

                    @foreach ($products as $product)
                        <div class="mb-3">
                            @include('frontend.default.pages.partials.products.horizontal-product-card', [
                                'product' => $product,
                            ])
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-xxl-3 col-xl-4 col-lg-5 col-md-6 col-sm-8 col-10 d-none d-xl-block d-none-1399">
                <a href="{{ getSetting('best_selling_banner_link') }}" class=""><img
                        src="{{ uploadedAsset(getSetting('best_selling_banner')) }}" alt=""
                        class="img-fluid rounded-2 d-flex flex-column h-100"></a>
            </div>
        </div>
    </div>
</section>
