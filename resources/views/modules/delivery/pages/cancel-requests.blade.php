@extends('modules.delivery.layouts.app')

@section('panel_content')
<div class="dlv-page">
    <div class="dlv-page__head">
        <h1>{{ translate('Cancel Requests') }}</h1>
    </div>

    <div class="dlv-card-grid">
        @forelse ($orders as $order)
            @include('modules.delivery.components.delivery-card', ['order' => $order])
        @empty
            <div class="dlv-empty-state">
                <p>{{ translate('No cancel requests') }}</p>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection
