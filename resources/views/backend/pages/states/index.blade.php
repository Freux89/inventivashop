@extends('backend.layouts.master')

@section('extra-head')
<script src="{{ staticAsset('backend/assets/js/vendors/Sortable.min.js') }}"></script>
@endsection

@section('title')
{{ localize('Stati ordine') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
<section class="tt-section pt-4">
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">{{ localize('Stati ordine') }}</h2>
                        </div>
                        <div class="tt-action">
                           
                            <a href="{{ route('admin.orderStates.create') }}" class="btn btn-primary"><i data-feather="plus"></i> {{ localize('Aggiungi stato') }}</a>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12">
                <div class="card mb-4" id="section-1">
                    

                    <table class="table tt-footable border-top" data-use-parent-width="true">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>{{ localize('Nome') }}</th>
                                <th data-breakpoints="xs sm">{{ localize('Tipo') }}</th>
                                <th data-breakpoints="xs sm">{{ localize('Email') }}</th>
                                <th data-breakpoints="xs sm md">{{ localize('Attivo') }}</th>
                                <th data-breakpoints="xs sm md" class="text-end">{{ localize('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($states as $key => $state)
                            <tr data-id="{{ $state->id }}">
                                            <td class="handle"> <i class="fa-solid fa-bars"></i></td>
                                <td>
                                    <a href="{{ route('admin.orderStates.edit', ['id' => $state->id, 'lang_key' => env('DEFAULT_LANGUAGE')]) }}" class="d-flex align-items-center">
                                        
                                    <h6 class="fs-sm mb-0 ms-2" style="background-color: {{ $state->color }}; border-radius: 10px; padding: 5px; color: {{ $state->color && isLight($state->color) ? '#000000' : '#FFFFFF' }};">
                                    {{ $state->name }}
                                        </h6>
                                    </a>
                                </td>
                                <td>
                                   {{$state->type}}
                                </td>
                                <td>
                                       @if ($state->send_email)
                                            <span class="badge bg-success">{{ localize('Si') }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ localize('No') }}</span>
                                        @endif
                                </td>
                                <td>
                                 
                                    <div class="form-check form-switch">
                                        <input type="checkbox" onchange="updatePublishedStatus(this)" class="form-check-input" @if ($state->status) checked @endif
                                        value="{{ $state->id }}">
                                    </div>
                                  

                                </td>
                                <td class="text-end">
                                    <div class="dropdown tt-tb-dropdown">
                                        <button type="button" class="btn p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i data-feather="more-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end shadow">
                                            
                                            <a class="dropdown-item" href="{{ route('admin.orderStates.edit', ['id' => $state->id, 'lang_key' => env('DEFAULT_LANGUAGE')]) }}&localize">
                                                <i data-feather="edit-3" class="me-2"></i>{{ localize('Edit') }}
                                            </a>
                                            

                                            
                                            <a href="#" class="dropdown-item confirm-delete"
                                                                    data-href="{{ route('admin.orderStates.delete', $state->id) }}"
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
                    <!--pagination start-->
                    <div class="d-flex align-items-center justify-content-between px-4 pb-4">
                        <span>{{ localize('Showing') }}
                            {{ $states->firstItem() }}-{{ $states->lastItem() }} {{ localize('of') }}
                            {{ $states->total() }} {{ localize('results') }}</span>
                        <nav>
                            {{ $states->appends(request()->input())->links() }}
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
     document.addEventListener('DOMContentLoaded', (event) => {
    const tableBody = document.querySelector('.table tbody');
    const sortable = new Sortable(tableBody, {
        handle: '.handle',  // Class name of the handle
        animation: 150,  // Animation speed when sorting
        onUpdate() {
            const order = this.toArray();
            // Send the new order to the server
            fetch('{{ route("admin.orderStates.positions") }}', {
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

    // update publish status 
    function updatePublishedStatus(el) {
        if (el.checked) {
            var status = 1;
        } else {
            var status = 0;
        }
        $.post("{{ route('admin.orderStates.updatePublishedStatus') }}", {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            },
            function(data) {
                if (data == 1) {
                    notifyMe('success', "{{ localize('Status updated successfully') }}");
                } else {
                    notifyMe('danger', "{{ localize('Something went wrong') }}");
                }
            });
    }
</script>
@endsection