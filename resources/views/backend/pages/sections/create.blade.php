@extends('backend.layouts.master')

@section('title')
{{ localize('Crea Sezione') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">{{ localize('Crea nuova Sezione') }}</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
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
        </div>
    </div>
</div>
@endsection