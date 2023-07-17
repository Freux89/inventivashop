@extends('backend.layouts.master')

@section('title')
    {{ localize('Employee Staffs') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-lg-0">{{ localize('Employee Staffs') }}</h2>
                            </div>
                            <div class="tt-action">
                                @can('add_staffs')
                                    <a href="{{ route('admin.staffs.create') }}" class="btn btn-primary"><i
                                            data-feather="plus"></i> {{ localize('Add Employee') }}</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12">
                    <div class="card mb-4" id="section-1">
                        <form class="app-search" action="{{ Request::fullUrl() }}" method="GET">
                            <div class="card-header border-bottom-0">
                                <div class="row justify-content-between g-3">
                                    <div class="col-auto flex-grow-1">
                                        <div class="tt-search-box">
                                            <div class="input-group">
                                                <span class="position-absolute top-50 start-0 translate-middle-y ms-2"> <i
                                                        data-feather="search"></i></span>
                                                <input class="form-control rounded-start w-100" type="text"
                                                    id="search" name="search" placeholder="{{ localize('Search') }}"
                                                    @isset($searchKey)
                                                        value="{{ $searchKey }}"
                                                    @endisset>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-secondary">
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
                                    <th data-breakpoints="xs sm">{{ localize('Role') }}</th>
                                    <th data-breakpoints="xs sm">{{ localize('Email') }}</th>
                                    <th data-breakpoints="xs sm">{{ localize('Phone') }}</th>
                                    <th data-breakpoints="xs sm" class="text-end">{{ localize('Action') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($staffs as $key => $staff)
                                    <tr>
                                        <td class="text-center">
                                            {{ $key + 1 + ($staffs->currentPage() - 1) * $staffs->perPage() }}</td>
                                        <td>
                                            <span class="fw-semibold">
                                                {{ $staff->name }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($staff->role != null)
                                                <span class="badge rounded-pill bg-secondary">
                                                    {{ $staff->role->name }}
                                                </span>
                                            @else
                                                <span class="badge rounded-pill bg-secondary">
                                                    {{ localize('N/A') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $staff->email }}
                                        </td>
                                        <td>
                                            @if ($staff->phone != null)
                                                {{ $staff->phone }}
                                            @else
                                                <span class="badge rounded-pill bg-secondary">
                                                    {{ localize('N/A') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown tt-tb-dropdown">
                                                <button type="button" class="btn p-0" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i data-feather="more-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end shadow">

                                                    @can('edit_staffs')
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.staffs.edit', ['id' => $staff->id, 'lang_key' => env('DEFAULT_LANGUAGE')]) }}&localize">
                                                            <i data-feather="edit-3" class="me-2"></i>{{ localize('Edit') }}
                                                        </a>
                                                    @endcan
                                                    @can('delete_staffs')
                                                        <a href="#" class="dropdown-item confirm-delete"
                                                            data-href="{{ route('admin.staffs.delete', $staff->id) }}"
                                                            title="{{ localize('Delete') }}">
                                                            <i data-feather="trash-2" class="me-2"></i>
                                                            {{ localize('Delete') }}
                                                        </a>
                                                    @endcan
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!--pagination start-->
                        <div class="d-flex align-items-center justify-content-between px-4 pb-4">
                            <span>{{ localize('Showing') }}
                                {{ $staffs->firstItem() }}-{{ $staffs->lastItem() }} {{ localize('of') }}
                                {{ $staffs->total() }} {{ localize('results') }}</span>
                            <nav>
                                {{ $staffs->appends(request()->input())->links() }}
                            </nav>
                        </div>
                        <!--pagination end-->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('scripts')
    <script>
        "use strict";

        function updateBanStatus(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('admin.customers.updateBanStatus') }}', {
                    _token: '{{ csrf_token() }}',
                    id: el.value,
                    status: status
                },
                function(data) {
                    if (data == 1) {
                        location.reload();
                    } else {
                        notifyMe('danger', '{{ localize('Something went wrong') }}');
                    }
                });
        }
    </script>
@endsection
