@php $countries = \App\Models\Country::where('status', 1)->get(); @endphp
<div class="acc-modal" id="acc-address-modal">
    <div class="acc-modal__box">
        <div class="acc-modal__head">
            <h3>{{ translate('Add New Address') }}</h3>
            <button type="button" class="acc-modal__close" data-close-modal>&times;</button>
        </div>
        <form action="{{ route('addresses.store') }}" method="POST">
            @csrf
            <div class="acc-field">
                <label>{{ translate('Address') }}</label>
                <textarea name="address" rows="2" required></textarea>
            </div>
            <div class="acc-field">
                <label>{{ translate('Country') }}</label>
                <select name="country_id" id="acc-country" required>
                    <option value="">{{ translate('Select Country') }}</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="acc-field">
                <label>{{ translate('State') }}</label>
                <select name="state_id" id="acc-state" required></select>
            </div>
            <div class="acc-field">
                <label>{{ translate('City') }}</label>
                <select name="city_id" id="acc-city" required></select>
            </div>
            <div class="acc-field">
                <label>{{ translate('Postal Code') }}</label>
                <input type="text" name="postal_code">
            </div>
            <div class="acc-field">
                <label>{{ translate('Phone') }}</label>
                <input type="text" name="phone" required>
                <input type="hidden" name="country_code" value="92">
            </div>
            <button type="submit" class="mp-btn mp-btn--primary" style="width:100%;justify-content:center;">{{ translate('Save Address') }}</button>
        </form>
    </div>
</div>
