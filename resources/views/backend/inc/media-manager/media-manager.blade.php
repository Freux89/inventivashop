<div class="offcanvas offcanvas-bottom" id="offcanvasBottom" tabindex="-1">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">{{ localize('Media Files') }}</h5>
        <button class="btn-close" type="button" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body bg-secondary-subtle" data-simplebar>

        <!-- content -->
        @include('backend.inc.media-manager.media-manager-content')
        <!-- content -->

        <div class="d-grid g-3 tt-media-select">
            <button class="btn btn-primary" onclick="showSelectedFilePreview()"
                data-bs-dismiss="offcanvas">{{ localize('Select') }}</button>
        </div>

    </div>
</div>
