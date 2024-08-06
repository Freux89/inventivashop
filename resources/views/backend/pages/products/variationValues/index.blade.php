@extends('backend.layouts.master')

@section('title')
    {{ localize('Variation values') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
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
                    <h2 class="h5 mb-lg-0">{{ localize('Values') }} -
                        {{ $variation->collectLocalization('name') }}</h2>
                </div>
                <div>
                    <a href="{{ route('admin.variations.index') }}" class="btn btn-link">
                        <i class="fas fa-arrow-left"></i> Torna alle varianti
                    </a>
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
                                            <th></th>
                                            <th class="all">{{ localize('Name') }}</th>
                                            @if ($variation->id == 2)
                                                <th class="all">{{ localize('Code') }}</th>
                                            @endif
                                            <th data-breakpoints="xs sm">{{ localize('Active') }}</th>
                                            <th data-breakpoints="xs sm" class="text-end">
                                                {{ localize('Action') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($variationValues as $key => $variationValue)

                                            <tr data-id="{{ $variationValue->id }}">
                                            <td class="handle"> <i class="fa-solid fa-bars"></i></td>
                                                <td>
                                                    <a class="javascript:void(0);" class="d-flex align-items-center">
                                                        <h6 class="fs-sm mb-0">
                                                            {{ $variationValue->collectLocalization('name') }}</h6>
                                                    </a>
                                                </td>

                                                @if ($variation->id == 2)
                                                    <td>
                                                        {{ $variationValue->color_code }}
                                                    </td>
                                                @endif

                                                <td>
                                                    @can('publish_variation_values')
                                                        <div class="form-check form-switch">
                                                            <input type="checkbox" class="form-check-input"
                                                                onchange="updateStatus(this)"
                                                                @if ($variationValue->is_active) checked @endif
                                                                value="{{ $variationValue->id }}">
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
                                                            @can('edit_variation_values')
                                                                <a class="dropdown-item"
                                                                    href="{{ route('admin.variationValues.edit', ['id' => $variationValue->id, 'lang_key' => env('DEFAULT_LANGUAGE')]) }}&localize">
                                                                    <i data-feather="edit-3"
                                                                        class="me-2"></i>{{ localize('Edit') }}
                                                                </a>
                                                            @endcan
                                                            <!-- Modifica questa linea con la regola di autorizzazione corretta -->
                                            
                                            <a href="#" class="dropdown-item confirm-delete"
                                                                    data-href="{{ route('admin.variationValues.delete', $variationValue->id) }}"
                                                                    title="{{ localize('Delete') }}">
                                                                    <i data-feather="trash"
                                                                        class="me-2"></i>{{ localize('Delete') }}
                                                                </a>
                                          
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                              

                            </div>
                        </div>
                    </div>

                    @can('add_variation_values')
                        <form action="{{ route('admin.variationValues.store') }}" class="pb-650" method="POST">
                            @csrf
                            <input type="hidden" name="variation_id" value="{{ $variation->id }}">
                            <!--variation value info start-->
                            <div class="card mb-4" id="section-2">
                                <div class="card-body">
                                    <h5 class="mb-4">{{ localize('Add New Variation Value') }}</h5>

                                    <div class="mb-4">
                                        <label for="name" class="form-label">{{ localize('Variation Value Name') }}</label>
                                        <input class="form-control" type="text" id="name" name="name"
                                            placeholder="{{ localize('Type variation value name') }}" required>
                                    </div>
                                    <div class="mb-4">
                <label for="default_price" class="form-label">{{ localize('Prezzo di default') }}</label>
                <input class="form-control" type="text" id="default_price" name="default_price" placeholder="10">
                <div><small class="form-text text-muted">{{ localize('Questo prezzo sarà utilizzato se non viene specificato un prezzo per il valore della variante all\'interno del prodotto.') }}</small></div>
            </div>
                                    <div class="mb-4">
                <label class="form-label">{{ localize('Image') }}</label>
                <div class="tt-image-drop rounded">
                    <span class="fw-semibold">{{ localize('Choose Image') }}</span>
                    <div class="tt-product-thumb show-selected-files mt-3">
                        <div class="avatar avatar-xl cursor-pointer choose-media"
                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
                            onclick="showMediaManager(this)" data-selection="single">
                            <input type="hidden" name="image" value="">
                            <div class="no-avatar rounded-circle">
                                <span><i data-feather="plus"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                                    @if ($variation->id == 2)
                                        <div class="mb-4">
                                            <label for="name" class="form-label">{{ localize('Color Code') }}</label>
                                            <input type="color" name="color_code" id="color_code" class="form-control">
                                        </div>
                                    @endif

                                </div>
                            </div>
                            <!-- variation info end-->

                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-4">
                                        <button class="btn btn-primary" type="submit">
                                            <i data-feather="save" class="me-1"></i> {{ localize('Save Value') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endcan
                </div>

                <!--right sidebar-->
                <div class="col-xl-3 order-1 order-md-1 order-lg-1 order-xl-2">
                    <div class="card tt-sticky-sidebar">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Variation Value Information') }}</h5>
                            <div class="tt-vertical-step">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="#section-1" class="active">{{ localize('All Variation Values') }}</a>
                                    </li>

                                    @can('add_variation_values')
                                        <li>
                                            <a href="#section-2">{{ localize('Add New Variation Value') }}</a>
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
        "use strict";

        function updateStatus(el) {
            if (el.checked) {
                var is_active = 1;
            } else {
                var is_active = 0;
            }
            $.post('{{ route('admin.variationValues.updateStatus') }}', {
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
        handle: '.handle',  // Class name of the handle
        animation: 150,  // Animation speed when sorting
        onUpdate() {
            const order = this.toArray();
            // Send the new order to the server
            fetch('{{ route("admin.variationValues.positions") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    // Add your Laravel CSRF token here
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ positions: order })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    console.log('Positions updated successfully');
                } else {
                    console.error('Failed to update positions');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });
});

</script>
@endsection
