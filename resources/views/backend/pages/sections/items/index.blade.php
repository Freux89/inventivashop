@php
   
    $columnLayout = isset($section->settings['columnLayout']) && !empty($section->settings['columnLayout']) ? $section->settings['columnLayout'] : '0';
    $maxColumns = ($columnLayout === '0' || empty($columnLayout)) ? [] : explode('-', $columnLayout);

    $maxColumnsCount = count($maxColumns); // Numero massimo di colonne permesso
   
@endphp
@section('extra-head')
<script src="{{ staticAsset('backend/assets/js/vendors/Sortable.min.js') }}"></script>
@endsection
<div class="row mt-6">
    <div class="card tt-page-header mb-4">
        <div class="card-body d-lg-flex align-items-center justify-content-lg-between ">
            <div class="tt-page-title">
                <h5 class="mb-lg-0">
                    @if($section->type == 'columns')
                    {{ localize('Colonne') }} -  {{$currentItemsCount}}/{{$maxColumnsCount}}
                    @else
                    {{ localize('Elementi') }} 
                    @endif
                </h5>
            </div>
            <div class="tt-action">

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" onclick="showColumnModal()">
                    <i data-feather="plus"></i> 
                    @if($section->type == 'columns')
                    {{ localize('Aggiungi colonna') }}
                    @else
                    {{ localize('Aggiungi elemento') }}
                    @endif
                </button>

            </div>

        </div>
    </div>
  
    <div class="card mb-4 mt-">
    <div class="card-body">
        <table class="table tt-footable border-top" data-use-parent-width="true">
            <thead>
                <tr>
                    <th></th>
                    <th>{{ localize('ID') }}</th>
                    <th>{{ localize('Titolo') }}</th>
                    <th>{{ localize('Tipo') }}</th>
                    <th>{{ localize('Stato') }}</th>
                    <!-- <th data-breakpoints="xs sm">{{ localize('Active') }}</th> -->
                    <th data-breakpoints="xs sm" class="text-end">
                        {{ localize('Action') }}
                    </th>
                </tr>
            </thead>
            <tbody>

                @foreach ($section->items as $key => $item)
                <tr data-id="{{ $item->id }}">
                    <td class="handle"> <i class="fa-solid fa-bars"></i></td>
                    <td>{{$item->id}}</td>
                   
                        <td class="text-start">
                        <a href="{{ route('admin.items.edit', ['sectionId' => $section->id, 'id' => $item->id, 'lang_key' => env('DEFAULT_LANGUAGE')]) }}" class="d-inline-block">

                            <h6 class="fs-sm mb-0">
                            {{ $item->settings['title'] ?? 'Titolo non presente' }}
                            </h6>
                        </td>
                        </a>
               
                    <td class="text-start fs-sm">
                                {{localize($item->type)}}
                         
                    </td>
                    <td>
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" onchange="updateStatus(this)" @if ($item->is_active) checked @endif
                        value="{{ $item->id }}">
                    </div>
                    </td>
                    <td class="text-end">
                        <div class="dropdown tt-tb-dropdown">
                            <button type="button" class="btn p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                <i data-feather="more-vertical"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end shadow">

                                <a class="dropdown-item" href="{{ route('admin.items.edit', ['id' => $item->id, 'lang_key' => env('DEFAULT_LANGUAGE')]) }}&localize">
                                    <i data-feather="edit-3" class="me-2"></i>{{ localize('Edit') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('admin.items.duplicate', $item->id) }}">
                                    <i data-feather="copy" class="me-2"></i>{{ localize('Duplica') }}
                                </a>
                                <a href="#" class="dropdown-item confirm-delete" data-href="{{ route('admin.items.delete', $item->id) }}" title="{{ localize('Delete') }}">
                                    <i data-feather="trash" class="me-2"></i>{{ localize('Delete') }}
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
@if($section->type == 'columns')
@include('backend.pages.sections.items.partials.modals.columns')
@elseif($section->type == 'carousel')
@include('backend.pages.sections.items.partials.modals.carousel')
@elseif($section->type == 'filtergrid')
@include('backend.pages.sections.items.partials.modals.filtergrid')
@endif
    
<script>

function updateStatus(el) {
        if (el.checked) {
            var is_active = 1;
        } else {
            var is_active = 0;
        }
        $.post('{{ route("admin.items.updateStatus") }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                is_active: is_active
            },
            function(data) {
                if (data == 1) {
                    notifyMe('success', '{{ localize("Status updated successfully") }}');
                } else {
                    notifyMe('danger', '{{ localize("Something went wrong") }}');
                }
            });
    }

 


        function redirectToCreateItem() {
            var type = $('#TypeSelect').val();
            if (type) {
                var url = "{{ route('admin.items.create', ['sectionId' => $section->id, 'type' => '_type_']) }}";
                window.location.href = url.replace('_type_', type);
            } else {
                alert('{{ localize('  Seleziona un tipo prima di procedere.') }}');
            }
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
            fetch('{{ route("admin.items.positions") }}', {
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

