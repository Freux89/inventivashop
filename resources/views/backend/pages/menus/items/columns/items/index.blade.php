<div class="card mb-4">
    <div class="card-body">
        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
            <div class="tt-page-title">
                <h5 class="mb-3">{{ localize('Elementi della Colonna') }}</h5>
            </div>
            <div class="tt-action">
                <a href="{{ route('admin.menu-column-items.create', ['menu_column_id' => $menuColumn->id]) }}" class="btn btn-primary">
                    <i data-feather="plus"></i> {{ localize('Aggiungi Elemento') }}
                </a>
            </div>
        </div>
        <table class="table tt-footable border-top" data-use-parent-width="true">
            <thead>
                <tr>
                    <th class="handle text-start"></th>
                    <th class="text-start">{{ localize('Titolo') }}</th>
                    <th class="text-start">{{ localize('Tipo di Collegamento') }}</th>
                    <th class="text-start">{{ localize('Dettaglio Collegamento') }}</th>
                    <th data-breakpoints="xs sm" class="text-end">{{ localize('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($menuColumnItems as $item)
                <tr data-id="{{ $item->id }}">
                    <td class="handle"><i class="fa-solid fa-bars"></i></td>
                    <td class="text-start">{{ $item->title }}</td>
                    <td class="text-start">
                        @if($item->url)
                        {{ localize('URL Personalizzato') }}
                        @elseif($item->product_id)
                        {{ localize('Prodotto') }}
                        @elseif($item->category_id)
                        {{ localize('Categoria') }}
                        @else
                        {{ localize('Nessun Collegamento') }}
                        @endif
                    </td>
                    <td class="text-start">
                        @if($item->url)
                        {{ $item->url }}
                        @elseif($item->product_id)
                        {{ $item->product->name ?? localize('Prodotto Non Trovato') }}
                        @elseif($item->category_id)
                        {{ $item->category->name ?? localize('Categoria Non Trovata') }}
                        @else
                        {{ localize('N/A') }}
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="dropdown tt-tb-dropdown">
                            <button type="button" class="btn p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                <i data-feather="more-vertical"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end shadow">
                                <a class="dropdown-item" href="{{ route('admin.menu-column-items.edit', $item->id) }}">
                                    <i data-feather="edit-3" class="me-2"></i>{{ localize('Edit') }}
                                </a>
                                <a href="#" class="dropdown-item confirm-delete" data-href="{{ route('admin.menu-column-items.delete', $item->id) }}" title="{{ localize('Delete') }}">
                                    <i data-feather="trash" class="me-2"></i>{{ localize('Delete') }}
                                </a>
                                <!-- Aggiungi il bottone per la duplicazione -->
                                <a class="dropdown-item" href="{{ route('admin.menu-column-items.duplicate', $item->id) }}">
                                    <i data-feather="copy" class="me-2"></i>{{ localize('Duplica') }}
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