<div class="bg-white mb-4 border p-3 p-sm-4">
    <div class="nav aiz-nav-tabs">
        <a href="#tab_default_1" data-toggle="tab"
            class="mr-5 pb-2 fs-16 fw-700 text-reset active show">{{ translate('Description') }}</a>
            
        @if ($detailedProduct->specifications != null && $detailedProduct->specifications != "[]")
            <a href="#specifications_tab" data-toggle="tab" class="mr-5 pb-2 fs-16 fw-700 text-reset">{{ translate('Specifications') }}</a>
        @endif
    
        @if ($detailedProduct->video_links != null && $detailedProduct->video_links!="[]" )
            <a href="#tab_default_4" data-toggle="tab" class="mr-5 pb-2 fs-16 fw-700 text-reset">{{ translate('Useful Links') }}</a>
        @endif
        
        @if ($detailedProduct->video_link != null)
            <a href="#tab_default_2" class="d-none" data-toggle="tab"
                class="mr-5 pb-2 fs-16 fw-700 text-reset">{{ translate('Video') }}</a>
        @endif
        @if ($detailedProduct->pdf != null || !empty($detailedProduct->ies_id))
            <a href="#tab_default_3" data-toggle="tab"
                class="mr-5 pb-2 fs-16 fw-700 text-reset">{{ translate('Downloads') }}</a>
        @endif
    </div>

    <div class="tab-content pt-0">
        <div class="tab-pane fade active show" id="tab_default_1">
            <div class="py-5">
                <div class="mw-100 overflow-hidden text-left aiz-editor-data">
                    <?php echo $detailedProduct->getTranslation('description'); ?>
                </div>
            </div>
        </div>

        <div class="tab-pane fade d-none" id="tab_default_2">
            <div class="py-5">
                <div class="embed-responsive embed-responsive-16by9">
                    @if ($detailedProduct->video_provider == 'youtube' && isset(explode('=', $detailedProduct->video_link)[1]))
                        <iframe class="embed-responsive-item"
                            src="https://www.youtube.com/embed/{{ get_url_params($detailedProduct->video_link, 'v') }}"></iframe>
                    @elseif ($detailedProduct->video_provider == 'dailymotion' && isset(explode('video/', $detailedProduct->video_link)[1]))
                        <iframe class="embed-responsive-item"
                            src="https://www.dailymotion.com/embed/video/{{ explode('video/', $detailedProduct->video_link)[1] }}"></iframe>
                    @elseif ($detailedProduct->video_provider == 'vimeo' && isset(explode('vimeo.com/', $detailedProduct->video_link)[1]))
                        <iframe
                            src="https://player.vimeo.com/video/{{ explode('vimeo.com/', $detailedProduct->video_link)[1] }}"
                            width="500" height="281" frameborder="0" webkitallowfullscreen
                            mozallowfullscreen allowfullscreen></iframe>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="tab-pane fade" id="tab_default_3">
            @php
                $pdfSpecs = json_decode($detailedProduct->pdf, true);
            @endphp
            
            <div class="card shadow-sm mt-4">
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @if (is_array($pdfSpecs) && count($pdfSpecs) > 0)
                            @foreach ($pdfSpecs as $spec)
                                <li class="list-group-item">
                                    <a href="{{ uploaded_asset($spec['id']) }}" target="_blank" rel="noopener noreferrer" class="d-flex align-items-center text-primary text-decoration-none py-2 px-3">
                                        <i class="las la-download fs-24 me-3"></i>
                                        <span class="fw-700">{{ $spec['title'] }}</span>
                                    </a>
                                </li>
                            @endforeach
                        @endif
                        
                        @if(isset($detailedProduct->ies_id) && !empty($detailedProduct->ies_id) )
                            <li class="list-group-item">
                                <a href="{{ uploaded_asset($detailedProduct->ies_id) }}" target="_blank" rel="noopener noreferrer" download="{{$detailedProduct->name}}.ies" class="d-flex align-items-center text-primary text-decoration-none py-2 px-3">
                                    <i class="las la-download fs-24 me-3"></i>
                                    <span class="fw-700">IES</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
            
        @if ($detailedProduct->video_links != null)
            <div class="tab-pane fade" id="tab_default_4">
                <div class="card shadow-sm mt-4">
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @foreach (json_decode($detailedProduct->video_links, true) as $video)
                                <li class="list-group-item">
                                    <a href="#" class="d-flex align-items-center text-primary text-decoration-none py-2 px-3 video-link" 
                                        data-toggle="modal" 
                                        data-target="#videoPlayModal" 
                                        data-video-url="{{ $video['link'] ?? '#' }}" 
                                        data-video-title="{{ $video['title'] ?? 'Video Link' }}">
                                        <i class="las la-play-circle fs-24 me-3"></i>
                                        <span class="fw-700">{{ $video['title'] ?? 'Video Link' }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @if ($detailedProduct->specifications != null && $detailedProduct->specifications != "[]")
            <div class="tab-pane fade" id="specifications_tab">
                <table class="table table-bordered mt-4">
                    <tbody>
                        @foreach (json_decode($detailedProduct->specifications, true) as $spec)
                            <tr>
                                <td>{{ $spec['key'] ?? '' }}</td>
                                <td>{{ $spec['value'] ?? '' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<div class="modal fade" id="videoPlayModal" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="videoModalLabel">Video Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe id="youtube-player" class="embed-responsive-item" src="" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

