@extends('layouts.setup')
@section('contents')
    <div class="container h-100 d-flex flex-column justify-content-center">
        <div class="row">
            <div class="col-xl-6 mx-auto">
                <div class="card shadow">
                    <div class="card-body p-5 text-center">
                        <div class="mb-4"><i class="las la-check-circle text-primary fs-1"></i></div>
                        <div class="mb-4">
                            <h1 class="h3">Congratulations!!!</h1>
                            <p>You have successfully completed the installation process.</p>
                        </div>
                        <a href="{{ env('APP_URL') }}" class="btn btn-secondary me-2">Browse Website</a>
                        <a href="{{ env('APP_URL') }}/admin" class="btn btn-primary">Browse Admin panel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
