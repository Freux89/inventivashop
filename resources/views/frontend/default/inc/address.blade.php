<address class="fs-sm mb-0">
    <strong>{{ $address->address }}</strong>
</address>

<strong> {{ localize('City') }}: </strong>{{ $address->city }}
<br>

<strong>{{ localize('Provincia') }}: </strong>{{ $address->state->name }}

<br>
<strong>{{ localize('Country') }}: </strong> {{ $address->country->name }}
