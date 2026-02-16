<style>
/* Additional CSS for video functionality */
.video-container {
    background: #000;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 400px;
}

.video-wrapper {
    max-width: 100%;
    margin: 0 auto;
}

.video-thumbnail-wrapper {
    display: inline-block;
}

.video-play-icon {
    pointer-events: none;
}

/* Ensure videos maintain aspect ratio */
@media (max-width: 768px) {
    .video-wrapper {
        height: 250px !important;
    }
    
    .video-container {
        min-height: 250px;
    }
}


</style>

<div class="sticky-top z-3 row gutters-10">
    @php
        $photos = $detailedProduct->photos != null ? explode(',', $detailedProduct->photos) : [];
        $videos = $detailedProduct->video_link != null ? [$detailedProduct->video_link] : [];
        $thumbnail = $detailedProduct->video_thumbnail;

       


       
    @endphp

    <!-- Gallery Images/Videos -->
    <div class="col-12">
        <div class="aiz-carousel product-gallery arrow-inactive-transparent arrow-lg-none"
            data-nav-for='.product-gallery-thumb' data-fade='true' data-auto-height='true' data-arrows='true'>
            
            {{-- Videos First (Priority) --}}
           @foreach ($videos as $key => $video)
   
    <div class="carousel-box rounded-0" data-type="video">
    <div class="video-container position-relative" style="width: 100%; height: 554px; background-color: #000;">
    <div class="video-thumbnail-wrapper position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" 
         style="cursor: pointer; background-size: cover; background-position: center;">
        <div class="play-button-container d-flex align-items-center justify-content-center" 
             style="width: 80px; height: 80px; background-color: rgba(0, 0, 0, 0.7); border-radius: 50%; backdrop-filter: blur(4px);">
            <svg xmlns="http://www.w3.org/2000/svg" 
                 width="40" 
                 height="40" 
                 fill="white" 
                 viewBox="0 0 16 16"
                 style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="M6.271 5.055a.5.5 0 0 1 .52-.069L11 7.055a.5.5 0 0 1 0 .89L6.791 9.914a.5.5 0 0 1-.791-.407V5.5a.5.5 0 0 1 .271-.445z"/>
            </svg>
        </div>
    </div>
    <video
        class="position-absolute top-0 start-0 w-100 h-100 d-none"
        style="object-fit: obtain; z-index: 1;"
        controls
        controlsList="nodownload"
        preload="metadata"
        data-src="{{ $video }}">
        <source src="{{ $video }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</div>
</div>
@endforeach


            {{-- Stock Images (Existing functionality) --}}
            @if ($detailedProduct->digital == 0)
                @foreach ($detailedProduct->stocks as $key => $stock)
                    @if ($stock->image != null)
                        <div class="carousel-box img-zoom rounded-0" data-type="image">
                            <img class="img-fluid h-auto lazyload mx-auto"
                                src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                data-src="{{ uploaded_asset($stock->image) }}"
                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                        </div>
                    @endif
                @endforeach
            @endif

            {{-- Product Photos (Existing functionality) --}}
            @foreach ($photos as $key => $photo)
                <div class="carousel-box img-zoom rounded-0" data-type="image">
                    <img class="img-fluid h-auto lazyload mx-auto"
                        src="{{ static_asset('assets/img/placeholder.jpg') }}" 
                        data-src="{{ uploaded_asset($photo) }}"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                </div>
            @endforeach

        </div>
    </div>

    <!-- Thumbnail Images/Videos -->
    <div class="col-12 mt-3 d-none d-lg-block">
        <div class="aiz-carousel half-outside-arrow product-gallery-thumb" data-items='7' data-nav-for='.product-gallery'
            data-focus-select='true' data-arrows='true' data-vertical='false' data-auto-height='true'>

            {{-- Video Thumbnails First (Priority) --}}
            @foreach ($videos as $key => $video)
                <div class="carousel-box c-pointer rounded-0" data-type="video">
                    @php
                            $videoType = 'direct';
                          
                    @endphp

                    <div class="video-thumbnail-wrapper position-relative">
                        <img class="lazyload mw-100 size-60px mx-auto border p-1"
                            src="{{ static_asset('assets/img/placeholder.jpg') }}"
                            data-src="{{ $thumbnail }}"
                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                        {{-- Video play icon overlay --}}
                        <div class="video-play-icon position-absolute" 
                            style="top: 50%; left: 50%; transform: translate(-50%, -50%); 
                                   color: white; background: rgba(0,0,0,0.7); 
                                   border-radius: 50%; width: 20px; height: 20px; 
                                   display: flex; align-items: center; justify-content: center; 
                                   font-size: 10px;">
                            <i class="fas fa-play"></i>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Stock Image Thumbnails (Existing functionality) --}}
            @if ($detailedProduct->digital == 0)
                @foreach ($detailedProduct->stocks as $key => $stock)
                    @if ($stock->image != null)
                        <div class="carousel-box c-pointer rounded-0" data-variation="{{ $stock->variant }}" data-type="image">
                            <img class="lazyload mw-100 size-60px mx-auto border p-1"
                                src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                data-src="{{ uploaded_asset($stock->image) }}"
                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                        </div>
                    @endif
                @endforeach
            @endif

            {{-- Product Photo Thumbnails (Existing functionality) --}}
            @foreach ($photos as $key => $photo)
                <div class="carousel-box c-pointer rounded-0" data-type="image">
                    <img class="lazyload mw-100 size-60px mx-auto border p-1"
                        src="{{ static_asset('assets/img/placeholder.jpg') }}" 
                        data-src="{{ uploaded_asset($photo) }}"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                </div>
            @endforeach

        </div>
    </div>
