<div class="modal fade" id="cardModal" tabindex="-1" aria-labelledby="cardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h2 class="modal-title h5" id="cardModalLabel">{{ localize('Card Details') }}</h1>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="mb-0">
                            <label for="customerName" class="form-label">{{ localize('Owner Name') }}</label>
                            <input class="form-control" type="text" id="customerName"
                                placeholder="{{ localize('Type owner name') }}" name="card_owner_name">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-0">
                            <label for="cardNumber" class="form-label">{{ localize('Card Number') }}</label>
                            <input class="form-control" type="number" id="cardNumber"
                                placeholder="{{ localize('Debit/Credit card number') }}" name="card_number">
                        </div>
                    </div>
                    <div class="col-12 col-sm-9">
                        <div class="mb-0">
                            <label for="expiration" class="form-label">{{ localize('Expiration') }}</label>
                            <input class="form-control" type="text" id="expiration" placeholder="12/30"
                                name="expiration">
                        </div>
                    </div>
                    <div class="col-12 col-sm-3">
                        <div class="mb-0">
                            <label for="cvv" class="form-label">{{ localize('CVV') }}</label>
                            <input class="form-control" type="text" id="cvv" name="cvv">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-start border-top-0">
                <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">{{ localize('Cancel') }}</button>
                <button type="button" class="btn btn-primary"
                    data-bs-dismiss="modal">{{ localize('Apply Now') }}</button>
            </div>
        </div>
    </div>
</div>
