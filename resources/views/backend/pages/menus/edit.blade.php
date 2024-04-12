@extends('backend.layouts.master')

@section('title')
{{ localize('Modifica Menu') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">{{ localize('Modifica Menu') }}</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('admin.menus.update', $menu->id) }}">
            @csrf
            @method('PUT')   <!-- This should be changed to @method('PUT') for RESTful consistency -->
                <div class="mb-3">
                    <label for="name" class="form-label">{{ localize('Nome Menu') }}</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $menu->name) }}" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="hidden" name="is_primary" value="0">  <!-- Hidden field to send false if checkbox is not checked -->
                    <input type="checkbox" class="form-check-input" id="is_primary" name="is_primary" value="1" {{ $menu->is_primary ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_primary">{{ localize('Imposta come Menu primario') }}</label>
                </div>
                <button type="submit" class="btn btn-primary">{{ localize('Aggiorna') }}</button>
            </form>
        </div>
    </div>
</div>

@endsection
