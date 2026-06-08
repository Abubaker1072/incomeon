@php
    $steps = \App\Services\DeliveryService::timelineSteps();
    $currentStatus = $order->delivery_status ?? 'pending';
    $isFailed = $currentStatus === 'cancelled';
    $statusOrder = ['pending', 'confirmed', 'picked_up', 'on_the_way', 'delivered', 'cancelled'];
    $currentIndex = array_search($currentStatus, $statusOrder);
    if ($currentIndex === false) {
        $currentIndex = 0;
    }
@endphp

<div class="dlv-timeline">
    @foreach ($steps as $index => $step)
        @php
            $stepIndex = match($step['key']) {
                'assigned' => 0,
                'picked_up', 'in_transit' => 2,
                'out_for_delivery' => 3,
                'delivered' => 4,
                'failed' => 5,
                default => 0,
            };
            $isActive = !$isFailed && $currentIndex >= $stepIndex && $step['key'] !== 'failed';
            $isFailedStep = $isFailed && $step['key'] === 'failed';
            $isCurrent = (!$isFailed && $step['key'] === 'failed') ? false : (
                ($isFailed && $step['key'] === 'failed') ||
                (!$isFailed && in_array($currentStatus, $step['statuses']))
            );
        @endphp
        <div class="dlv-timeline__step {{ $isActive || $isFailedStep ? 'is-done' : '' }} {{ $isCurrent ? 'is-current' : '' }}">
            <div class="dlv-timeline__dot">
                @if ($isFailedStep)
                    <i class="las la-times"></i>
                @elseif ($isActive || $isCurrent)
                    <i class="las la-check"></i>
                @else
                    <span></span>
                @endif
            </div>
            <span class="dlv-timeline__label">{{ $step['label'] }}</span>
        </div>
        @if (!$loop->last)
            <div class="dlv-timeline__line {{ ($isActive && $index < count($steps) - 2) || $isFailedStep ? 'is-done' : '' }}"></div>
        @endif
    @endforeach
</div>
