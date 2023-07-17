@extends('layouts.setup')
@section('contents')
    <div class="container h-100 d-flex flex-column justify-content-center">
        <div class="row">
            <div class="col-xl-6 mx-auto">
                <div class="card shadow">

                    <div class="card-header">
                        <h1 class="h3">Admin Configuration</h1>
                        <p class="mb-0">Fill this form with basic information & admin login credentials</p>
                    </div>

                    <div class="card-body">
                        <p class="text-muted font-13">
                        <form method="POST" action="{{ route('installation.storeAdmin') }}">
                            @csrf
                            <div class="form-group mb-2">
                                <label class="fw-semibold mb-1" for="admin_name">Admin Name</label>
                                <input type="text" class="form-control" id="admin_name" name="admin_name" required>
                            </div>

                            <div class="form-group mb-2">
                                <label class="fw-semibold mb-1" for="admin_email">Admin Email</label>
                                <input type="email" class="form-control" id="admin_email" name="admin_email" required>
                            </div>

                            <div class="form-group mb-4">
                                <label class="fw-semibold mb-1" for="admin_password">Admin Password (At least 6
                                    characters)</label>
                                <input type="password" class="form-control" id="admin_password" name="admin_password"
                                    required>
                            </div>

                            <div class="d-flex align-items-center mt-4">
                                <a href="{{ route('installation.migration') }}" class="btn btn-secondary me-2"><i
                                        class="las la-arrow-left"></i>
                                    Previous</a>
                                <button type="submit" class="btn btn-primary">Continue <i
                                        class="las la-arrow-right"></i></button>
                            </div>
                        </form>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
