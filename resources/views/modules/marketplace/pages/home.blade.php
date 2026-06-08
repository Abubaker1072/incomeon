@extends('modules.marketplace.layouts.app')

@section('content')
    {{-- Hero Banner --}}
    @include('modules.marketplace.partials.home.hero')

    {{-- Categories --}}
    @include('modules.marketplace.partials.home.categories', ['featured_categories' => $featured_categories])

    {{-- Featured Products (AJAX) --}}
    <section class="mp-section mp-section--white">
        <div class="mp-container" id="mp-featured"></div>
    </section>

    {{-- Flash Deals --}}
    @include('modules.marketplace.partials.home.flash-deals')

    {{-- Auctions --}}
    @if(addon_is_activated('auction'))
        @include('modules.marketplace.partials.home.auctions')
    @endif

    {{-- Popular Stores (AJAX) --}}
    <section class="mp-section">
        <div class="mp-container" id="mp-popular-stores"></div>
    </section>

    {{-- Today's Deal (AJAX) --}}
    <section class="mp-section mp-section--white">
        <div class="mp-container" id="mp-todays-deal"></div>
    </section>

    {{-- New Arrivals (AJAX) --}}
    <section class="mp-section">
        <div class="mp-container" id="mp-new-arrivals"></div>
    </section>

    {{-- Best Selling (AJAX) --}}
    <section class="mp-section mp-section--white">
        <div class="mp-container" id="mp-best-selling"></div>
    </section>

    {{-- Brands --}}
    @include('modules.marketplace.partials.home.brands')

    {{-- Newsletter --}}
    @include('modules.marketplace.partials.home.newsletter')
@endsection