</div>
 <script>
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.getElementById('videoPlayer');
            const thumbnailWrapper = document.getElementById('thumbnailWrapper');
            const playButton = document.getElementById('playButton');

            // Function to show thumbnail
            function showThumbnail() {
                thumbnailWrapper.classList.remove('hidden');
            }

            // Function to hide thumbnail
            function hideThumbnail() {
                thumbnailWrapper.classList.add('hidden');
            }

            // Click event on thumbnail to play video
            thumbnailWrapper.addEventListener('click', function() {
                video.play();
            });

            // Video event listeners
            video.addEventListener('play', function() {
                hideThumbnail();
            });

            video.addEventListener('pause', function() {
                showThumbnail();
            });

            video.addEventListener('ended', function() {
                showThumbnail();
            });

            // Optional: Handle loading states
            video.addEventListener('loadstart', function() {
                console.log('Video loading started');
            });

            video.addEventListener('canplay', function() {
                console.log('Video can start playing');
            });

            // Optional: Handle errors
            video.addEventListener('error', function() {
                console.error('Video error occurred');
                showThumbnail();
            });
        });
    </script>
<script>
    // document.querySelectorAll('.video-thumbnail-wrapper').forEach(thumbnail => {
    //     thumbnail.addEventListener('click', function () {
    //         const container = this.parentElement;
    //         const video = container.querySelector('video');
    //         this.classList.add('d-none');
    //         video.classList.remove('d-none');
    //         video.play();
    //     });
    // });

    document.querySelectorAll('.video-thumbnail-wrapper').forEach(thumbnail => {
    thumbnail.addEventListener('click', function () {
        const container = this.closest('.video-container');
        const video = container.querySelector('video');
        
        // Load video source if not already loaded
        if (video.getAttribute('data-src')) {
            video.src = video.getAttribute('data-src');
            video.removeAttribute('data-src');
        }
        
        // Hide thumbnail and show video
        this.style.display = 'none';
        video.classList.remove('d-none');
        
        // Play video
        video.play().catch(error => {
            console.error('Error playing video:', error);
        });
    });
});

// Optional: Show thumbnail again when video ends
document.querySelectorAll('video').forEach(video => {
    video.addEventListener('ended', function() {
        const container = this.closest('.video-container');
        const thumbnail = container.querySelector('.video-thumbnail-wrapper');
        
        this.classList.add('d-none');
        thumbnail.style.display = 'flex';
        this.currentTime = 0; // Reset video to beginning
    });
});
</script>

