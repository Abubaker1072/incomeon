@extends('backend.layouts.app')

@section('content')
    @if (auth()->user()->can('smtp_settings') && env('MAIL_USERNAME') == null && env('MAIL_PASSWORD') == null)
        <div class="alert alert-info d-flex align-items-center flex-wrap adm-dash-alert">
            {{ translate('Please Configure SMTP Setting to work all email sending functionality') }},
            <a class="alert-link ml-2" href="{{ route('smtp_settings.index') }}">{{ translate('Configure Now') }}</a>
        </div>
    @endif

    @if (in_array(auth()->user()->user_type, ['admin', 'staff']))
        <div class="adm-dash">
            {{-- Header --}}
            <div class="adm-dash__head">
                <div>
                    <div class="adm-dash__kicker">{{ translate('Overview') }}</div>
                    <h1 class="adm-dash__title">{{ translate('Dashboard') }}</h1>
                    <p class="adm-dash__subtitle">{{ translate('Welcome back') }}, {{ auth()->user()->name }} — {{ translate("here's what's happening today") }}</p>
                </div>
                <div class="adm-dash__head-actions">
                    <span class="adm-live-badge"><span class="adm-live-dot"></span> {{ translate('Live') }}</span>
                    <a href="{{ route('all_orders.index') }}" class="adm-dash-btn adm-dash-btn--ghost"><i class="las la-external-link-alt"></i> {{ translate('View Orders') }}</a>
                    <a href="{{ route('products.create') }}" class="adm-dash-btn adm-dash-btn--primary"><i class="las la-plus"></i> {{ translate('Add Product') }}</a>
                </div>
            </div>

            {{-- KPI row --}}
            <div class="adm-dash-kpi">
                <div class="adm-dash-kpi__card">
                    <div class="adm-dash-kpi__icon adm-dash-kpi__icon--blue"><i class="las la-wallet"></i></div>
                    <div class="adm-dash-kpi__body">
                        <span class="adm-dash-kpi__label">{{ translate('Total Revenue') }}</span>
                        <span class="adm-dash-kpi__value">{{ single_price($total_sale ?? 0) }}</span>
                        <span class="adm-dash-kpi__meta adm-dash-kpi__meta--up"><i class="las la-arrow-up"></i> {{ translate('All time') }}</span>
                    </div>
                </div>
                <div class="adm-dash-kpi__card">
                    <div class="adm-dash-kpi__icon adm-dash-kpi__icon--cyan"><i class="las la-shopping-bag"></i></div>
                    <div class="adm-dash-kpi__body">
                        <span class="adm-dash-kpi__label">{{ translate('Total Orders') }}</span>
                        <span class="adm-dash-kpi__value">{{ $total_order ?? 0 }}</span>
                        <span class="adm-dash-kpi__meta">{{ $total_pending_order ?? 0 }} {{ translate('pending') }}</span>
                    </div>
                </div>
                <div class="adm-dash-kpi__card">
                    <div class="adm-dash-kpi__icon adm-dash-kpi__icon--purple"><i class="las la-users"></i></div>
                    <div class="adm-dash-kpi__body">
                        <span class="adm-dash-kpi__label">{{ translate('Customers') }}</span>
                        <span class="adm-dash-kpi__value">{{ $total_customers ?? 0 }}</span>
                        <span class="adm-dash-kpi__meta">{{ translate('Verified customers') }}</span>
                    </div>
                </div>
                <div class="adm-dash-kpi__card">
                    <div class="adm-dash-kpi__icon adm-dash-kpi__icon--orange"><i class="las la-box"></i></div>
                    <div class="adm-dash-kpi__body">
                        <span class="adm-dash-kpi__label">{{ translate('Products') }}</span>
                        <span class="adm-dash-kpi__value">{{ $total_products ?? 0 }}</span>
                        <span class="adm-dash-kpi__meta">{{ $total_inhouse_products ?? 0 }} {{ translate('in-house') }} · {{ $total_sellers_products ?? 0 }} {{ translate('seller') }}</span>
                    </div>
                </div>
            </div>

            {{-- Charts + bottom widgets --}}
            @include('backend.dashboard.charts_section')

            {{-- Store summary row --}}
            <div class="adm-dash-grid adm-dash-grid--3">
                <div class="adm-dash-panel">
                    <div class="adm-dash-panel__head">
                        <h2>{{ translate('In-house Store') }}</h2>
                    </div>
                    <ul class="adm-dash-list">
                        <li><span>{{ translate('Total Sales') }}</span><strong>{{ single_price($total_inhouse_sale) }}</strong></li>
                        <li><span>{{ translate('In-house product') }}</span><strong>{{ $total_inhouse_products }}</strong></li>
                        <li><span>{{ translate('Ratings') }}</span><strong>{{ number_format($inhouse_product_rating ?? 0, 1) }}</strong></li>
                        <li><span>{{ translate('Total Orders') }}</span><strong>{{ $total_inhouse_order }}</strong></li>
                    </ul>
                    <a href="{{ route('inhouse_orders.index') }}" class="adm-dash-btn adm-dash-btn--block adm-dash-btn--ghost mt-3">{{ translate('All In-house Orders') }}</a>
                </div>

                <div class="adm-dash-panel">
                    <div class="adm-dash-panel__head">
                        <h2>{{ translate('In-house Top Category') }}</h2>
                        <small>{{ translate('By Sales') }}</small>
                    </div>
                    <ul class="adm-dash-rank">
                        @foreach ($top_categories as $key => $top_category)
                            @php
                                $cat = \App\Models\CategoryTranslation::where('category_id', $top_category->id)->where('lang', app()->getLocale())->first();
                                $colors = ['adm-rank--1', 'adm-rank--2', 'adm-rank--3'];
                            @endphp
                            <li class="adm-dash-rank__item {{ $colors[$key] ?? '' }}">
                                <span class="adm-dash-rank__name">{{ $cat->name ?? translate('Not Found') }}</span>
                                <span class="adm-dash-rank__val">{{ single_price($top_category->total) }}</span>
                            </li>
                        @endforeach
                        @if ($top_categories->isEmpty())
                            <li class="adm-dash-empty">{{ translate('No data yet') }}</li>
                        @endif
                    </ul>
                </div>

                <div class="adm-dash-panel adm-dash-panel--promo">
                    @if (get_setting('vendor_system_activation') == 1)
                        <div class="adm-dash-panel__head"><h2>{{ translate('Sellers') }}</h2></div>
                        <div class="adm-dash-sellers__count">{{ $total_sellers }}</div>
                        <p class="adm-dash-sellers__label">{{ translate('Total Sellers') }}</p>
                        @foreach ($status_wise_sellers as $sw)
                            <div class="adm-dash-sellers__row">
                                <span>{{ $sw->verification_status == 1 ? translate('Approved Sellers') : translate('Pending Seller') }}</span>
                                <strong>{{ $sw->total }}</strong>
                            </div>
                        @endforeach
                        <div class="adm-dash-avatars adm-dash-avatars--sm mt-3">
                            @foreach ($top_sellers as $seller)
                                <div class="adm-dash-avatar" title="{{ $seller->name }}">
                                    <img src="{{ uploaded_asset($seller->avatar_original) }}" alt=""
                                        onerror="this.src='{{ static_asset('assets/img/placeholder.jpg') }}'">
                                </div>
                            @endforeach
                        </div>
                        <a href="{{ route('sellers.index') }}" class="adm-dash-btn adm-dash-btn--block adm-dash-btn--primary mt-3">{{ translate('All Sellers') }}</a>
                    @else
                        <div class="adm-dash-promo">
                            <img src="{{ static_asset('assets/img/multivendor.jpg') }}" alt="" class="adm-dash-promo__img">
                            <h3>{{ translate('Multi-Vendor E-commerce Marketplace') }}</h3>
                            <a href="{{ route('activation.index') }}" class="adm-dash-btn adm-dash-btn--primary">{{ translate('Activate Vendor System') }}</a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Top brands --}}
            <div class="adm-dash-grid adm-dash-grid--2">
                <div class="adm-dash-panel">
                    <div class="adm-dash-panel__head">
                        <h2>{{ translate('In-house Top Brands') }}</h2>
                        <small>{{ translate('By Sales') }}</small>
                    </div>
                    <ul class="adm-dash-rank">
                        @foreach ($top_brands as $key => $top_brand)
                            @php
                                $brand = \App\Models\BrandTranslation::where('brand_id', $top_brand->id)->where('lang', app()->getLocale())->first();
                            @endphp
                            <li class="adm-dash-rank__item">
                                <span class="adm-dash-rank__name">{{ $brand->name ?? translate('Not Found') }}</span>
                                <span class="adm-dash-rank__val">{{ single_price($top_brand->total) }}</span>
                            </li>
                        @endforeach
                        @if ($top_brands->isEmpty())
                            <li class="adm-dash-empty">{{ translate('No data yet') }}</li>
                        @endif
                    </ul>
                </div>

                <div class="adm-dash-panel adm-dash-panel--sales">
                    <div class="adm-dash-panel__head">
                        <h2>{{ translate('Sales Breakdown') }}</h2>
                        <span class="adm-chart-badge adm-chart-badge--blue">{{ translate('This month') }}</span>
                    </div>
                    <div class="adm-dash-sales__total">{{ single_price($sale_this_month) }}</div>
                    <div class="adm-dash-sales__split">
                        <div>
                            <span class="adm-dot adm-dot--blue"></span>
                            {{ translate('In-house Sales') }}
                            <em>{{ single_price($admin_sale_this_month->total_sale ?? 0) }}</em>
                        </div>
                        <div>
                            <span class="adm-dot adm-dot--cyan"></span>
                            {{ translate('Sellers Sales') }}
                            <em>{{ single_price($seller_sale_this_month->total_sale ?? 0) }}</em>
                        </div>
                    </div>
                    <div class="adm-mini-bars">
                        @php $saleBars = [40, 55, 48, 70, 62, 85, 78, 92, 88, 75, 82, 95]; @endphp
                        @foreach ($saleBars as $h)
                            <span style="--h:{{ $h }}%"></span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">{{ translate('You do not have permission to view the dashboard.') }}</div>
    @endif
@endsection
