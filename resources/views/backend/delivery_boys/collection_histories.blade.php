@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
    <h1 class="h3">{{ translate('Collection Histories') }}</h1>
</div>
<div class="card">
    <div class="card-body">
        <table class="table aiz-table mb-0">
            <thead>
                <tr>
                    <th>{{ translate('Delivery Boy') }}</th>
                    <th>{{ translate('Amount') }}</th>
                    <th>{{ translate('Date') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($collections as $collection)
                    <tr>
                        <td>{{ optional($collection->user)->name }}</td>
                        <td>{{ single_price($collection->collection_amount ?? 0) }}</td>
                        <td>{{ $collection->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center">{{ translate('No records') }}</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="aiz-pagination">{{ $collections->links() }}</div>
    </div>
</div>
@endsection
