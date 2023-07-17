<div class="modal-header border-bottom-0 pb-0">
    <h2 class="modal-title h5" id="addCustomerLabel">{{ localize('Existing Customer') }}</h2>
    <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body mb-3">
    <form action="#" class="existing-customer-form">
        @csrf
        <div class="mb-2">
            <label class="form-label">{{ localize('Select Customer') }}</label>
            <select class="form-select modalSelect2 w-100" name="pos_customer_id" required>
                <option value="">{{ localize('Select customer from list') }}</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->email }} -
                        {{ $customer->phone }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-2">
            <label for="customerAddress" class="form-label">{{ localize('Address') }}</label>
            <textarea class="form-control" name="pos_customer_address" id="customerAddress"
                placeholder="{{ localize('Customer address') }}"></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-3">{{ localize('Select') }}</button>
    </form>
</div>

<div class="modal-body">
    <h2 class="modal-title h5 mb-3" id="addCustomerLabel">{{ localize('Add New Customer') }}</h1>
        <form action="#" class="pos-new-customer">
            @csrf
            <div class="row g-3">
                <div class="col-12 col-sm-6">
                    <div class="mb-0">
                        <label for="customerName" class="form-label">{{ localize('Customer Name') }}</label>
                        <input class="form-control" type="text" id="customerName" name="new_pos_customer_name"
                            placeholder="{{ localize('Type customer name') }}" required>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="mb-0">
                        <label for="customerPhone" class="form-label">{{ localize('Phone Number') }}</label>
                        <input class="form-control" type="text" id="customerPhone" name="new_pos_customer_phone"
                            placeholder="{{ localize('Type customer phone') }}">
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-0">
                        <label for="customerEmail" class="form-label">{{ localize('Email') }}</label>
                        <input class="form-control" type="email" id="customerEmail" name="new_pos_customer_email"
                            placeholder="{{ localize('Type customer email') }}">
                    </div>
                </div>

                <div class="col-12">
                    <div class="mb-2">
                        <label for="new_customer_address" class="form-label">{{ localize('Address') }}</label>
                        <textarea class="form-control" name="new_customer_address" id="new_customer_address"
                            placeholder="{{ localize('Customer address') }}"></textarea>
                    </div>
                </div>

                <div class="col-12">
                    <div class="mb-0">
                        <button type="submit"
                            class="btn btn-primary save-select-btn">{{ localize('Save & Select') }}</button>
                    </div>
                </div>
            </div>
        </form>
</div>
