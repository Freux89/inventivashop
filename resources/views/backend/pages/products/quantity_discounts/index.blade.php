@extends('backend.layouts.master')

@section('title')
{{ localize('Sconti per Quantità') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
<section class="tt-section pt-4">
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">{{ localize('Sconti per Quantità') }}</h2>
                        </div>
                        <div class="tt-action">
                            <a href="{{ route('quantity_discounts.create') }}" class="btn btn-primary">
                                <i data-feather="plus"></i> {{ localize('Aggiungi Sconto per Quantità') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-4">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4" id="section-1">
                            <form class="app-search" action="{{ Request::fullUrl() }}" method="GET">
                                <div class="card-header border-bottom-0">
                                    <div class="row justify-content-between g-3">
                                        <div class="col-auto flex-grow-1">
                                            <div class="tt-search-box">
                                                <div class="input-group">
                                                    <span class="position-absolute top-50 start-0 translate-middle-y ms-2">
                                                        <i data-feather="search"></i>
                                                    </span>
                                                    <input class="form-control rounded-start w-100" type="text" id="search" name="search" placeholder="{{ localize('Cerca per nome dello sconto') }}" @isset($searchKey) value="{{ $searchKey }}" @endisset>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-secondary">
                                                <i data-feather="search" width="18"></i>
                                                {{ localize('Cerca') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <table class="table tt-footable border-top" data-use-parent-width="true">
                                <thead>
                                    <tr>
                                        <th class="text-start">{{ localize('Nome') }}</th>
                                        <th>{{ localize('Stato') }}</th>
                                        <th>{{ localize('Prodotti Associati') }}</th>
                                        <th>{{ localize('Creato il') }}</th>
                                        <th>{{ localize('Modificato il') }}</th>
                                        <th data-breakpoints="xs sm" class="text-end">
                                            {{ localize('Azione') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($quantityDiscounts as $quantityDiscount)
                                    <tr data-id="{{ $quantityDiscount->id }}">
                                        <td class="text-start">
                                            <a href="{{ route('quantity_discounts.edit', $quantityDiscount->id) }}" class="d-inline-block">
                                                <h6 class="fs-sm mb-0">
                                                    {{ $quantityDiscount->name }}
                                                </h6>
                                            </a>
                                        </td>
                                        <td>
                                            @if ($quantityDiscount->status)
                                                {{ localize('Attivo') }}
                                            @else
                                                {{ localize('Disattivato') }}
                                            @endif
                                        </td>
                                        <td>
                                            <span style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-html="true" title="
@if($quantityDiscount->products->isNotEmpty())
    Prodotti:<br>
    @foreach($quantityDiscount->products as $product)
        {{ $product->name }}<br>
    @endforeach
@endif
">
                                                {{ $quantityDiscount->products->count() }}
                                            </span>
                                        </td>
                                        <td>{{ optional($quantityDiscount->created_at)->format('d/m/Y H:i') }}</td>
                                        <td>{{ optional($quantityDiscount->updated_at)->format('d/m/Y H:i') }}</td>
                                        <td class="text-end">
                                            <div class="dropdown tt-tb-dropdown">
                                                <button type="button" class="btn p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i data-feather="more-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end shadow">
                                                    <a class="dropdown-item" href="{{ route('quantity_discounts.edit', $quantityDiscount->id) }}">
                                                        <i data-feather="edit-3" class="me-2"></i>{{ localize('Modifica') }}
                                                    </a>
                                                    <a href="#" class="dropdown-item confirm-delete" data-href="{{ route('quantity_discounts.delete', $quantityDiscount->id) }}" title="{{ localize('Elimina') }}">
                                                        <i data-feather="trash" class="me-2"></i>{{ localize('Elimina') }}
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
                                <span>{{ localize('Mostrando') }}
                                    {{ $quantityDiscounts->firstItem() }}-{{ $quantityDiscounts->lastItem() }} {{ localize('di') }}
                                    {{ $quantityDiscounts->total() }} {{ localize('risultati') }}</span>
                                <nav>
                                    {{ $quantityDiscounts->appends(request()->input())->links() }}
                                </nav>
                            </div>
                            <!--pagination end-->
                        </div>
                    </div>
                </div>

                @can('add_quantity_discounts')
                <form action="{{ route('quantity_discounts.store') }}" class="pb-650" method="POST">
                    @csrf
                    <!-- Form fields -->
                </form>
                @endcan
            </div>
        </div>
    </div>
</section>
@endsection
