@extends('modules.account.layouts.app')

@section('account_content')
    <div class="acc-page-head">
        <h1>{{ translate('Digital Purchase History') }}</h1>
        <a href="{{ route('purchase_history.index') }}" class="mp-btn mp-btn--outline">{{ translate('All Orders') }}</a>
    </div>

    <div class="acc-card">
        @if ($orders->count())
            <div class="acc-table-wrap">
                <table class="acc-table">
                    <thead>
                        <tr>
                            <th>{{ translate('Product') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $row)
                            @php $detail = \App\Models\OrderDetail::find($row->id); @endphp
                            @if ($detail && $detail->product)
                                <tr>
                                    <td>{{ $detail->product->getTranslation('name') }}</td>
                                    <td>
                                        <a href="{{ route('digital-products.download', encrypt($detail->product->id)) }}" class="mp-btn mp-btn--primary" style="padding:0.35rem 0.75rem;font-size:0.8rem;">
                                            <i class="las la-download"></i> {{ translate('Download') }}
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="margin-top:1.5rem;">
                @include('modules.marketplace.components.pagination', ['paginator' => $orders])
            </div>
        @else
            <p style="color:var(--mp-muted);">{{ translate('No digital purchases found.') }}</p>
        @endif
    </div>
@endsection
