@extends('backend.layouts.app')
@section('content')
<div class="card"><div class="card-body">
    <h5>{{ translate('Auction Products') }}</h5>
    <table class="table"><thead><tr><th>{{ translate('Name') }}</th><th>{{ translate('Bids') }}</th></tr></thead>
    <tbody>@foreach($products as $p)<tr><td>{{ $p->name }}</td><td><a href="{{ route('product_bids.admin', $p->id) }}">{{ translate('View') }}</a></td></tr>@endforeach</tbody></table>
    {{ $products->links() }}
</div></div>
@endsection
