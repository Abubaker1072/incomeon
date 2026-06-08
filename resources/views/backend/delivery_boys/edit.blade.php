@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
    <h1 class="h3">{{ translate('Edit Delivery Boy') }}</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('delivery-boys.update', $delivery_boy->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group row">
                <label class="col-md-3 col-form-label">{{ translate('Name') }}</label>
                <div class="col-md-9"><input type="text" class="form-control" name="name" value="{{ $delivery_boy->user->name }}" required></div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-form-label">{{ translate('Email') }}</label>
                <div class="col-md-9"><input type="email" class="form-control" name="email" value="{{ $delivery_boy->user->email }}" required></div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-form-label">{{ translate('Phone') }}</label>
                <div class="col-md-9"><input type="text" class="form-control" name="phone" value="{{ $delivery_boy->user->phone }}" required></div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-form-label">{{ translate('City') }}</label>
                <div class="col-md-9"><input type="text" class="form-control" name="city" value="{{ $delivery_boy->user->city }}" required></div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-form-label">{{ translate('Password') }}</label>
                <div class="col-md-9"><input type="password" class="form-control" name="password" placeholder="{{ translate('Leave blank to keep current') }}"></div>
            </div>
            <div class="form-group mb-0 text-right">
                <button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection
