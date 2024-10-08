@php
    // Assicurati che la variabile `section` sia definita
    if (!isset($section)) {
        return;
    }
@endphp

@if ($section)
    @include('frontend.default.pages.partials.sections.' . $section->type, ['section' => $section])
@endif