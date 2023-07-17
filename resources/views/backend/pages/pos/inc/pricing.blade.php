@if (productBasePrice($product) == discountedProductBasePrice($product))
    @if (productBasePrice($product) == productMaxPrice($product))
        <span class="text-accent">{{ formatPrice(productBasePrice($product)) }}</span>
    @else
        <span class="text-accent">{{ formatPrice(productBasePrice($product)) }}</span>
        -
        <span class="text-accent">{{ formatPrice(productMaxPrice($product)) }}</span>
    @endif
@else
    @if (discountedProductBasePrice($product) == discountedProductMaxPrice($product))
        <span class="text-accent">{{ formatPrice(discountedProductBasePrice($product)) }}</span>
    @else
        <span class="text-accent">{{ formatPrice(discountedProductBasePrice($product)) }}</span>
        -
        <span class="text-accent">{{ formatPrice(discountedProductMaxPrice($product)) }}</span>
    @endif
@endif
