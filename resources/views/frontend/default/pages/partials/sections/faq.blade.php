@php
if ($sectionType == 1) {
$section = [
'sectionTitle' => 'FAQ',
'sectionTitleColor' => '#FFFFFF',
'showTitle' => true,
'sectionBackgroundColor' => '#98C0C6',
'sectionPaddingY' => 9,
'divider' => false,
'columns' => [
[
'type' => 'faq',
'columnWidth' => 6,
'columnPaddingY' => 0,
'faqs' => [
[
'request' => 'Domanda numero 1',
'reply' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
],
[
'request' => 'Domanda numero 1',
'reply' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
],
[
'request' => 'Domanda numero 1',
'reply' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
],
[
'request' => 'Domanda numero 1',
'reply' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
]
]
],
[
'type' => 'faq',
'columnWidth' => 6,
'columnPaddingY' => 0,
'faqs' => [
[
'request' => 'Domanda numero 1',
'reply' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
],
[
'request' => 'Domanda numero 1',
'reply' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
],
[
'request' => 'Domanda numero 1',
'reply' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
],
[
'request' => 'Domanda numero 1',
'reply' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
]
]
]
]
]; // Chiusura dell'array $section
} // Chiusura del blocco if

@endphp

<section class="columns-layout-section py-{{$section['sectionPaddingY']}} position-relative z-1 overflow-hidden" style="background-color:{{ $section['sectionBackgroundColor'] }};">
    <div class="content-wrapper">
        @if ($section['showTitle'])
        <div class="section-title" style="color: {{ $section['sectionTitleColor'] }};">
            {{ localize($section['sectionTitle']) }}
        </div>
        @endif
        <div class="row m-0">
            @foreach ($section['columns'] as $columnIndex => $column)
            <div class="pe-md-6 {{ $column['columnWidth'] == 3 ? 'col-6' : 'col-12' }} col-md-{{ $column['columnWidth'] }} p-0 py-{{ $column['columnPaddingY'] }}  mb-6 mb-md-0 {{ isset($column['imageId']) && !isset($column['titleImage']) ? 'd-flex align-items-center justify-content-center' : '' }} {{ $columnIndex < count($section['columns']) - 1 && $section['divider'] ? 'divider-border-right' : '' }}">
                <div class="accordion" id="faqAccordion">
                    @foreach($column['faqs'] as $faqIndex => $faq)
                    <div class="accordion-item {{ $faqIndex === 0 ? 'border-top' : '' }} border-bottom">
                        <div class="accordion-header" id="heading{{ $columnIndex }}-{{ $faqIndex }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $columnIndex }}-{{ $faqIndex }}" aria-expanded="false" aria-controls="collapse{{ $columnIndex }}-{{ $faqIndex }}">
                                {{ $faq['request'] }}
                            </button>
                        </div>
                        <div id="collapse{{ $columnIndex }}-{{ $faqIndex }}" class="accordion-collapse collapse " aria-labelledby="heading{{ $columnIndex }}-{{ $faqIndex }}" data-bs-parent="#faqAccordion{{ $columnIndex }}">
                            <div class="accordion-body">
                                {{ $faq['reply'] }}
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>