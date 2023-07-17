@extends('frontend.default.layouts.master')

@section('title')
    {{ localize('Customer Profile') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    <section class="my-account pt-6 pb-120">
        <div class="container">

            @include('frontend.default.pages.users.partials.customerHero')

            <div class="row g-4">
                <div class="col-xl-3">
                    @include('frontend.default.pages.users.partials.customerSidebar')
                </div>

                <div class="col-xl-9">
                    <div class="update-profile bg-white py-5 px-4">
                        <h6 class="mb-4">{{ localize('Update Profile') }}</h6>
                        <form class="profile-form" action="{{ route('customers.updateProfile') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="type" value="info">
                            <div class="file-upload text-center rounded-3 mb-5">
                                <input type="file" name="avatar">
                                <img src="{{ staticAsset('frontend/default/assets/img/icons/image.svg') }}" alt="dp"
                                    class="img-fluid">
                                <p class="text-dark fw-bold mb-2 mt-3">{{ localize('Drop your files here or browse') }}</p>
                                <p class="mb-0 file-name"></p>
                            </div>
                            <div class="row g-4">
                                <div class="col-sm-12">
                                    <div class="label-input-field">
                                        <label>{{ localize('Name') }}</label>
                                        <input type="text" name="name" placeholder="{{ localize('Your Name') }}"
                                            value="{{ $user->name }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="label-input-field">
                                        <label>{{ localize('Email Address') }}</label>
                                        <input type="email" name="email" placeholder="{{ localize('Your Email') }}"
                                            value="{{ $user->email }}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="label-input-field">
                                        <label>{{ localize('Phone') }}</label>
                                        <input type="text" name="phone" placeholder="{{ localize('Your Phone') }}"
                                            value="{{ $user->phone }}">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-6">{{ localize('Update Profile') }}</button>
                        </form>
                    </div>

                    <div class="change-password bg-white py-5 px-4 mt-4 rounded">
                        <h6 class="mb-4">{{ localize('Change Password') }}</h6>
                        <form class="password-reset-form" action="{{ route('customers.updateProfile') }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="password">
                            <div class="row g-4">
                                <div class="col-sm-6">
                                    <div class="label-input-field">
                                        <label>{{ localize('New Password') }}</label>
                                        <input type="password" name="password" placeholder="******" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="label-input-field">
                                        <label>{{ localize('Re-type Password') }}</label>
                                        <input type="password" name="password_confirmation" placeholder="******" required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-6">{{ localize('Change Password') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
