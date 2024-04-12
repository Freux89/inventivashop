@extends('backend.layouts.master')

@section('title')
{{ localize('Crea Menu') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">{{ localize('Crea nuovo Menu') }}</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('admin.menus.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">{{ localize('Nome') }}</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3 form-check">
                <input type="hidden" name="is_primary" value="0">  <!-- Hidden field to send false if checkbox is not checked -->
                    <input type="checkbox" class="form-check-input" id="is_primary" name="is_primary" value="1">
                    <label class="form-check-label" for="is_primary">{{ localize('Imposta come Menu primario') }}</label>
                </div>
                <button type="submit" class="btn btn-primary">{{ localize('Salva') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection