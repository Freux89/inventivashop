@extends('backend.layouts.master')

@section('title')
{{ localize('Cliente') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
<section class="tt-section pt-4">
    <div class="container">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ localize($error) }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">{{ localize('Modifica Cliente') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-4">
            <div class="col-xl-9">
                <!-- Form per modificare i dati dell'utente -->
                <form action="{{ route('admin.customers.update', $user->id) }}" method="POST" id="user-form">
                    @csrf
                    @method('PUT')
                    <div class="card mb-4" id="section-user-info">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Informazioni Base') }}</h5>

                            <!-- Nome -->
                            <div class="mb-4">
                                <label for="name" class="form-label">{{ localize('Nome') }}</label>
                                <input class="form-control" type="text" id="name" name="name" value="{{ $user->name }}" required>
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label for="email" class="form-label">{{ localize('Email') }}</label>
                                <input class="form-control" type="email" id="email" name="email" value="{{ $user->email }}" required>
                            </div>

                            <!-- Telefono -->
                            <div class="mb-4">
                                <label for="phone" class="form-label">{{ localize('Telefono') }}</label>
                                <input class="form-control" type="tel" id="phone" name="phone" value="{{ $user->phone }}">
                            </div>

                            <!-- Password (opzionale) -->
                            <div class="mb-4">
                                <label for="password" class="form-label">{{ localize('Password (lascia vuoto per non modificare)') }}</label>
                                <input class="form-control" type="password" id="password" name="password">
                            </div>

                            <!-- Pulsante di invio -->
                            <div class="mb-4">
                                <button class="btn btn-primary" type="submit">
                                    <i data-feather="save" class="me-1"></i> {{ localize('Aggiorna') }}
                                </button>
                            </div>

                        </div>
                    </div>
                </form>


            </div>
        </div>
        <!-- Qui inseriremo la sezione per le card degli indirizzi -->

        <!-- Sezione Indirizzi -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="mb-4">{{ localize('Indirizzi') }}</h5>

                        <!-- Sezione Indirizzi -->
                        <!-- Sezione Schede Indirizzi -->
                        <div class="row">
                            <div class="col-12">
                                <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping" type="button" role="tab" aria-controls="shipping" aria-selected="true">{{ localize('Indirizzi di Spedizione') }}</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="billing-tab" data-bs-toggle="tab" data-bs-target="#billing" type="button" role="tab" aria-controls="billing" aria-selected="false">{{ localize('Indirizzi di Fatturazione') }}</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                                        <!-- Indirizzi di Spedizione -->
                                        <div class="row">
                                            @forelse($user->addresses->where('document_type', 0) as $address)
                                            <div class="col-md-4">
                                                <div class="card m-3">
                                                    <div class="card-body">
                                                        <h6 class="card-title">
                                                            {{ $address->address_name }}
                                                            @if ($address->is_default)
                                                            <span class="badge bg-primary">{{ localize('Predefinito') }}</span>
                                                            @endif
                                                        </h6>

                                                        <ul class="list-unstyled">
                                                            <li>{{ $address->first_name }} {{ $address->last_name }}</li>
                                                            <li>{{ $address->country->name }}</li>
                                                            <li>{{ $address->state->name }}</li>
                                                            <li>{{ $address->city }}</li>
                                                            <li>{{ $address->address }}</li>
                                                        </ul>
                                                        <a href="{{ route('admin.address.edit', ['id' => $address->id, 'type' => 'shipping']) }}" class="btn btn-secondary btn-sm">{{ localize('Modifica') }}</a>
                                                        <a href="#" class="btn btn-danger btn-sm confirm-delete" data-href="{{ route('admin.address.delete', $address->id) }}" title="{{ localize('Delete') }}">
                                                            {{ localize('Delete') }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            @empty
                                            <div class="col-12">
                                                <div class="alert alert-info text-center">
                                                    Nessun indirizzo inserito
                                                </div>
                                            </div>
                                            @endforelse


                                        </div>
                                        <a href="{{ route('admin.address.create', ['id' => $user->id, 'type' => 'shipping']) }}" class="btn btn-primary">{{ localize('Aggiungi Indirizzo di Spedizione') }}</a>
                                    </div>
                                    <div class="tab-pane fade" id="billing" role="tabpanel" aria-labelledby="billing-tab">
                                        <!-- Indirizzi di Fatturazione -->
                                        <div class="row">
                                            @forelse($user->addresses->whereIn('document_type', [1, 2]) as $address)
                                            <div class="col-md-4">
                                                <div class="card m-3">
                                                    <div class="card-body">

                                                        <h6 class="card-title">
                                                            @if ($address->is_default)
                                                            <span class="badge bg-primary">{{ localize('Predefinito') }}</span>
                                                            @endif
                                                        </h6>

                                                        <ul class="list-unstyled">
                                                            @if($address->document_type == 1)
                                                            <li>{{ $address->company_name }}</li>
                                                            @elseif($address->document_type == 2)
                                                            <li>{{ $address->first_name }} {{ $address->last_name }}</li>
                                                            @endif
                                                            <li>{{ $address->address }}</li>
                                                            <li>{{ $address->country->name }}</li>
                                                            <li>{{ $address->state->name }}</li>
                                                            <li>{{ $address->city }}</li>
                                                            
                                                        </ul>

                                                        <a href="{{ route('admin.address.edit', ['id' => $address->id, 'type' => 'billing']) }}" class="btn btn-secondary btn-sm">{{ localize('Modifica') }}</a>
                                                        <a href="#" class="btn btn-danger btn-sm confirm-delete" data-href="{{ route('admin.address.delete', $address->id) }}" title="{{ localize('Delete') }}">
                                                            {{ localize('Delete') }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            @empty
                                            <div class="col-12">
                                                <div class="alert alert-info text-center">
                                                    Nessun indirizzo inserito
                                                </div>
                                            </div>
                                            @endforelse


                                        </div>
                                        <a href="{{ route('admin.address.create', ['id' => $user->id, 'type' => 'billing']) }}" class="btn btn-primary">{{ localize('Aggiungi Indirizzo di Fatturazione') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>






                    </div>
                </div>
            </div>
        </div>


        <!-- ... -->
    </div>
</section>


@endsection