@extends('frontend.default.layouts.master')

@section('title')
    {{ localize('Conatct Us') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('breadcrumb-contents')
    <div class="breadcrumb-content">
        <h2 class="mb-2 text-center">{{ localize('Get In Touch') }}</h2>
        <nav>
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item fw-bold" aria-current="page"><a
                        href="{{ route('home') }}">{{ localize('Home') }}</a></li>
                <li class="breadcrumb-item fw-bold" aria-current="page"><a
                        href="{{ route('home.pages.contactUs') }}">{{ localize('Contact Us') }}</a></li>
            </ol>
        </nav>
    </div>
@endsection

@section('contents')
    <!--breadcrumb-->
    @include('frontend.default.inc.breadcrumb')
    <!--breadcrumb-->

    <!--contact us section start-->
    <section class="contact-us-section position-relative overflow-hidden z-1 pt-80 pb-120">
        <div class="container">
            <div class="contact-box rounded-2 bg-white overflow-hidden mt-8">
                <div class="row g-4">
                    <div class="col-xl-5">
                        <div class="contact-left-box position-relative overflow-hidden z-1 bg-primary p-6 d-flex flex-column h-100"
                            data-background="{{ staticAsset('frontend/default/assets/img/shapes/circle-half-fill.png') }}">
                            <img src="{{ staticAsset('frontend/default/assets/img/shapes/texture-overlay.png') }}"
                                alt="texture" class="position-absolute w-100 h-100 start-0 top-0 z--1">
                            <h3 class="text-white mb-3">{{ localize('Contact Details') }}</h3>
                            <p class="fs-sm text-white"><strong>{{ localize('Office Address') }}:
                                </strong>{{ getSetting('topbar_location') }}
                            </p>
                            <span class="spacer my-5"></span>
                            <ul class="contact-list">
                                <li class="d-flex align-items-center gap-3 flex-wrap">
                                    <span
                                        class="icon d-inline-flex align-items-center justify-content-center rounded-circle flex-shrink-0">
                                        <i class="fa-brands fa-whatsapp"></i>
                                    </span>
                                    <div class="info">
                                        <span class="fw-medium text-white fs-xs">{{ localize('Emergency Call') }}</span>
                                        <h5 class="mb-0 mt-1 text-white">{{ getSetting('navbar_contact_number') }}</h5>
                                    </div>
                                </li>
                                <li class="d-flex align-items-center gap-3 flex-wrap mt-3">
                                    <span
                                        class="icon d-inline-flex align-items-center justify-content-center rounded-circle flex-shrink-0">
                                        <i class="fa-regular fa-envelope"></i>
                                    </span>
                                    <div class="info">
                                        <span
                                            class="fw-medium text-white fs-xs">{{ localize('General Communicationl') }}</span>
                                        <p class="mb-0 mt-1 text-white fw-medium">{{ getSetting('topbar_email') }}</p>
                                    </div>
                                </li>
                            </ul>
                            <div class="mt-5">
                                <span class="fw-bold text-white mb-3 d-block">{{ localize('Find us on') }}:</span>
                                <div class="social-links d-flex align-items-center gap-2">
                                    <a href="{{ getSetting('facebook_link') }}"><i class="fab fa-facebook-f"></i></a>
                                    <a href="{{ getSetting('twitter_link') }}" target="_blank"><i
                                            class="fab fa-twitter"></i></a>
                                    <a href="{{ getSetting('linkedin_link') }}" target="_blank"><i
                                            class="fab fa-linkedin"></i></a>
                                    <a href="{{ getSetting('youtube_link') }}" target="_blank"><i
                                            class="fab fa-youtube"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7">
                        <form class="contact-form ps-4 ps-xl-0 py-8 pe-5 contact-form ps-5 ps-xl-4 py-6 pe-6"
                            action="{{ route('contactUs.store') }}" method="POST">
                            @csrf
                            <h3 class="mb-6">{{ localize('Need Help? Send Message') }}</h3>
                            <div class="row g-4">

                                <div class="col-sm-12">
                                    <div class="label-input-field">
                                        <label>{{ localize('Name') }}</label>
                                        <input type="text" name="name" placeholder="{{ localize('Your name') }}"
                                            required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="label-input-field">
                                        <label>{{ localize('Email') }}</label>
                                        <input type="email" name="email" placeholder="{{ localize('You email') }}"
                                            required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="label-input-field">
                                        <label>{{ localize('Phone') }}</label>
                                        <input type="text" name="phone" placeholder="{{ localize('You phone') }}"
                                            required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="checkbox-fields d-flex align-items-center gap-3 flex-wrap my-2">
                                        <div class="single-field d-inline-flex align-items-center gap-2">
                                            <div class="theme-checkbox">
                                                <input type="radio" name="support_for" value="delivery_problem" checked>
                                                <span class="checkbox-field"><i class="fas fa-check"></i></span>
                                            </div>
                                            <label class="text-dark fw-semibold">{{ localize('Delivery Problem') }}</label>
                                        </div>
                                        <div class="single-field d-inline-flex align-items-center gap-2">
                                            <div class="theme-checkbox">
                                                <input type="radio" name="support_for" value="customer_service">
                                                <span class="checkbox-field"><i class="fas fa-check"></i></span>
                                            </div>
                                            <label class="text-dark fw-semibold">{{ localize('Customer Service') }}</label>
                                        </div>
                                        <div class="single-field d-inline-flex align-items-center gap-2">
                                            <div class="theme-checkbox">
                                                <input type="radio" name="support_for" value="other_service">
                                                <span class="checkbox-field"><i class="fas fa-check"></i></span>
                                            </div>
                                            <label class="text-dark fw-semibold">{{ localize('Others Service') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="label-input-field">
                                        <label>{{ localize('Messages') }}</label>
                                        <textarea name="message" placeholder="{{ localize('Write your message') }}" rows="6" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit"
                                class="btn btn-primary btn-md rounded-1 mt-6">{{ localize('Send Message') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--contact us section end-->
@endsection
