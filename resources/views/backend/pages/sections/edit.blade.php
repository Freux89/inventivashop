@extends('backend.layouts.master')

@section('title')
{{ localize('Modifica Sezione') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
@php
$currentItemsCount = count($section->items); // Numero attuale di colonne presenti nella sezione
@endphp

<section class="tt-section pt-4">
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">{{ localize('Modifica Sezione') }}</h2>
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


                <form method="POST" action="{{ route('admin.sections.update', ['id' => $section->id]) }}">
                    @csrf
                    @method('PUT')
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">{{ localize('Nome Sezione') }}</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $section->name) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="type" class="form-label">{{ localize('Tipo di sezione') }}</label>
                                    <input type="text" class="form-control" id="type" name="type" value="{{ $section->type }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Inizia la sezione Stile -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5>{{ localize('Dettagli Sezione') }}</h5>
                            <div class="row">
                                <div class="col-12">
                                    <strong>{{ localize('Titolo') }}</strong>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="title" class="form-label">{{ localize('Titolo') }}</label>
                                    <input type="text" class="form-control" id="title" name="settings[title]" value="{{ old('settings.title', $section->settings['title'] ?? '') }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="titleSize" class="form-label">{{ localize('Grandezza Titolo') }}</label>
                                    <input class="form-control" type="number" id="titleSize" name="settings[titleSize]" value="{{ isset($section->settings['titleSize']) ? $section->settings['titleSize'] : '30' }}" min="10" max="72">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="titleColor" class="form-label">{{ localize('Colore Titolo') }}</label>
                                    <input type="color" class="form-control color-picker" id="titleColor" name="settings[titleColor]" value="{{ old('settings.titleColor', $section->settings['titleColor'] ?? '#105862') }}">
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="titleAlignment" class="form-label">{{ localize('Allineamento') }}</label>
                                    <select class="form-control" id="titleAlignment" name="settings[titleAlignment]">
                                        <option value="left" {{ isset($section->settings['titleAlignment']) && $section->settings['titleAlignment'] == 'left' ? 'selected' : '' }}>Sinistra</option>
                                        <option value="center" {{ isset($section->settings['titleAlignment']) && $section->settings['titleAlignment'] == 'center' ? 'selected' : '' }}>Centrato</option>
                                        <option value="right" {{ isset($section->settings['titleAlignment']) && $section->settings['titleAlignment'] == 'right' ? 'selected' : '' }}>Destra</option>
                                    </select>
                                </div>
                            </div>
                            @if($section->type == 'carousel')
                            <div class="row">
                                <div class="col-12">
                                    <strong>{{ localize('Stile') }}</strong>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="titleAlignment" class="form-label">{{ localize('Forma elementi') }}</label>
                                    <select class="form-control" id="titleAlignment" name="settings[layout]">
                                        <option value="rounded" {{ isset($section->settings['layout']) && $section->settings['layout'] == 'rounded' ? 'selected' : '' }}>Rotondi</option>
                                        <option value="square" {{ isset($section->settings['layout']) && $section->settings['layout'] == 'square' ? 'selected' : '' }}>Quadrati</option>
                                    </select>
                                </div>
                            </div>
                            @endif
                            <div class="row mb-3">
                                <div class="col-12">
                                    <strong>{{ localize('Sfondo') }}</strong>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="backgroundColor" class="form-label">{{ localize('Colore Sfondo') }}</label>
                                    <input type="color" class="form-control color-picker" id="backgroundColor" name="settings[backgroundColor]" value="{{ old('settings.backgroundColor', $section->settings['backgroundColor'] ?? '#ffffff') }}">
                                </div>

                                <div class="col-md-4">
                                    <label for="sectionPaddingY" class="form-label">{{ localize('Padding Verticale') }}</label>
                                    <select class="form-select" id="sectionPaddingY" name="settings[paddingY]">
                                        @for ($i = 0; $i <= 9; $i++) <option value="{{ $i }}" {{ isset($section->settings['paddingY']) && $section->settings['paddingY'] == $i ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                            <option value="12" {{ isset($section->settings['paddingY']) && $section->settings['paddingY'] == 12 ? 'selected' : '' }}>12</option>
                                    </select>
                                    <span class="fs-sm text-muted">{{ localize('Definisce lo spazio verticale all\'interno della sezione.') }}</span>
                                </div>
                                @if($section->type == 'columns')
                                @include('backend.pages.sections.items.partials.columnsLayout')

                                @endif
                               
                            </div>
                            @if($section->type == 'filtergrid')
                                    @include('backend.pages.sections.items.partials.filterCategories')
                                @endif
                        </div>
                    </div>


                    <button type="submit" class="btn btn-primary">{{ localize('Salva') }}</button>
                </form>

            </div>
        </div>

        @include('backend.pages.sections.items.index',['section' => $section])


    </div>
    </div>
</section>
@endsection

@if($section->type == 'columns')
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var currentValidLayout = document.getElementById('columnLayout').value;
        var currentItemsCount = {{ $currentItemsCount }};

        function updateColumnDisplay() {

            var layout = document.getElementById('columnLayout').value.split('-');
            const display = document.getElementById('columnDisplay');
            display.innerHTML = ''; // Clear previous display


            if (layout.length < currentItemsCount) {
                alert('Hai inserito ' + currentItemsCount + ' colonne in questa sezione. Prima di diminuire il numero massimo di colonne, cancella le colonne che desideri escludere.');
                document.getElementById('columnLayout').value = currentValidLayout; // Reimposta il valore originale
                layout = document.getElementById('columnLayout').value.split('-');
            } else {
                currentValidLayout = document.getElementById('columnLayout').value; // Aggiorna il valore corrente valido
            }

            layout.forEach(function(size) {
                const column = document.createElement('div');
                column.style.width = `${(size / 12) * 100}%`;
                column.style.height = '100px'; // Fixed height for display
                column.style.float = 'left';
                column.style.border = '1px solid #000';
                column.style.boxSizing = 'border-box';
                display.appendChild(column);
            });
            if (layout.length > 1) {
                display.lastChild.style.marginRight = '0'; // Remove margin for the last column
            }

        }

        // Bind the change event to the select element
        document.getElementById('columnLayout').addEventListener('change', updateColumnDisplay);

        // Call the function on page load to display the initial selection
        updateColumnDisplay();
    });
</script>

@endsection
@endif