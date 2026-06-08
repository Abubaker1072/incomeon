@foreach (session('flash_notification', collect()) as $flash)
    <div class="mp-container" style="padding-top:1rem;">
        <div class="acc-flash acc-flash--{{ $flash['level'] === 'danger' ? 'danger' : ($flash['level'] === 'warning' ? 'warning' : 'success') }}">
            {{ $flash['message'] }}
        </div>
    </div>
@endforeach
@if ($errors->any())
    <div class="mp-container" style="padding-top:1rem;">
        <div class="acc-flash acc-flash--danger">
            <ul style="margin:0;padding-left:1.25rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
