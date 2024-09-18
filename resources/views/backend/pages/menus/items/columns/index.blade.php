<div class="card mb-4">
    <div class="card-body">
        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
            <div class="tt-page-title">
                <h5 class="mb-3">{{ localize('Colonne del Menu Item') }}</h5>
            </div>
            <div class="tt-action">
                <a href="{{ route('admin.menu-columns.create', ['menu_item_id' => $menuItem->id]) }}" class="btn btn-primary">
                    <i data-feather="plus"></i> {{ localize('Aggiungi Colonna') }}
                </a>
            </div>
        </div>
        <table class="table tt-footable border-top" data-use-parent-width="true">
            <thead>
                <tr>
                    <th class="handle text-start"></th>
                    <th class="text-start">{{ localize('Titolo Colonna') }}</th>
                    <th class="text-start">{{ localize('Contenuto') }}</th>
                    <th class="text-start">{{ localize('Grandezza Colonna') }}</th>
                    <th data-breakpoints="xs sm" class="text-end">{{ localize('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($menuColumns as $column)
                <tr data-id="{{ $column->id }}">
                    <td class="handle"><i class="fa-solid fa-bars"></i></td>
                    <td class="text-start">{{ $column->title }}</td>
                    <td class="text-start">
                        @if($column->content)
                        {{ $column->content }}
                        @else
                        {{ localize('Nessun Contenuto') }}
                        @endif
                    </td>
                    <td class="text-start">col-{{ $column->column_width }}</td>
                    <td class="text-end">
                    <div class="dropdown tt-tb-dropdown">
    <button type="button" class="btn p-0" data-bs-toggle="dropdown" aria-expanded="false">
        <i data-feather="more-vertical"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-end shadow">
        <a class="dropdown-item" href="{{ route('admin.menu-columns.edit', $column->id) }}">
            <i data-feather="edit-3" class="me-2"></i>{{ localize('Edit') }}
        </a>
        <!-- Aggiungi il bottone per la duplicazione -->
        <a class="dropdown-item" href="{{ route('admin.menu-columns.duplicate', $column->id) }}">
            <i data-feather="copy" class="me-2"></i>{{ localize('Duplica') }}
        </a>
        <a href="#" class="dropdown-item confirm-delete" data-href="{{ route('admin.menu-columns.delete', $column->id) }}" title="{{ localize('Delete') }}">
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
