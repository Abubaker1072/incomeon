@extends('backend.layouts.app')
@section('content')
<div class="card"><div class="card-body"><p>{{ translate('Affiliate system configuration') }} — <a href="{{ route('affiliate.configs') }}">{{ translate('Settings') }}</a></p></div></div>
@endsection
