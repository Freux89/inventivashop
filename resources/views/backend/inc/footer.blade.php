<!--footer section start-->
<footer class="tt-footer bg-light-subtle py-3 mt-auto">
    <div class="container">
        <div class="row g-3">
            <div class="col-md-6 order-last order-md-first">
                <div class="copyright text-center text-md-start">
                    {!! getSetting('copyright_text') !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-center justify-content-md-end">
                    {{ env('APP_NAME') }}<strong class="ms-2">{{ env('APP_VERSION') }}</strong>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--footer section end-->
