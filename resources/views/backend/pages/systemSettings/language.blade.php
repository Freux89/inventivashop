@extends('backend.layouts.master')


@section('title')
    {{ localize('Languages') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection


@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-lg-0">{{ localize('Languages') }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4 g-4">
                <!--left sidebar-->
                <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-4" id="section-1">
                                <form class="app-search" action="{{ Request::fullUrl() }}" method="GET">
                                    <div class="card-header border-bottom-0">
                                        <div class="row justify-content-between g-3">
                                            <div class="col-auto flex-grow-1">
                                                <div class="tt-search-box">
                                                    <div class="input-group">
                                                        <span
                                                            class="position-absolute top-50 start-0 translate-middle-y ms-2">
                                                            <i data-feather="search"></i></span>
                                                        <input class="form-control rounded-start w-100" type="text"
                                                            id="search" name="search"
                                                            placeholder="{{ localize('Search') }}"
                                                            @isset($searchKey)
                                        value="{{ $searchKey }}"
                                    @endisset>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <button type="submit" class="btn btn-primary">
                                                    <i data-feather="search" width="18"></i>
                                                    {{ localize('Search') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <table class="table tt-footable border-top" data-use-parent-width="true">
                                    <thead>
                                        <tr>
                                            <th class="text-center">{{ localize('S/L') }}</th>
                                            <th>{{ localize('Name') }}</th>
                                            <th data-breakpoints="xs sm">{{ localize('ISO 639-1 Code') }}</th>
                                            <th data-breakpoints="xs sm">{{ localize('Active') }}</th>
                                            <th data-breakpoints="xs sm" class="text-end">{{ localize('Action') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($languages as $key => $language)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $loop->index + 1 }}
                                                </td>

                                                <td>
                                                    <a class="d-flex align-items-center">
                                                        <div class="avatar avatar-sm">
                                                            <img class="rounded-circle"
                                                                src="{{ staticAsset('backend/assets/img/flags/' . $language->flag . '.png') }}"
                                                                alt="{{ $language->flag }}" />
                                                        </div>
                                                        <h6 class="fs-sm mb-0 ms-2">{{ $language->name }}
                                                        </h6>
                                                    </a>
                                                </td>


                                                <td class="fw-semibold">
                                                    {{ $language->code }}
                                                </td>

                                                <td>
                                                    @can('publish_languages')
                                                        <div class="form-check form-switch">
                                                            <input type="checkbox" class="form-check-input"
                                                                onchange="updateStatus(this)"
                                                                @if ($language->is_active) checked @endif
                                                                value="{{ $language->id }}">
                                                        </div>
                                                    @endcan
                                                </td>

                                                <td class="text-end">
                                                    <div class="dropdown tt-tb-dropdown">
                                                        <button type="button" class="btn p-0" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            <i data-feather="more-vertical"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end shadow">

                                                            @can('edit_languages')
                                                                <a class="dropdown-item"
                                                                    href="{{ route('admin.languages.edit', $language->id) }}">
                                                                    <i data-feather="edit-3"
                                                                        class="me-2"></i>{{ localize('Edit') }}
                                                                </a>
                                                            @endcan

                                                            @can('translate_languages')
                                                                <a class="dropdown-item"
                                                                    href="{{ route('admin.languages.localizations', $language->id) }}">
                                                                    <i data-feather="globe"
                                                                        class="me-2"></i>{{ localize('Localizations') }}
                                                                </a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @can('add_languages')
                            <form action="{{ route('admin.languages.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!--language info start-->
                                <div class="card mb-4" id="section-2">
                                    <div class="card-body">
                                        <h5 class="mb-4">{{ localize('Add New Language') }}</h5>

                                        <div class="mb-4">
                                            <label for="name" class="form-label">{{ localize('Language Name') }}</label>
                                            <input type="text" name="name" id="name"
                                                placeholder="{{ localize('Type language name') }}" class="form-control"
                                                required>
                                        </div>

                                        <div class="mb-4">
                                            <label for="code" class="form-label">{{ localize('ISO 639-1 Code') }}</label>
                                            <input type="text" name="code" id="code"
                                                placeholder="{{ localize('en/bn') }}" class="form-control" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="symbol" class="form-label">{{ localize('Flag') }}</label>
                                            <select id="flag" class="form-control country-flag-select" name="flag"
                                                data-toggle="select2">
                                                @foreach (\File::files(base_path('public/backend/assets/img/flags')) as $path)
                                                    <option value="{{ pathinfo($path)['filename'] }}"
                                                        data-flag="{{ staticAsset('backend/assets/img/flags/' . pathinfo($path)['filename'] . '.png') }}">
                                                        {{ strtoupper(pathinfo($path)['filename']) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label for="symbol" class="form-label">{{ localize('RTL') }}</label>
                                            <select id="is_rtl" class="form-control select2" name="is_rtl"
                                                data-toggle="select2">
                                                <option value="0">
                                                    {{ localize('Disable') }}
                                                </option>
                                                <option value="1">
                                                    {{ localize('Active') }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!--language info end-->

                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-4">
                                            <button class="btn btn-primary" type="submit">
                                                <i data-feather="save" class="me-1"></i> {{ localize('Save Language') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endcan

                        @can('default_language')
                            <!--default lang info start-->
                            <div class="pb-650 mt-3">
                                <div class="card mb-4" id="section-3">
                                    <div class="card-body">
                                        <h5 class="mb-4">{{ localize('Set Default Language') }}</h5>
                                        <div class="mb-4">
                                            <label for="symbol"
                                                class="form-label">{{ localize('Default Language') }}</label>
                                            <select id="DEFAULT_LANGUAGE" class="form-control country-flag-select"
                                                name="DEFAULT_LANGUAGE" data-toggle="select2"
                                                onchange="handleDefaultLangSubmit(this)">
                                                @foreach ($languages as $key => $language)
                                                    <option value="{{ $language->code }}"
                                                        {{ env('DEFAULT_LANGUAGE') == $language->code ? 'selected' : '' }}
                                                        data-flag="{{ staticAsset('backend/assets/img/flags/' . $language->flag . '.png') }}">
                                                        {{ $language->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--default lang info end-->
                        @endcan
                    </div>
                </div>

                <!--right sidebar-->
                <div class="col-xl-3 order-1 order-md-1 order-lg-1 order-xl-2">
                    <div class="card tt-sticky-sidebar">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Language Information') }}</h5>
                            <div class="tt-vertical-step">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="#section-1" class="active">{{ localize('All Languages') }}</a>
                                    </li>
                                    <li>
                                        <a href="#section-2">{{ localize('Add New Language') }}</a>
                                    </li>

                                    @can('default_language')
                                        <li>
                                            <a href="#section-3">{{ localize('Set Default Language') }}</a>
                                        </li>
                                    @endcan
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
    <script>
        "use strict"

        function updateStatus(el) {
            if (el.checked) {
                var is_active = 1;
            } else {
                var is_active = 0;
            }
            $.post('{{ route('admin.languages.updateStatus') }}', {
                    _token: '{{ csrf_token() }}',
                    id: el.value,
                    is_active: is_active
                },
                function(data) {
                    if (data.status == true) {
                        notifyMe('success', data.message);
                    } else {
                        notifyMe('danger', data.message);
                    }
                });
        }

        function handleDefaultLangSubmit(el) {
            $.post('{{ route('admin.languages.defaultLanguage') }}', {
                    _token: '{{ csrf_token() }}',
                    DEFAULT_LANGUAGE: el.value
                },
                function(data) {
                    notifyMe('success', data.message);
                });
        }
    </script>
@endsection
