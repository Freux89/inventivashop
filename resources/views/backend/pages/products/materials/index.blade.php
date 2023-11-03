@extends('backend.layouts.master')

@section('title')
    {{ localize('Materials') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection
@section('extra-head')
<script src="{{ staticAsset('backend/assets/js/vendors/Sortable.min.js') }}"></script>
@endsection
@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-lg-0">{{ localize('Materiali') }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4 g-4">
                <!--left sidebar-->
                <div class="col-xl-12 order-2 order-md-2 order-lg-2 order-xl-1">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-4" id="section-1">
                                <form class="app-search" action="{{ Request::fullUrl() }}" method="GET">
                                    <!-- ... (Rest of the form remains unchanged) ... -->

                                </form>
                                <table class="table tt-footable border-top" data-use-parent-width="true">
                                <thead>
                                        <tr>
                                            <th class="text-center" width="5%"></th>
                                            <th>{{ localize('Name') }}</th>
                                            <th data-breakpoints="xs sm">{{ localize('Active') }}</th>
                                            <th data-breakpoints="xs sm" class="text-end">
                                                {{ localize('Action') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($materials as $key => $material)
                                            <tr data-id="{{ $material->id }}">
                                            <td class="handle"> <i class="fa-solid fa-bars"></i></td>
                                                <td>
                                                    <a class="javascript:void(0);" class="d-flex align-items-center">
                                                        <h6 class="fs-sm mb-0">
                                                            {{ $material->collectLocalization('name') }}</h6>
                                                    </a>
                                                </td>
                                                <td>
                                                <div class="form-check form-switch">
                                                            <input type="checkbox" class="form-check-input"
                                                                onchange="updateStatus(this)"
                                                                @if ($material->is_active) checked @endif
                                                                value="{{ $material->id }}">
                                                        </div>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                

                            </div>
                        </div>
                    </div>

                    @can('add_materials')
                        <form action="{{ route('admin.materials.store') }}" class="pb-650" method="POST">
                            <!-- ... (Rest of the form remains unchanged, just replace "variation" with "material") ... -->
                        </form>
                    @endcan
                </div>

            </div>

        </div>
    </section>
@endsection

@section('scripts')
    <script>
        'use strict';

        function updateStatus(el) {
            if (el.checked) {
                var is_active = 1;
            } else {
                var is_active = 0;
            }
            $.post('{{ route("admin.materials.updateStatus") }}', {
                    _token: '{{ csrf_token() }}',
                    id: el.value,
                    is_active: is_active
                },
                function(data) {
                    if (data == 1) {
                        notifyMe('success', '{{ localize('Status updated successfully') }}');
                    } else {
                        notifyMe('danger', '{{ localize('Something went wrong') }}');
                    }
                });
        }
    </script>

    <script>
        // table-sort.js
        document.addEventListener('DOMContentLoaded', (event) => {
            const tableBody = document.querySelector('.table tbody');
            const sortable = new Sortable(tableBody, {
                // ... (Rest of the script remains unchanged, just replace "variation" with "material") ...
            });
        });

    </script>
@endsection
