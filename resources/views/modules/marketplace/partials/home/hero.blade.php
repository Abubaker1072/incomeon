@php
    $lang = $lang ?? get_system_language()->code;
    $slider_images = get_setting('home_slider_images', null, $lang);
    $sliders = $slider_images ? get_slider_images(json_decode($slider_images, true)) : collect();
    $slider_links = json_decode(get_setting('home_slider_links', null, $lang), true) ?? [];

    $cover_image = static_asset('assets/modules/marketplace/img/hero-cover.png');
    $side_slider = $sliders->count() > 1 ? $sliders[1] : ($sliders->first() ?? null);
    $side_image = $side_slider ? my_asset($side_slider->file_name) : $cover_image;
    $main_link = $slider_links[0] ?? route('search');
    $side_link = $slider_links[1] ?? ($slider_links[0] ?? route('search'));
@endphp
<section class="mp-cover mp-animate">
    <div class="mp-container">
        <div class="mp-cover__grid">
            <a href="{{ $main_link }}" class="mp-cover-card mp-cover-card--main">
                <div class="mp-cover-card__content">
                    <h2>{{ get_setting('site_motto') ?: translate('Discover quality products from trusted sellers') }}</h2>
                    <span class="mp-cover-card__cta">{{ translate('Shop perfect presents') }} &rarr;</span>
                </div>
                <div class="mp-cover-card__media">
                    <img src="{{ $cover_image }}" alt="{{ get_setting('website_name') }}">
                </div>
            </a>
            <a href="{{ $side_link }}" class="mp-cover-card mp-cover-card--side">
                <img src="{{ $side_image }}" alt="{{ translate('Featured collection') }}" class="mp-cover-card__bg">
                <div class="mp-cover-card__overlay">
                    <h3>{{ translate('The best LED solutions for every space') }}</h3>
                    <span class="mp-cover-card__cta">{{ translate('Shop now') }} &rarr;</span>
                </div>
            </a>
        </div>
    </div>
</section>
