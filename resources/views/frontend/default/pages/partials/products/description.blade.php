<div class="product-info-tab bg-white rounded-2 overflow-hidden pt-6 mt-4">
    <ul class="nav nav-tabs border-bottom justify-content-center gap-5 pt-info-tab-nav">
        <li><a href="#description" class="active" data-bs-toggle="tab">{{ localize('Description') }}</a></li>
        <li><a href="#info" data-bs-toggle="tab">{{ localize('Additional Information') }}</a></li>

    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active px-4 py-5" id="description">
            @if ($product->description)
                {!! $product->collectLocalization('description') !!}
            @else
                <div class="text-dark text-center border py-2">{{ localize('Not Available') }}
                </div>
            @endif
        </div>
        <div class="tab-pane fade px-4 py-5" id="info">
            <h6 class="mb-2">{{ localize('Additional Information') }}:</h6>
            <table class="w-100 product-info-table">
                @forelse (generateVariationOptions($product->variation_combinations) as $variation)
                    <tr>
                        <td class="text-dark fw-semibold">{{ $variation['name'] }}</td>
                        <td>
                            @foreach ($variation['values'] as $value)
                                {{ $value['name'] }}@if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td class="text-dark text-center" colspan="2">{{ localize('Not Available') }}
                            </td>
                        </tr>
                    @endforelse
                </table>
            </div>

        </div>
    </div>
    </div>
