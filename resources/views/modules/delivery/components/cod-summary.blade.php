<div class="dlv-cod-summary">
    <div class="dlv-cod-summary__grid">
        <div class="dlv-cod-summary__item">
            <span class="dlv-cod-summary__label">{{ translate('Total Collected') }}</span>
            <strong class="dlv-cod-summary__value">{{ single_price($cod['total_collection'] ?? 0) }}</strong>
        </div>
        <div class="dlv-cod-summary__item dlv-cod-summary__item--highlight">
            <span class="dlv-cod-summary__label">{{ translate('Today') }}</span>
            <strong class="dlv-cod-summary__value">{{ single_price($cod['today_collection'] ?? 0) }}</strong>
            <small>{{ $cod['cod_orders_today'] ?? 0 }} {{ translate('orders') }}</small>
        </div>
        <div class="dlv-cod-summary__item">
            <span class="dlv-cod-summary__label">{{ translate('Yesterday') }}</span>
            <strong class="dlv-cod-summary__value">{{ single_price($cod['yesterday_collection'] ?? 0) }}</strong>
        </div>
    </div>

    @if (!empty($cod['recent_collections']) && $cod['recent_collections']->count())
        <div class="dlv-cod-summary__list">
            <h4>{{ translate('Recent COD Collections') }}</h4>
            <ul>
                @foreach ($cod['recent_collections'] as $item)
                    <li>
                        <span>#{{ optional($item->order)->code ?? $item->order_id }}</span>
                        <strong>{{ single_price($item->collection) }}</strong>
                        <small>{{ $item->created_at->format('M d, H:i') }}</small>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
