<div class="row align-items-center g-4 mt-3">
    <form action="{{ route('address.update') }}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $address->id }}">
        <div class="row g-4">
            <div class="col-sm-6">
                <div class="w-100 label-input-field">
                    <label>{{ localize('Country') }}</label>
                    <select class="select2Address" name="country_id" required>
                        <option value="">{{ localize('Select Country') }}</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}" @if ($address->country_id == $country->id) selected @endif>
                                {{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="w-100 label-input-field">
                    <label>{{ localize('State') }}</label>
                    <select class="select2Address" required name="state_id">
                        <option value="">{{ localize('Select State') }}</option>
                        @foreach ($states as $state)
                            <option value="{{ $state->id }}" @if ($address->state_id == $state->id) selected @endif>
                                {{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="w-100 label-input-field">
                    <label>{{ localize('City') }}</label>
                    <select class="select2Address" required name="city_id">
                        <option value="">{{ localize('Select City') }}</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}" @if ($address->city_id == $city->id) selected @endif>
                                {{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="w-100 label-input-field">
                    <label>{{ localize('Default Address?') }}</label>
                    <select class="select2Address" name="is_default">
                        <option value="0" @if ($address->is_default == 0) selected @endif>{{ localize('No') }}
                        </option>
                        <option value="1" @if ($address->is_default == 1) selected @endif>
                            {{ localize('Set Default') }}</option>
                    </select>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="label-input-field">
                    <label>{{ localize('Address') }}</label>
                    <textarea rows="4" placeholder="{{ localize('2/5 Elephant Road, New Town') }}" name="address">{{ $address->address }}</textarea>
                </div>
            </div>

        </div>
        <div class="mt-6 d-flex">
            <button type="submit" class="btn btn-secondary btn-md me-3">{{ localize('Update') }}</button>
        </div>
    </form>
</div>
