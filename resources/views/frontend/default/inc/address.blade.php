@if ($address->document_type === 0)
    <address class="mb-0 d-inline">
        <strong>{{ $address->address_name }}</strong>
        <span class="ms-4">{{ $address->address }}</span>
    </address>
@else
    <address class="mb-0 d-inline">
        <strong>
            @if ($address->document_type === 1)
                {{ $address->company_name }}
            @else
                {{ $address->first_name }} {{ $address->last_name }}
            @endif
        </strong>
        <span class="ms-4">{{ $address->address }}</span>
    </address>
@endif
