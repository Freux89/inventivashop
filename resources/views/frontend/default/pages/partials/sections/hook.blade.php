@php
    // Costruisci il nome della variabile basato su `hook_name` passato
    $hookVariableName = $hook_name . '_sections';

    // Usa la funzione `get_defined_vars()` per accedere alle variabili definite nella vista
    $sections = get_defined_vars()['__data'][$hookVariableName] ?? null;
   
@endphp

@if (!empty($sections))
    @foreach ($sections as $section)
        @if ($section)
            @include('frontend.default.pages.partials.sections.' . $section->section->type, ['section' => $section->section])
        @endif
    @endforeach
@endif

