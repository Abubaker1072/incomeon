<!doctype html>
<html><head><meta charset="utf-8"><title>{{ translate('Receipt') }} #{{ $order->code }}</title>
<style>body{font-family:monospace;font-size:12px;max-width:300px;margin:20px auto}table{width:100%}</style>
</head><body onload="window.print()">
<h3>{{ get_setting('site_name') }}</h3>
<p>{{ translate('Order') }}: #{{ $order->code }}</p>
<p>{{ date('Y-m-d H:i', $order->date) }}</p>
<table>
@foreach($order->orderDetails as $d)
<tr><td>{{ optional($d->product)->name }} x{{ $d->quantity }}</td><td align="right">{{ single_price($d->price) }}</td></tr>
@endforeach
</table>
<hr>
<p><strong>{{ translate('Total') }}: {{ single_price($order->grand_total) }}</strong></p>
</body></html>
