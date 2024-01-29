@if ($address->document_type === 0)
    <address class="fs-sm mb-0">
        <strong>{{ $address->address_name }}</strong>
    </address>
@else
    <address class="fs-sm mb-0">
        <strong>
            @if ($address->document_type === 1)
                {{ $address->company_name }}
            @else
                {{ $address->first_name }} {{ $address->last_name }}
            @endif
        </strong>
    </address>
@endif

<strong> {{ localize('City') }}: </strong>{{ $address->city }}
<br>
<strong>{{ localize('Provincia') }}: </strong>{{ $address->state->name }}
<br>
<strong>{{ localize('Indirizzo') }}: </strong> {{ $address->address }}