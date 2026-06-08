@extends('backend.layouts.app')
@section('content')
<div class="card"><div class="card-body">
    <h5>{{ translate('Bids for') }} {{ $product->name }}</h5>
    <table class="table"><thead><tr><th>{{ translate('User') }}</th><th>{{ translate('Amount') }}</th></tr></thead>
    <tbody>@foreach($bids as $b)<tr><td>{{ optional($b->user)->name }}</td><td>{{ single_price($b->amount) }}</td></tr>@endforeach</tbody></table>
</div></div>
@endsection
