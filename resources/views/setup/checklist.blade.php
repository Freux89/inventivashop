@extends('layouts.setup')
@section('contents')
    <div class="container h-100 d-flex flex-column justify-content-center">
        <div class="row">
            <div class="col-xl-6 mx-auto">
                <div class="card shadow">
                    <div class="card-header">
                        <h1 class="h3">Checking file permissions</h1>
                        <p class="mb-0">We scanned your server.<br>
                            If everything has green check mark, you are good to go to the next step.</p>
                    </div>

                    <div class="card-body">

                        <ul class="list-group list-group-flush">

                            <li
                                class="list-group-item text-semibold d-flex align-items-center justify-content-between py-2 px-0">
                                <span>Php version 7.4</span>

                                @php
                                    $phpVersion = number_format((float) phpversion(), 2, '.', '');
                                @endphp
                                @if ($phpVersion >= 7.4)
                                    <i class="las la-check-circle fs-4 text-primary"></i>
                                @else
                                    <i class="las la-times-circle text-danger fs-4"></i>
                                @endif
                            </li>
                            <li
                                class="list-group-item text-semibold d-flex align-items-center justify-content-between py-2 px-0">
                                <span>Curl Enabled</span>

                                @php
                                    $phpVersion = number_format((float) phpversion(), 2, '.', '');
                                @endphp
                                @if ($permission['curl_enabled'])
                                    <i class="las la-check-circle fs-4 text-primary"></i>
                                @else
                                    <i class="las la-times-circle text-danger fs-4"></i>
                                @endif
                            </li>
                            <li
                                class="list-group-item text-semibold d-flex align-items-center justify-content-between py-2 px-0">
                                <span><b>.env</b> File Permission</span>

                                @php
                                    $phpVersion = number_format((float) phpversion(), 2, '.', '');
                                @endphp
                                @if ($permission['db_file_write_perm'])
                                    <i class="las la-check-circle fs-4 text-primary"></i>
                                @else
                                    <i class="las la-times-circle text-danger fs-4"></i>
                                @endif
                            </li>

                            <li
                                class="list-group-item text-semibold d-flex align-items-center justify-content-between py-2 px-0">
                                <span> <b>RouteServiceProvider.php</b> File Permission</span>

                                @php
                                    $phpVersion = number_format((float) phpversion(), 2, '.', '');
                                @endphp
                                @if ($permission['routes_file_write_perm'])
                                    <i class="las la-check-circle fs-4 text-primary"></i>
                                @else
                                    <i class="las la-times-circle text-danger fs-4"></i>
                                @endif
                            </li>
                        </ul>

                        <p class="mt-3 d-flex">
                            <a href="{{ route('installation.init') }}" class="btn btn-secondary me-2"><i
                                    class="las la-arrow-left"></i>
                                Previous</a>
                            @if (
                                $permission['curl_enabled'] == 1 &&
                                    $permission['db_file_write_perm'] == 1 &&
                                    $permission['routes_file_write_perm'] == 1 &&
                                    $phpVersion >= 7.4)
                                <a href="{{ route('installation.dbSetup') }}" class="btn btn-primary">Next <i
                                        class="las la-arrow-right"></i></a>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
