@extends('frontend.layouts.app')

@section('content')
    <style>
        @media (max-width: 767px) {
            #flash_deal .flash-deals-baner {
                height: 203px !important;
            }
        }

        .gallery-item {
            position: relative;
            overflow: hidden;
            height: 200px;
        }

        .image-container {
            position: relative;
            width: 100%;
            height: 100%;
            overflow: hidden;
            cursor: pointer;
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: all 0.3s ease-in-out;
            padding: 0 !important;
        }

        .image-container:hover img {
            filter: blur(5px);
            transform: scale(1.05);
        }

        .overlay-info {
            position: absolute;
            inset: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            background: rgba(0, 0, 0, 0.25);
        }

        .image-container:hover .overlay-info {
            opacity: 1;
        }

        .product-info {
            margin: 0;
            color: #fff;
            font-weight: 700;
            font-size: 1.1rem;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.6);
        }

        /* Fullscreen Modal Styles (Already largely correct) */
        /* Make modal fullscreen in Bootstrap 4 */
        #imageModal {
            /* This is the key to preventing the main body scrollbar when modal is open */
            /* You already have `overflow: hidden !important;` for this, but making sure the body rule is also applied correctly */
            overflow: hidden !important;
        }

        /* #imageModal .modal-dialog {
                                                    max-width: 100%;
                                                    margin: 0;
                                                    height: 100vh;
                                                } */

        /* #imageModal .modal-content {
                                                    height: 100%;
                                                    border-radius: 0;
                                                    overflow: hidden !important;
                                                } */

        /* New: Ensure the modal body itself doesn't scroll if content is too big */
        #imageModal .modal-body {
            max-height: 100vh;
            overflow: hidden;
        }

        /* Prevent background (body) from scrolling when modal open */
        body.modal-open {
            overflow: hidden !important;
            padding-right: 0 !important;
            /* Prevents layout shift from scrollbar removal */
        }
    </style>

    @if (get_setting('success_stories') == 1)
        <section class="gallery-section my-5">
            <div class="container">
                <div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-center">
                    <h2 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                        <span class="pb-3">{{ translate('Our Successful Stories') }}</span>
                    </h2>
                </div>
                <div class="row row-cols-2 row-cols-md-4 border-top border-left">
                    @foreach ($success_stories as $highlight)
                        <div class="text-center border-right border-bottom z-1">
                            <div class="gallery-item">
                                <div class="image-container" data-toggle="modal" data-target="#imageModal"
                                    data-image="{{ uploaded_asset($highlight->image) ?? static_asset('assets/img/placeholder.jpg') }}"
                                    data-title="{{ $highlight->name }}">
                                    <img src="{{ uploaded_asset($highlight->image) ?? static_asset('assets/img/placeholder.jpg') }}"
                                        alt="{{ $highlight->name }}"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                    <div class="overlay-info">
                                        <p class="product-info">{{ $highlight->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        {{ $success_stories->links() }}
                    </div>
                </div>
            </div>
        </section>
    @endif

    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel"
        aria-hidden="true">
        {{-- MODIFICATION HERE: Change 'modal-dialog-centered' to 'modal-xl modal-dialog-centered' --}}
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content bg-black border-0">
                <div class="modal-body p-0 d-flex justify-content-center align-items-center">
                    {{-- Keep the image styling to fill the modal content --}}
                    <img id="modalImage" src="" alt="" class="img-fluid"
                        style="width: 100%; height: 100%; max-height: 90vh; object-fit: contain; background-color: black;">
                    <button type="button" class="close position-absolute text-white" data-dismiss="modal"
                        aria-label="Close" style="top: 10px; right: 20px; font-size: 2.5rem; opacity: 0.8; z-index: 1051;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#imageModal').on('show.bs.modal', function(event) {
                var trigger = $(event.relatedTarget);
                var image = trigger.data('image');
                var title = trigger.data('title');
                $('#modalImage').attr('src', image);
                // $('#modalTitle').text(title);
            });
        });
    </script>
@endsection
