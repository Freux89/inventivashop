<address class="fs-sm mb-0">
    <strong>{{ $address->address }}</strong>
</address>

<strong> {{ localize('City') }}: </strong>{{ $address->city->name }}
<br>

<strong>{{ localize('State') }}: </strong>{{ $address->state->name }}

<br>
<strong>{{ localize('Country') }}: </strong> {{ $address->country->name }}
