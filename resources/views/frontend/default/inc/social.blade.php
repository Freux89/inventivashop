@if (getSetting('google_login') == '1' || getSetting('facebook_login') == '1')
    @if (getSetting('google_login') == '1')
        <div class="col-sm-6">
            <a href="{{ route('social.login', ['provider' => 'google']) }}"
                class="btn btn-outline google-btn w-100 text-center d-block"><img
                    src="{{ staticAsset('frontend/default/assets/img/brands/google.png') }}" alt="google"
                    class="me-2">{{ localize('Google') }}</a>
        </div>
    @endif

    @if (getSetting('facebook_login') == '1')
        <div class="col-sm-6">
            <a href="{{ route('social.login', ['provider' => 'facebook']) }}"
                class="btn btn-outline google-btn w-100 text-center d-block"><img
                    src="{{ staticAsset('frontend/default/assets/img/brands/facebook.png') }}" alt="facebook"
                    class="me-2">{{ localize('Facebook') }}</a>
        </div>
    @endif
@endif
