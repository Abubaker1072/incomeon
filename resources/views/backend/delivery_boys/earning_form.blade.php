@extends('backend.layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('paid-to-delivery-boy') }}" method="POST">
            @csrf
            <input type="hidden" name="delivery_boy_id" value="{{ $delivery_boy->user_id }}">
            <p>{{ translate('Pay to') }}: <strong>{{ $delivery_boy->user->name }}</strong></p>
            <p>{{ translate('Available') }}: {{ single_price($delivery_boy->total_earning) }}</p>
            <div class="form-group">
                <label>{{ translate('Amount') }}</label>
                <input type="number" step="0.01" name="amount" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">{{ translate('Pay') }}</button>
        </form>
    </div>
</div>
@endsection
