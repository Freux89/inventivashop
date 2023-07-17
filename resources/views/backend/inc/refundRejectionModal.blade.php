<div id="rejection-modal" class="modal fade">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ localize('Rejection Confirmation') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body text-center">
                <div class="display-4 text-danger"> <i data-feather="check-circle"></i></div>
                <h6 class="my-0 mb-3">{{ localize('Are you sure to reject this?') }}</h6>
                <form action="" class="rejection-form" method="post">
                    @csrf
                    <div class="mb-4">
                        <textarea class="form-control" id="refund_reject_reason" placeholder="{{ localize('Type rejection reason') }}"
                            name="refund_reject_reason" required></textarea>
                    </div>

                    <div class="text-start pb-3">
                        <button type="submit" class="btn btn-danger mt-2">{{ localize('Proceed') }}</button>
                        <button type="button" class="btn btn-secondary mt-2"
                            data-bs-dismiss="modal">{{ localize('Cancel') }}</button>
                </form>

            </div>
        </div>

    </div>
</div>
</div>
