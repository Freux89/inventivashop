<div class="modal fade" id="addItemCode" tabindex="-1" aria-labelledby="addItemCodeLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h2 class="modal-title h5 text-capitalize" id="addItemCodeLabel">{{ localize('Enter product code') }}</h1>
            </div>
            <form action="" class="add-item-by-code-form">
                <div class="modal-body">
                    <div class="tt-search-box">
                        <div class="input-group">
                            <span class="position-absolute top-50 start-0 translate-middle-y ms-2"> <i
                                    data-feather="shopping-bag" class="text-muted"></i></span>
                            <input class="form-control rounded-start w-100 product_variation_code" type="text"
                                name="product_variation_code" placeholder="{{ localize('Enter product code') }}"
                                required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-start border-top-0">
                    <button type="button" class="btn btn-secondary cancel-code-btn"
                        data-bs-dismiss="modal">{{ localize('Cancel') }}</button>
                    <button type="submit"
                        class="btn btn-primary add-item-by-code-btn">{{ localize('Add This Item') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
