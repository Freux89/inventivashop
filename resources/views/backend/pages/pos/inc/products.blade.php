@foreach ($products as $product)
    @php
        $isVariantProduct = 0;
        $stock = 0;
        $code = null;
        $product_variation = null;
        
        if ($product->variations()->count() > 1) {
            $isVariantProduct = 1;
        } else {
            $product_variation = $product->variations[0];
        
            $product_variation_stock = $product->variations[0]->product_variation_stock;
            if ($product_variation_stock) {
                $stock = $product_variation_stock->stock_qty;
            }
        
            $code = $product_variation->code;
        }
    @endphp

    <div class="col-auto"
        @if ($isVariantProduct) onclick="showVariantModal({{ $product->id }})"@else onclick="addToPosCart({{ $product_variation->id }})" @endif>
        <div class="tt-single-pos-item card border-0 flex-row align-items-center p-2">
            <div class="img-left me-2">
                <img src="{{ uploadedAsset($product->thumbnail_image) }}" alt="" class="img-fluid">
            </div>
            <div class="d-flex flex-column">

                @if (!$isVariantProduct)
                    @if ($code != null)
                        <small class="text-muted">{{ localize('Code') }}: {{ $code }}</small>
                    @endif
                @endif

                <h3 class="fs-md mb-1 tt-line-clamp tt-clamp-1 fw-medium">
                    {{ $product->collectLocalization('name') }}</h3>
                <div class="heading-font fw-bold fs-sm">
                    @include('backend.pages.pos.inc.pricing', ['product' => $product])
                </div>
            </div>
        </div>
    </div>
@endforeach
