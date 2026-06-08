@extends('backend.layouts.app')
@section('content')
<div class="card"><div class="card-body">
    <h5>{{ translate('Club Points') }}</h5>
    <table class="table"><thead><tr><th>{{ translate('User') }}</th><th>{{ translate('Points') }}</th></tr></thead>
    <tbody>@foreach($club_points as $cp)<tr><td>{{ optional($cp->user)->name }}</td><td>{{ $cp->points }}</td></tr>@endforeach</tbody></table>
</div></div>
@endsection
