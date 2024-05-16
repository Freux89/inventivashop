@extends('backend.layouts.master')

@section('title')
{{ localize('Posiziona Sezione') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
<section class="tt-section pt-4">
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">{{ localize('Posiziona Sezione') }}</h2>
                        </div>
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.section_positions.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="section" class="form-label">{{ localize('Sezione') }}</label>
                                <select class="form-control" id="section" name="section_id" required>
                                <option value="">Seleziona una sezione</option>
                                    @foreach($sections as $section)
                                    
                                    <option value="{{$section->id}}">{{$section->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="positionType" class="form-label">{{ localize('Tipo di Posizione') }}</label>
                                <select class="form-control" id="positionType" name="position_type">
                                    <option value="Home">Home</option>
                                    <option value="Category">Categoria</option>
                                    <option value="Product">Prodotti</option>
                                    <option value="Page">Pagine</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="hook" class="form-label">{{ localize('Hook') }}</label>
                                <select class="form-control" id="hook" name="hook">
                                <option value="hook_before_content" >{{localize('hook_before_content')}}</option>
                                    <option value="hook_after_content" >{{localize('hook_after_content')}}</option>
                                    <option value="hook_home" class="home-hook" >{{localize('hook_home')}}</option>
                                </select>
                            </div>
                            <div class="mb-3" id="entitySelectContainer">
                                <label for="entitySelect" class="form-label">{{ localize('Entità') }}</label>
                                <select class="form-control" id="entitySelect" name="entities[]" multiple>
                                    <!-- Opzioni delle entità aggiornate dinamicamente -->
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ localize('Salva') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const positionTypeSelect = document.getElementById('positionType');
        const hookSelect = document.getElementById('hook');
        const entitySelectContainer = document.getElementById('entitySelectContainer');
        const entitySelect = document.getElementById('entitySelect');

        positionTypeSelect.addEventListener('change', function() {
            const type = this.value;
            updateHooks(type);
            fetch(`{{ route('admin.section_positions.entities', '') }}/${type}`)
                .then(response => response.text()) // Ottieni la risposta come HTML
                .then(html => {
                    entitySelect.innerHTML = html; // Inserisci l'HTML nella select delle entità
                    $('#entitySelect').select2({
                placeholder: "Lascia vuoto questo campo per selezionare tutte le entità",
                allowClear: true,
                width: '100%' // Assicurati che Select2 sia largo come il contenitore
            });
                })
                .catch(error => console.error('Error:', error));

            

            $('#entitySelect').on('change', function() {
                if ($(this).val().includes('all')) {
                    $(this).val($('#entitySelect option').map(function() {
                        return this.value;
                    }).get()).trigger('change');
                }
            });

        });

        function updateHooks(type) {
    const hookSelect = document.getElementById('hook');
    const homeHookOption = document.querySelector('.home-hook');
    const otherHooksOptions = document.querySelectorAll('#hook option:not(.home-hook)');

    // Nascondi tutte le opzioni prima
    homeHookOption.style.display = 'none';
    otherHooksOptions.forEach(option => option.style.display = 'none');

    // Mostra solo le opzioni appropriate
    if (type === 'Home') {
        homeHookOption.style.display = '';
        // Controlla se l'opzione home è quella correntemente selezionata, altrimenti cambiala
        if (hookSelect.value !== 'hook_home') {
            hookSelect.value = 'hook_home';
        }
    } else {
        otherHooksOptions.forEach(option => option.style.display = '');
        // Verifica se l'opzione corrente è visibile, se no cambia a 'hook_before_content'
        if (homeHookOption.selected) {
            hookSelect.value = 'hook_before_content';
        }
    }
}



        // Inizializza la pagina con i valori predefiniti
        updateHooks('home');

    });
</script>
@endsection