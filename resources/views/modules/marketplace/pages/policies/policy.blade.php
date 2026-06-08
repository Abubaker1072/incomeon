@extends('modules.marketplace.layouts.app')

@section('meta_title', ($page->getTranslation('title') ?? translate('Policy')) . ' | ' . get_setting('website_name'))

@section('content')
<section class="mp-section mp-section--white">
    <div class="mp-container mp-policy-page">
        <h1 class="mp-policy-page__title">{{ $page->getTranslation('title') }}</h1>
        <div class="mp-policy-page__content">
            {!! $page->getTranslation('content') !!}
        </div>
    </div>
</section>
@endsection
