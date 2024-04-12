@extends('backend.layouts.master')

@section('title')
{{ localize('Menu') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="mb-4">{{ localize('Gestione Menu') }}</h1>
                <a href="{{ route('admin.menus.create') }}" class="btn btn-primary">{{ localize('Crea nuovo menu') }}</a>
            </div>
            @if($menus->isEmpty())
                <div class="alert alert-warning" role="alert">
                    {{ localize('Nessun menu trovato. Crea il tuo primo menù.') }}
                </div>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{ localize('Name') }}</th>
                            <th>{{ localize('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($menus as $menu)
                            <tr>
                                <td>{{ $menu->name }}</td>
                                <td>
                                    <a href="{{ route('admin.menus.edit', $menu->id) }}" class="btn btn-sm btn-info">{{ localize('Edit') }}</a>
                                    <a href="{{ route('admin.menus.delete', $menu->id) }}" class="btn btn-sm btn-danger"
                                       onclick="return confirm('{{ localize('Are you sure?') }}')">{{ localize('Delete') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

@endsection