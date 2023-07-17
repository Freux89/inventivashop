@extends('layouts.auth')

@section('title')
    {{ localize('Reset Password') }}
@endsection

@section('contents')
    <section class="login-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-12 tt-login-img"
                    data-background="{{ staticAsset('frontend/default/assets/img/banner/login-banner.jpg') }}"></div>
                <div class="col-lg-5 col-12 bg-white d-flex p-0 tt-login-col shadow">
                    <form class="tt-login-form-wrap p-3 p-md-6 p-lg-6 py-7 w-100" action="{{ route('password.email') }}"
                        method="POST">
                        @csrf

                        <div class="mb-7">
                            <a href="{{ route('home') }}">
                                <img src="{{ uploadedAsset(getSetting('navbar_logo')) }}" alt="logo">
                            </a>
                        </div>
                        <h2 class="mb-4 h3">{{ localize('Reset Password') }}
                        </h2>

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row g-3">
                            <div class="col-sm-12">

                                <input type="hidden" name="reset_with" class="reset_with" value="email">

                                <div class="input-field">

                                    <span class="reset-email @if (old('reset_with') == 'phone') d-none @endif">
                                        <label class="fw-bold text-dark fs-sm mb-1">{{ localize('Email') }}</label>
                                        <input type="email" id="email" name="email"
                                            placeholder="{{ localize('Enter your email') }}"
                                            class="theme-input mb-1 @error('email') is-invalid @enderror"
                                            value="{{ old('email') }}" required>

                                        <small class="">
                                            <a href="javascript:void(0);" class="fs-sm reset-with-phone-btn"
                                                onclick="handleResetWithPhone()">
                                                {{ localize('Reset with phone?') }}</a>
                                        </small>
                                    </span>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    <span class="reset-phone @if (old('reset_with') == 'email' || old('reset_with') == '') d-none @endif">
                                        <label class="fw-bold text-dark fs-sm mb-1">{{ localize('Phone') }}</label>
                                        <input type="text" id="phone" name="phone" placeholder="+xxxxxxxxxx"
                                            class="theme-input mb-1" value="{{ old('phone') }}">

                                        <small class="">
                                            <a href="javascript:void(0);" class="fs-sm reset-with-email-btn"
                                                onclick="handleResetWithEmail()">
                                                {{ localize('Reset with email?') }}</a>
                                        </small>
                                    </span>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary mt-4">
                                    {{ localize('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection



@section('scripts')
    <script>
        "use strict";


        // change input to phone
        function handleResetWithPhone() {
            $('.reset_with').val('phone');

            $('.reset-email').addClass('d-none');
            $('.reset-email input').prop('required', false);

            $('.reset-phone').removeClass('d-none');
            $('.reset-phone input').prop('required', true);
        }

        // change input to email
        function handleResetWithEmail() {
            $('.reset_with').val('email');
            $('.reset-email').removeClass('d-none');
            $('.reset-email input').prop('required', true);

            $('.reset-phone').addClass('d-none');
            $('.reset-phone input').prop('required', false);
        }
    </script>
@endsection
