@extends('layouts.auth')

@section('title')
    {{ localize('Verify Phone Number') }}
@endsection

@section('contents')
    <section class="login-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-12 tt-login-img"
                    data-background="{{ staticAsset('frontend/default/assets/img/banner/login-banner.jpg') }}"></div>
                <div class="col-lg-5 col-12 bg-white d-flex p-0 tt-login-col shadow">
                    <form class="tt-login-form-wrap p-3 p-md-6 p-lg-6 py-7 w-100"
                        action="{{ route('phone.verification.confirmation') }}" method="POST">
                        @csrf
                        <div class="mb-7">
                            <a href="{{ route('home') }}">
                                <img src="{{ uploadedAsset(getSetting('navbar_logo')) }}" alt="logo">
                            </a>
                        </div>
                        <h2 class="mb-4 h3">{{ localize('Verify Your Phone Number') }}
                        </h2>

                        <div class="row g-3">
                            <div class="col-sm-12">
                                <div class="input-field">
                                    <label class="fw-bold text-dark fs-sm mb-1">{{ localize('Phone') }}
                                        <sup class="text-danger">*</sup>
                                        <small>({{ localize('Enter phone number with country code') }})</small></label>
                                    <input type="phone" id="phone" name="phone"
                                        placeholder="{{ localize('Enter your phone number') }}" class="theme-input"
                                        value="{{ $user->phone }}" required disabled>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="input-field">
                                    <label class="fw-bold text-dark fs-sm mb-1">{{ localize('Verification Code') }}</label>
                                    <input type="verification_code" id="verification_code" name="verification_code"
                                        placeholder="{{ localize('Enter verification code') }}" class="theme-input">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary mt-4">
                                    {{ localize('Verify') }}
                                </button>
                            </div>
                            <p class="mb-0 fs-xs mt-3">{{ localize("Don't have get any code?") }} <a
                                    href="">{{ localize('Resend') }}</a></p>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
