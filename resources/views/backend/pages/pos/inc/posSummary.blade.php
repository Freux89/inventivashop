  @php
      // to calculate grand total
      $shipping = 0;
      $discount = 0;
      
      // to show in input value of summary
      $shippingInputValue = 0;
      $discountInputValue = 0;
      
      $discountType = 'flat';
      $subtotal = getSubTotal($carts, false, '', false) + getTotalTax($carts);
      
      // to convert input price to base price
      if (Session::has('currency_code')) {
          $currency_code = Session::get('currency_code', Config::get('app.currency_code'));
      } else {
          $currency_code = env('DEFAULT_CURRENCY');
      }
      $currentCurrency = \App\Models\Currency::where('code', $currency_code)->first();
      
      // calculate shipping amount
      if (isset($shippingAmount)) {
          $shippingInputValue = $shippingAmount;
          $shippingAmount = $shippingAmount / $currentCurrency->rate; // convert to base price
          $shipping = $shippingAmount;
      }
      
      // check discount type
      if (isset($discountTypeOption)) {
          $discountType = $discountTypeOption; //flat or percent
      }
      
      if (isset($discountAmount)) {
          $discountInputValue = $discountAmount;
          if ($discountType == 'flat') {
              $discount = $discountAmount / $currentCurrency->rate; // convert to base price
          } else {
              $discount = ($subtotal * $discountAmount) / 100;
          }
      }
      
      $total = $subtotal + $shipping - $discount;
  @endphp

  <div class="tt-pos-calculation mb-3">
      <div class="tt-pos-cal">
          <p class="mb-0">{{ localize('Subtotal') }}</p>
          <strong>{{ formatPrice(getSubTotal($carts, false, '', false)) }}</strong>
      </div>
      <div class="tt-pos-cal">
          <p class="mb-0">{{ localize('Tax') }}</p>
          <strong>{{ formatPrice(getTotalTax($carts)) }}</strong>
      </div>

      <div class="tt-pos-cal">
          <p class="mb-0">{{ localize('Shipping Charge') }}</p>
          <input class="form-control col-6" type="number" placeholder="{{ localize('Type discount amount') }}"
              id="total_shipping_cost" value="{{ $shippingInputValue }}" step="0.001" min="0"
              name="total_shipping_cost">
      </div>

      <div class="tt-pos-cal">
          <div class="row g-3">
              <div class="col-12">
                  <label for="discount_value" class="form-label">{{ localize('Additional Discount') }}</label>
                  <div class="input-group row g-0">
                      <input class="form-control col-6 rounded-end-0" type="number"
                          placeholder="{{ localize('Type discount amount') }}" id="additional_discount_value"
                          value="{{ $discountInputValue }}" step="0.001" min="0"
                          name="additional_discount_value">

                      <select class="select2 form-control input-group-append col-6 rounded-start-0"
                          id="additional_discount_type" name="additional_discount_type"
                          onchange="calculatePosSummary()">
                          <option value="flat" @if ($discountType == 'flat') selected @endif>
                              {{ localize('Fixed') }}</option>
                          <option value="percent" @if ($discountType == 'percent') selected @endif>
                              {{ localize('Percent %') }}</option>
                      </select>
                  </div>
              </div>

          </div>
      </div>
  </div>

  <!-- payment  -->
  <div class="tt-pos-payment mb-3">
      <div class="tt-single-pos-payment">
          <input type="radio" class="tt-custom-radio" name="payment" id="cashPayment" value="cash" checked />
          <label for="cashPayment"
              class="tt-payment btn btn-sm btn-secondary fw-semibold d-block">{{ localize('Cash') }}</label>
      </div>
      <div class="tt-single-pos-payment">
          <input type="radio" class="tt-custom-radio" name="payment" id="cardPayment" value="card">
          <label for="cardPayment" class="tt-payment btn btn-sm btn-secondary fw-semibold d-block"
              data-bs-toggle="modal" data-bs-target="#cardModal">{{ localize('Card') }}</label>
      </div>
      <div class="tt-single-pos-payment">
          <input type="radio" class="tt-custom-radio" name="payment" id="cod" value="cod">
          <label for="cod"
              class="tt-payment btn btn-sm btn-secondary fw-semibold d-block">{{ localize('COD') }}</label>
      </div>
  </div>
  <!-- payment -->

  <!-- card modal start -->
  @include('backend.pages.pos.inc.payment')
  <!-- card modal end -->

  <button type="submit"
      class="btn btn-primary btn-lg d-flex justify-content-between btn-block w-100 fw-semibold complete-order-btn">
      <span>{{ localize('Complete Order') }}</span>
      <strong>{{ formatPrice($total) }}</strong>
  </button>
