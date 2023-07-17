  <div class="modal-header border-bottom-0 pb-0">
      <h2 class="modal-title h5" id="productVariationLabel">
          <a class="d-flex align-items-center">
              <div class="avatar">
                  <img class="rounded-circle" src="{{ uploadedAsset($product->thumbnail_image) }}" alt=""
                      onerror="this.onerror=null;this.src='{{ staticAsset('backend/assets/img/placeholder-thumb.png') }}';" />
              </div>
              <h5 class="mb-0 ms-2">
                  {{ $product->collectLocalization('name') }}</h5>
          </a>
          </h1>
  </div>

  <div class="modal-body">
      @if (count(generateVariationOptions($product->variation_combinations)) > 0)
          @foreach (generateVariationOptions($product->variation_combinations) as $variation)
              <input type="hidden" name="variation_id[]" value="{{ $variation['id'] }}" class="variation-for-cart">
              <input type="hidden" name="product_id" value="{{ $product->id }}">


              <div class="tt-variation  @if (!$loop->last) mb-4 @endif">
                  <h6 class="mb-1">{{ $variation['name'] }}:</h6>

                  <ul class="list-inline product-radio-btn">

                      @if ($variation['id'] != 2)
                          @foreach ($variation['values'] as $value)
                              <li>
                                  <input type="radio" name="variation_value_for_variation_{{ $variation['id'] }}"
                                      value="{{ $value['id'] }}" id="val-{{ $value['id'] }}">
                                  <label for="val-{{ $value['id'] }}">{{ $value['name'] }}</label>
                              </li>
                          @endforeach
                      @else
                          {{-- color --}}
                          @foreach ($variation['values'] as $value)
                              <li>
                                  <input type="radio" name="variation_value_for_variation_{{ $variation['id'] }}"
                                      value="{{ $value['id'] }}" id="val-{{ $value['id'] }}">
                                  <label for="val-{{ $value['id'] }}" class="px-1 py-2">
                                      <span class="px-3 py-2 rounded" style="background-color:{{ $value['code'] }}">
                                      </span>
                                  </label>

                              </li>
                          @endforeach
                      @endif

                  </ul>
              </div>
          @endforeach
      @endif
  </div>


  <div class="modal-footer justify-content-start border-top-0">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ localize('Cancel') }}</button>
      <button type="button" class="btn btn-primary"
          onclick="addVariationProductToCart()">{{ localize('Add This Item') }}</button>
  </div>
