@extends('backend.layouts.master')

@section('title')
    {{ localize('SMTP Configuration') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection


@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-lg-0">{{ localize('SMTP Settings') }}</h2>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!--left sidebar-->
                <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">
                    <form action="{{ route('admin.envKey.update') }}" method="POST" enctype="multipart/form-data"
                        class="pb-650">
                        @csrf
                        <div class="card mb-4" id="section-1">
                            <div class="card-body">
                                <h5 class="mb-4">{{ localize('Basic Information') }}</h5>


                                <div class="mb-4">
                                    <input type="hidden" name="types[]" value="MAIL_MAILER">
                                    <label for="subscriber_emails" class="form-label">{{ localize('Type') }}</label>
                                    <select class="form-control select2 mb-2 mb-md-0" name="MAIL_MAILER"
                                        onchange="checkMailDriver()" data-toggle="select2">
                                        <option value="sendmail" @if (env('MAIL_MAILER') == 'sendmail') selected @endif>
                                            {{ localize('Sendmail') }}</option>
                                        <option value="smtp" @if (env('MAIL_MAILER') == 'smtp') selected @endif>
                                            {{ localize('SMTP') }}</option>
                                    </select>
                                </div>

                                <div id="smtp">

                                    <div class="mb-4">
                                        <input type="hidden" name="types[]" value="MAIL_HOST">
                                        <label for="MAIL_HOST" class="form-label">{{ localize('Mail Host') }}</label>
                                        <input type="text" name="MAIL_HOST" id="MAIL_HOST" class="form-control"
                                            placeholder="{{ localize('Type mail Host') }}" required
                                            value="{{ env('MAIL_HOST') }}">
                                    </div>

                                    <div class="mb-4">
                                        <input type="hidden" name="types[]" value="MAIL_PORT">
                                        <label for="MAIL_PORT" class="form-label">{{ localize('Mail Port') }}</label>
                                        <input type="text" name="MAIL_PORT" id="MAIL_PORT" class="form-control"
                                            placeholder="{{ localize('Type mail port') }}" required
                                            value="{{ env('MAIL_PORT') }}">
                                    </div>

                                    <div class="mb-4">
                                        <input type="hidden" name="types[]" value="MAIL_USERNAME">
                                        <label for="MAIL_USERNAME"
                                            class="form-label">{{ localize('Mail Username') }}</label>
                                        <input type="text" name="MAIL_USERNAME" id="MAIL_USERNAME" class="form-control"
                                            placeholder="{{ localize('Type mail username') }}" required
                                            value="{{ env('MAIL_USERNAME') }}">
                                    </div>

                                    <div class="mb-4">
                                        <input type="hidden" name="types[]" value="MAIL_PASSWORD">
                                        <label for="MAIL_PASSWORD"
                                            class="form-label">{{ localize('Mail Password') }}</label>
                                        <input type="text" name="MAIL_PASSWORD" id="MAIL_PASSWORD" class="form-control"
                                            placeholder="{{ localize('Type mail password') }}" required
                                            value="{{ env('MAIL_PASSWORD') }}">
                                    </div>

                                    <div class="mb-4">
                                        <input type="hidden" name="types[]" value="MAIL_ENCRYPTION">
                                        <label for="MAIL_ENCRYPTION"
                                            class="form-label">{{ localize('Mail Encryption') }}</label>
                                        <input type="text" name="MAIL_ENCRYPTION" id="MAIL_ENCRYPTION"
                                            class="form-control" placeholder="{{ localize('Type mail encryption') }}"
                                            required value="{{ env('MAIL_ENCRYPTION') }}">
                                    </div>

                                    <div class="mb-4">
                                        <input type="hidden" name="types[]" value="MAIL_FROM_ADDRESS">
                                        <label for="MAIL_FROM_ADDRESS"
                                            class="form-label">{{ localize('Mail From Address') }}</label>
                                        <input type="text" name="MAIL_FROM_ADDRESS" id="MAIL_FROM_ADDRESS"
                                            class="form-control" placeholder="{{ localize('Type mail from address') }}"
                                            required value="{{ env('MAIL_FROM_ADDRESS') }}">
                                    </div>

                                    <div class="mb-4">
                                        <input type="hidden" name="types[]" value="MAIL_FROM_NAME">
                                        <label for="MAIL_FROM_NAME"
                                            class="form-label">{{ localize('Mail From Name') }}</label>
                                        <input type="text" name="MAIL_FROM_NAME" id="MAIL_FROM_NAME"
                                            class="form-control" placeholder="{{ localize('Type mail from name') }}"
                                            required value="{{ env('MAIL_FROM_NAME') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <button class="btn btn-primary" type="submit">
                                <i data-feather="save" class="me-1"></i> {{ localize('Save Configuration') }}
                            </button>
                        </div>
                    </form>
                </div>

                <!--right sidebar-->
                <div class="col-xl-3 order-1 order-md-1 order-lg-1 order-xl-2">
                    <div class="card tt-sticky-sidebar d-none d-xl-block">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Configure SMTP') }}</h5>
                            <div class="tt-vertical-step">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="#section-1" class="active">{{ localize('SMTP Information') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('scripts')
    <script type="text/javascript">
        "use strict";

        $(document).ready(function() {
            checkMailDriver();
        });

        function checkMailDriver() {
            $('#smtp').show();
        }
    </script>
@endsection
