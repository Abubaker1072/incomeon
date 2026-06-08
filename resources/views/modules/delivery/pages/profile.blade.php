@extends('modules.delivery.layouts.app')

@section('panel_content')
<div class="dlv-page">
    <div class="dlv-page__head">
        <h1>{{ translate('Profile') }}</h1>
    </div>

    <div class="dlv-panel" style="max-width: 560px;">
        <ul class="dlv-detail-list">
            <li><span>{{ translate('Name') }}</span><strong>{{ auth()->user()->name }}</strong></li>
            <li><span>{{ translate('Email') }}</span><strong>{{ auth()->user()->email }}</strong></li>
            <li><span>{{ translate('Phone') }}</span><strong>{{ auth()->user()->phone ?? '—' }}</strong></li>
            <li><span>{{ translate('City') }}</span><strong>{{ auth()->user()->city ?? '—' }}</strong></li>
            <li><span>{{ translate('Total Collection') }}</span><strong>{{ single_price($delivery_boy->total_collection ?? 0) }}</strong></li>
            <li><span>{{ translate('Total Earnings') }}</span><strong>{{ single_price($delivery_boy->total_earning ?? 0) }}</strong></li>
        </ul>
    </div>
</div>
@endsection
