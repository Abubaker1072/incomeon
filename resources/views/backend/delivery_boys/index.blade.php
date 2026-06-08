@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{ translate('All Delivery Boys') }}</h1>
        </div>
        @can('add_delivery_boy')
            <div class="col-md-6 text-md-right">
                <a href="{{ route('delivery-boys.create') }}" class="btn btn-circle btn-info">
                    <span>{{ translate('Add Delivery Boy') }}</span>
                </a>
            </div>
        @endcan
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table aiz-table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ translate('Name') }}</th>
                    <th>{{ translate('Email') }}</th>
                    <th>{{ translate('Phone') }}</th>
                    <th>{{ translate('City') }}</th>
                    <th>{{ translate('Collection') }}</th>
                    <th>{{ translate('Earning') }}</th>
                    <th class="text-right">{{ translate('Options') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($delivery_boys as $key => $boy)
                    @if ($boy->user)
                        <tr>
                            <td>{{ ($key + 1) + ($delivery_boys->currentPage() - 1) * $delivery_boys->perPage() }}</td>
                            <td>{{ $boy->user->name }}</td>
                            <td>{{ $boy->user->email }}</td>
                            <td>{{ $boy->user->phone }}</td>
                            <td>{{ $boy->user->city }}</td>
                            <td>{{ single_price($boy->total_collection) }}</td>
                            <td>{{ single_price($boy->total_earning) }}</td>
                            <td class="text-right">
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{ route('delivery-boys.edit', $boy->id) }}">
                                    <i class="las la-edit"></i>
                                </a>
                                <a href="{{ route('delivery-boy.ban', $boy->user_id) }}" class="btn btn-soft-warning btn-icon btn-circle btn-sm">
                                    <i class="las la-ban"></i>
                                </a>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        <div class="aiz-pagination">{{ $delivery_boys->links() }}</div>
    </div>
</div>
@endsection
