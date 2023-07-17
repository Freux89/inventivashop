@extends('layouts.setup')
@section('contents')
    <div class="container h-100 d-flex flex-column justify-content-center">
        <div class="row">
            <div class="col-xl-6 mx-auto">
                <div class="card shadow">
                    <div class="card-body p-5 text-center">
                        <div class="mar-ver pad-btm">
                            <h2 class="h3">Run Database Migration</h2>
                        </div>
                        <p>
                            Your database is successfully connected. Please run migration to configure the
                            database.
                        </p>

                        <div class="d-flex align-items-center justify-content-center mt-4">
                            <a href="{{ route('installation.dbSetup') }}" class="btn btn-secondary me-2"><i
                                    class="las la-arrow-left"></i>
                                Previous</a>

                            <a href="{{ route('installation.runMigration') }}" class="btn btn-primary"
                                onclick="showLoder()">Run Migration <i class="las la-arrow-right"></i></a>

                            {{-- <a href="{{ route('installation.runMigration', true) }}" class="btn btn-warning ms-2 d-none"
                                onclick="showLoder()">Run Demo Migration <i class="las la-arrow-right"></i></a> --}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
