<div id="delete-modal" class="modal fade">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ localize('Delete Confirmation') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body text-center">
                <div class="display-4 text-danger"> <i data-feather="x-octagon"></i></div>
                <h6 class="my-0">{{ localize('Are you sure to delete this?') }}</h6>
                <p>{{ localize('All data related to this may get deleted.') }}</p>
                <div class="justify-content-center pb-3">
                    <a href="" id="delete-link" class="btn btn-danger mt-2">{{ localize('Proceed') }}</a>
                    <button type="button" class="btn btn-secondary mt-2"
                        data-bs-dismiss="modal">{{ localize('Cancel') }}</button>
                </div>
            </div>

        </div>
    </div>
</div>
