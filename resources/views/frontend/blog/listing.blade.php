@extends('frontend.layouts.app')

@section('content')
    <section class="pb-4 pt-5 bg-light">
        <div class="container">
            <!-- Breadcrumb -->
            <div class="row mb-4">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent p-0 mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}" class="text-muted">
                                    {{ translate('Home') }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active text-dark fw-600">
                                {{ translate('Blogs') }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>

            <!-- Page Title with Filter Toggle -->
            <div class="row align-items-center mb-4">

            </div>
            <div class="row">
                <div class="col-lg-12">
                    <form id="search-form" action="" method="GET">
                        <div class="mb-4">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" value="{{ $search }}"
                                    placeholder="{{ translate('Search...') }}" autocomplete="off">
                                <button class="btn btn-primary" type="submit">
                                    <i class="la la-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <!-- Sidebar -->


                <!-- Main Content -->
                <div class="col-lg-12">
                    <!-- Masonry Grid -->
                    <div class="row blog-masonry-grid">
                        @foreach ($blogs as $index => $blog)
                            @php
                                // Masonry pattern logic to match the target design (Image 27d088.png)
                                $patternIndex = $index % 8;

                                // Default values
                                $colClass = 'col-lg-4 col-md-6';
                                $imgHeight = 'blog-card-img-medium';
                                $cardType = 'medium';
                                $isQuoteCard = false;

                                if ($patternIndex == 0) {
                                    // #1 - Top Left Large Image (8/12 width, Tall)
                                    $colClass = 'col-lg-8 col-md-12';
                                    $imgHeight = 'blog-card-img-xlarge'; // Tall Image
                                    $cardType = 'xlarge';
                                } elseif ($patternIndex == 1) {
                                    // #2 - Top Right Small Quote Card (4/12 width)
                                    $colClass = 'col-lg-4 col-md-6';
                                    $imgHeight = '';
                                    $cardType = 'quote';
                                    $isQuoteCard = true;
                                } elseif ($patternIndex == 2 || $patternIndex == 3 || $patternIndex == 4) {
                                    // #3, #4, #5 - Three regular medium/small image cards (4/12 width each, 3*4=12)
                                    $colClass = 'col-lg-4 col-md-6';
                                    $imgHeight = 'blog-card-img-small';
                                    $cardType = 'small';
                                } elseif ($patternIndex == 5) {
                                    // #6 - Middle Left Wide Quote Card (8/12 width)
                                    $colClass = 'col-lg-8 col-md-12';
                                    $imgHeight = '';
                                    $cardType = 'quote';
                                    $isQuoteCard = true;
                                } elseif ($patternIndex == 6) {
                                    // #7 - Middle Right Image (4/12 width, next to the wide quote)
                                    $colClass = 'col-lg-4 col-md-6';
                                    $imgHeight = 'blog-card-img-medium';
                                    $cardType = 'medium';
                                } elseif ($patternIndex == 7) {
                                    // $patternIndex == 7
                                    // #8 - Bottom Left Image (4/12 width)
                                    $colClass = 'col-lg-12 col-md-6';
                                    $imgHeight = 'blog-card-img-medium';
                                    $cardType = 'medium';
                                }
                            @endphp

                            <div class="{{ $colClass }} mb-4 blog-card-col"
                                style="animation-delay: {{ ($index % 8) * 0.1 }}s;">
                                @if ($cardType == 'quote')
                                    <!-- Quote Card with same collapsed/hover behavior as image cards -->
                                    <div class="blog-card blog-card-quote h-100 position-relative">
                                        <div class="quote-top p-4">
                                            <h3 class="quote-top-title">
                                                <i class="las la-quote-left opacity-75"
                                                    style="font-size: 40px; color: #162052;"></i>
                                                <a href="{{ url('blog') . '/' . $blog->slug }}"
                                                    class="text-decoration-none">{{ $blog->title }}</a>
                                            </h3>
                                        </div>

                                        <div class="quote-overlay"></div>

                                        <div class="blog-card-content">
                                            <h3 class="blog-card-title">
                                                <a href="{{ url('blog') . '/' . $blog->slug }}"
                                                    class="text-white text-decoration-none">{{ $blog->title }}</a>
                                            </h3>

                                            @if (!empty($blog->short_description))
                                                <p class="blog-card-desc">{{ Str::limit($blog->short_description, 150) }}
                                                </p>
                                            @endif

                                            <div class="blog-card-meta d-flex justify-content-between align-items-center">
                                                <a href="{{ url('blog') . '/' . $blog->slug }}"
                                                    style="background-color: white;"
                                                    class="blog-card-badge bg-outline-primary text-primary">Show more</a>

                                            </div>
                                        </div>
                                        <div class="share-container" data-url="{{ url('blog') . '/' . $blog->slug }}">
                                            <button type="button" class="share-toggle" aria-label="Share">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="40"
                                                    height="40" viewBox="0 0 48 48">
                                                    <circle cx="24" cy="24" r="24" fill="#ffff" />
                                                    <g fill="none" stroke="#2557aa" stroke-width="2.5"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <line x1="20" y1="24" x2="30"
                                                            y2="18" />
                                                        <line x1="20" y1="24" x2="30"
                                                            y2="30" />
                                                    </g>
                                                    <circle cx="30" cy="18" r="3" fill="#2557aa" />
                                                    <circle cx="30" cy="30" r="3" fill="#2557aa" />
                                                    <circle cx="20" cy="24" r="3" fill="#2557aa" />
                                                </svg>
                                            </button>
                                            <div class="share-menu">
                                                <a target="_blank" rel="noopener"
                                                    href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url('blog') . '/' . $blog->slug) }}">f</a>
                                                <a target="_blank" rel="noopener"
                                                    href="https://twitter.com/intent/tweet?url={{ urlencode(url('blog') . '/' . $blog->slug) }}&text={{ urlencode($blog->title) }}">x</a>
                                                <a target="_blank" rel="noopener"
                                                    href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url('blog') . '/' . $blog->slug) }}&title={{ urlencode($blog->title) }}">in</a>
                                                <a target="_blank" rel="noopener"
                                                    href="https://pinterest.com/pin/create/button/?url={{ urlencode(url('blog') . '/' . $blog->slug) }}&media={{ urlencode(uploaded_asset($blog->banner)) }}">p</a>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <!-- Image Card -->
                                    <div class="blog-card blog-card-image h-100">
                                        <div class="blog-card-link d-block position-relative overflow-hidden rounded">
                                            <div class="blog-card-img-wrapper {{ $imgHeight }}">
                                                <img src="{{ uploaded_asset($blog->banner) }}" alt="{{ $blog->title }} "
                                                    class="blog-card-img w-100 h-100">
                                                <div class="blog-card-overlay"></div>
                                            </div>

                                            <div class="blog-card-content">

                                                <h3
                                                    class="blog-card-title {{ $imgHeight == 'blog-card-img-small' ? 'blog-card-title-small' : '' }}">
                                                    <a href="{{ url('blog') . '/' . $blog->slug }}"
                                                        class="text-white text-decoration-none">{{ $blog->title }}</a>
                                                </h3>

                                                {{-- Always include short description (will be hidden in collapsed state and revealed on hover) --}}
                                                @if (!empty($blog->short_description))
                                                    <p class="blog-card-desc">
                                                        {{ Str::limit($blog->short_description, 150) }}</p>
                                                @endif


                                                <div
                                                    class="blog-card-meta d-flex justify-content-between align-items-center">
                                                    @if ($blog->category != null)
                                                        <a href="{{ url('blog') . '/' . $blog->slug }}"
                                                            class="blog-card-badge bg-primary text-white">Show more</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="share-container" data-url="{{ url('blog') . '/' . $blog->slug }}">
                                            <button type="button" class="share-toggle" aria-label="Share">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="40"
                                                    height="40" viewBox="0 0 48 48">
                                                    <circle cx="24" cy="24" r="24"
                                                        fill="#2557aa" />
                                                    <g fill="none" stroke="#FFFFFF" stroke-width="2.5"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <line x1="20" y1="24" x2="30"
                                                            y2="18" />
                                                        <line x1="20" y1="24" x2="30"
                                                            y2="30" />
                                                    </g>
                                                    <circle cx="30" cy="18" r="3"
                                                        fill="#FFFFFF" />
                                                    <circle cx="30" cy="30" r="3"
                                                        fill="#FFFFFF" />
                                                    <circle cx="20" cy="24" r="3"
                                                        fill="#FFFFFF" />
                                                </svg>
                                            </button>
                                            <div class="share-menu">
                                                <a target="_blank" rel="noopener"
                                                    href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url('blog') . '/' . $blog->slug) }}">f</a>
                                                <a target="_blank" rel="noopener"
                                                    href="https://twitter.com/intent/tweet?url={{ urlencode(url('blog') . '/' . $blog->slug) }}&text={{ urlencode($blog->title) }}">x</a>
                                                <a target="_blank" rel="noopener"
                                                    href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url('blog') . '/' . $blog->slug) }}&title={{ urlencode($blog->title) }}">in</a>
                                                <a target="_blank" rel="noopener"
                                                    href="https://pinterest.com/pin/create/button/?url={{ urlencode(url('blog') . '/' . $blog->slug) }}&media={{ urlencode(uploaded_asset($blog->banner)) }}">p</a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-5">
                        {{ $blogs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* Masonry item entrance */
        .blog-card-col {
            opacity: 0;
            animation: fadeInUp 0.6s ease forwards;
            padding: 12px;
            /* equal gutter spacing */
            display: flex;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Masonry Grid Alignment */
        .blog-masonry-grid {
            display: flex;
            flex-wrap: wrap;
            margin: -12px;
            /* match column padding for perfect gutters */
        }

        .blog-card {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .08);
            transition: all .4s cubic-bezier(.25, .46, .45, .94);
            display: flex;
            flex-direction: column;
            width: 100%;
            height: 100%;
        }

        .blog-card-link {
            text-decoration: none;
            display: block;
        }

        .blog-card-img-wrapper {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
        }

        .blog-card-img {
            object-fit: cover;
            transition: transform .6s cubic-bezier(.25, .46, .45, .94);
            width: 100%;
            height: 100%;
        }

        .blog-card:hover .blog-card-img {
            transform: scale(1.08);
        }

        /* Image heights (kept proportional for all breakpoints) */
        .blog-card-img-small {
            height: 220px;
        }

        .blog-card-img-medium {
            height: 280px;
        }

        .blog-card-img-large {
            height: 380px;
        }

        .blog-card-img-xlarge {
            height: 450px;
        }

        @media (max-width: 768px) {

            .blog-card-img-small,
            .blog-card-img-medium,
            .blog-card-img-large,
            .blog-card-img-xlarge {
                height: 250px;
            }

            .blog-card-col {
                padding: 8px;
            }

            .blog-masonry-grid {
                margin: -8px;
            }
        }

        /* Overlay + content container */
        .blog-card-overlay {
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            background: rgba(20, 54, 93, .75);
            transform: translateY(calc(100% - 72px)); /* leave a fixed 72px footer visible */
            transition: transform .45s cubic-bezier(.22, .8, .2, 1);
            z-index: 1;
            border-radius: 12px;
        }

        .blog-card:hover .blog-card-overlay {
            transform: translateY(0);
        }

        .blog-card-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px 24px;
            color: #fff;
            z-index: 2;
            height: 72px; /* reduced footer height */
            overflow: hidden;
            transition: all .45s cubic-bezier(.22, .8, .2, 1);
        }

        .blog-card:hover .blog-card-content {
            height: 170px;
            padding: 24px 28px;
        }

        /* Title, description, and badge consistency */
        .blog-card-title {
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            line-height: 1.4;
            margin-bottom: 12px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .blog-card-title-small {
            font-size: 16px;
            margin-bottom: 10px;
            margin-top: 10px;
            -webkit-line-clamp: 1; /* small cards: single line */
        }

        /* Reserve space for always-visible share button so titles don't overlap */
        .blog-card-title,
        .blog-card-title-small,
        .quote-top-title {
            padding-right: 56px; /* 40px icon + 16px gap */
        }

        .blog-card-desc {
            font-size: 14px;
            color: rgba(255, 255, 255, .9);
            line-height: 1.6;
            margin-bottom: 12px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            opacity: 0;
            transform: translateY(15px);
            transition: all .35s ease;
        }

        .blog-card:hover .blog-card-desc {
            opacity: 1;
            transform: translateY(0);
            transition-delay: .1s;
        }

        .blog-card-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            opacity: 0;
            transform: translateY(10px);
            transition: all .35s ease;
            gap: 12px;
        }

        .blog-card:hover .blog-card-meta {
            opacity: 1;
            transform: translateY(0);
            transition-delay: .1s;
        }

        .blog-card-badge {
            display: inline-block;
            background: rgba(255, 255, 255, .2);
            backdrop-filter: blur(10px);
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        /* Quote card variant alignment */
        .blog-card-quote {
            background-color: #fff;
            border-radius: 12px;
            min-height: 280px;
            transition: all .4s ease;
            padding: 0;
        }

        .quote-top {
            position: relative;
            z-index: 0;
            min-height: 180px;
            padding: 24px;

        }

        .quote-top-title {
            font-size: 28px;
            font-weight: 700;
            color: #14365d;
            margin: 8px 0 0;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
            transition: opacity .35s ease;
        }

        @media (max-width: 768px) {
            .quote-top {
                min-height: 140px;
            }
            .quote-top-title {
                font-size: 22px;
                -webkit-line-clamp: 3;
            }
        }

        .quote-overlay {
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 72px; /* match collapsed footer height */
            background: #2557aa;
            transition: height .45s cubic-bezier(.22, .8, .2, 1);
            z-index: 1;
            /* Only round bottom corners in collapsed state to match card edges */
            border-radius: 0 0 12px 12px;
        }

        .blog-card-quote:hover .quote-overlay {
            height: 100%;
            /* When expanded, round all corners to blend with parent card */
            border-radius: 12px;
        }

        .blog-card-quote .blog-card-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            color: #fff;
            /* Tighter padding so one-line title fits within 72px */
            padding: 16px 20px;
            /* Match the collapsed blue footer height to avoid cutting text */
            height: 72px;
            transition: all .45s cubic-bezier(.22, .8, .2, 1);
            /* Vertically center title in collapsed state */
            display: flex;
            align-items: center;
            /* Ensure content always sits above blue overlay */
            z-index: 2;
            box-sizing: border-box;


        }

        /* Keep both top quote and footer overlay visible; footer expands on hover via height */

        /* Quote card footer: left-align title and reserve space to avoid share icon */
        .blog-card-quote .blog-card-content .blog-card-title {
            text-align: left;
            margin-left: 0;
            margin-right: 0;
            /* Reserve space for 40px share button + gap */
            padding-right: 56px;
            /* Collapsed: single-line with ellipsis to avoid clipping */
            display: block; /* reset -webkit-box from global */
            -webkit-line-clamp: unset;
            -webkit-box-orient: unset;
            width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 16px;
            line-height: 1.35;
            margin-bottom: 0;
        }

        /* Quote card hover: make overlay full height and move content to top-left */
        .blog-card-quote:hover .blog-card-content {
            top: 0;
            bottom: 0;
            height: 100%;
            padding: 24px;
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* top: title+desc, bottom: CTA */
            align-items: flex-start;
            text-align: left;
        }

        .blog-card-quote:hover .blog-card-content .blog-card-title {
            text-align: left;
            max-width: 100%;
            padding-right: 0;
            /* Allow multi-line wrapping on hover */
            white-space: normal;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3; /* allow more lines like reference */
        }

        /* Ensure CTA block sits at bottom inside overlay on hover */
        .blog-card-quote:hover .blog-card-meta {
            margin-top: auto;
        }

        .blog-card-quote .blog-card-meta {
            margin-bottom: 8px;
        }

        /* Share button alignment */
        .share-container {
            position: absolute;
            right: 16px;
            bottom: 16px; /* centered in 72px footer for 40px icon */
            z-index: 3;
        }

        .share-toggle {
            background: transparent;
            border: 0;
            padding: 0;
            line-height: 0;
            cursor: pointer;
        }

        .share-menu {
            position: absolute;
            bottom: 48px;
            right: 0;
            display: none;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, .95);
            color: #14365d;
            border-radius: 24px;
            padding: 6px 10px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, .15);
            z-index: 10;
        }

        .share-container.open .share-menu {
            display: flex;
        }

        .share-menu a {
            color: #14365d;
            text-decoration: none;
            font-weight: 700;
            text-transform: lowercase;
            padding: 4px 6px;
        }




    </style>


@endsection

@section('script')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            // Share toggle logic only
            document.querySelectorAll('.share-toggle').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const container = this.closest('.share-container');
                    if (container) {
                        document.querySelectorAll('.share-container.open').forEach(el => {
                            if (el !== container) el.classList.remove('open');
                        });
                        container.classList.toggle('open');
                    }
                });
            });
            document.addEventListener('click', function(e) {
                document.querySelectorAll('.share-container.open').forEach(el => {
                    if (!el.contains(e.target)) el.classList.remove('open');
                });
            });
        });
    </script>
@endsection
