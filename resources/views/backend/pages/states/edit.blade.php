@extends('backend.layouts.master')

@section('title')
{{ localize('Modifica stato ordine') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
<section class="tt-section pt-4">
    <div class="container">
    <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">{{ localize('Modifica stato ordine') }}</h2>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4 g-4">
            <div class="col-xl-9">
                <!-- Cambia l'azione del form per puntare al metodo update del controller -->
                <form action="{{ route('admin.orderStates.update', $orderState->id) }}" method="POST" class="pb-650" id="state-form">
                    @csrf
                    @method('PUT') <!-- Metodo HTTP per l'aggiornamento -->
                    <input type="hidden" name="type" value="{{ $orderState->type }}">
                    <div class="card mb-4" id="section-1">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Basic Information') }}</h5>

                            <!-- Carica i valori esistenti -->
                            <div class="mb-4">
                                <label for="name" class="form-label">{{ localize('Nome') }}</label>
                                <input class="form-control" type="text" id="name" placeholder="{{ localize('Digita il nome dello stato') }}" name="name" value="{{ $orderState->name }}" required>
                            </div>
                            <div class="mb-4">
                                <label for="color" class="form-label">{{ localize('Colore stato') }}</label>
                                <input type="color" class="form-control" id="color" name="color" value="{{ $orderState->color }}">
                            </div>

                            <div class="mb-4">
                                <label for="send_email" class="form-label">{{ localize('Invia Email al cliente') }}</label>
                                <select class="form-control" id="send_email" name="send_email" onchange="toggleEmailContent()">
                                    <option value="0" {{ $orderState->send_email == 0 ? 'selected' : '' }}>{{ localize('Non inviare') }}</option>
                                    <option value="1" {{ $orderState->send_email == 1 ? 'selected' : '' }}>{{ localize('Invia') }}</option>
                                </select>
                            </div>

                            <div class="mb-4" id="email_content_container" style="{{ $orderState->send_email == 1 ? 'display: block;' : 'display: none;' }}">
                                <label for="email_content" class="form-label">{{ localize('Contenuto email') }}</label>
                                <textarea id="email_content" class="editor" name="email_content">{{ $orderState->email_content }}</textarea>
                            </div>


                            <!-- submit button -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-4">
                                        <button class="btn btn-primary" type="submit">
                                            <i data-feather="save" class="me-1"></i> {{ localize('Aggiorna stato') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- submit button end -->

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script>
    function toggleEmailContent() {
        var sendEmail = document.getElementById('send_email').value;
        var emailContentContainer = document.getElementById('email_content_container');
        emailContentContainer.style.display = sendEmail == '1' ? 'block' : 'none';
    }
</script>
@endsection