@php
    $address_data = $address_data ?? null;
    $countries = \App\Models\Country::where('status', 1)->get();
@endphp
<div class="acc-modal__head">
    <h3>{{ translate('Edit Address') }}</h3>
    <button type="button" class="acc-modal__close" data-close-modal>&times;</button>
</div>
@if ($address_data)
    <form action="{{ route('addresses.update', $address_data->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="acc-field">
            <label>{{ translate('Address') }}</label>
            <textarea name="address" rows="2" required>{{ $address_data->address }}</textarea>
        </div>
        <div class="acc-field">
            <label>{{ translate('Country') }}</label>
            <select name="country_id" class="acc-edit-country" required>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}" {{ $address_data->country_id == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="acc-field">
            <label>{{ translate('State') }}</label>
            <select name="state_id" class="acc-edit-state" required>
                @foreach ($states ?? [] as $state)
                    <option value="{{ $state->id }}" {{ $address_data->state_id == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="acc-field">
            <label>{{ translate('City') }}</label>
            <select name="city_id" class="acc-edit-city" required>
                @foreach ($cities ?? [] as $city)
                    <option value="{{ $city->id }}" {{ $address_data->city_id == $city->id ? 'selected' : '' }}>{{ $city->getTranslation('name') }}</option>
                @endforeach
            </select>
        </div>
        <div class="acc-field">
            <label>{{ translate('Postal Code') }}</label>
            <input type="text" name="postal_code" value="{{ $address_data->postal_code }}">
        </div>
        <div class="acc-field">
            <label>{{ translate('Phone') }}</label>
            <input type="text" name="phone" value="{{ $address_data->phone }}" required>
        </div>
        <button type="submit" class="mp-btn mp-btn--primary" style="width:100%;justify-content:center;">{{ translate('Update Address') }}</button>
    </form>
@endif
