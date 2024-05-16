@extends('backend.layouts.master')

@section('title')
{{ localize('Crea Sezione') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
<section class="tt-section pt-4">
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">{{ localize('Crea Sezione') }}</h2>
                        </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
            <div class="card mb-4" id="section-1">
                        <div class="card-body">
            <form method="POST" action="{{ route('admin.sections.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">{{ localize('Nome') }}</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label">{{ localize('Tipo di Sezione') }}</label>
                    <select class="form-control" id="type" name="type">
                        <option value="columns">{{ localize('Colonne') }}</option>
                        <option value="carousel">{{ localize('Carosello') }}</option>
                        <option value="filtergrid">{{ localize('Filtro griglia') }}</option>
                    </select>
                </div>
               
                <button type="submit" class="btn btn-primary">{{ localize('Salva') }}</button>
            </form>
</div></div>
</div>
</div>
        </div>
    </div>
</div>
</section>
@endsection