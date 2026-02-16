<div>
    <div class="form-group row">
        <label class="col-md-3 col-form-label">{{translate('Video Thumbnail Image')}} <small></small></label>
        <div class="col-md-8">
            <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="false">
                <div class="input-group-prepend">
                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                </div>
                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                <input type="hidden" name="video_thumbnail" class="selected-files" value="{{$videoThumbnailId}}">
            </div>
            <div class="file-preview box sm">
            </div>
            <small class="text-muted">{{translate('This image is visible in site product page.')}}</small>
        </div>
    </div>
    <div class="form-group row" id="localVideo">
        <label class="col-md-3 col-form-label" for="video_provider">{{translate('Local Video')}} <small>(16:9)</small></label>
        <div class="col-md-8">
            <div class="input-group" data-toggle="aizuploader" data-type="video" data-multiple="false">
                <div class="input-group-prepend">
                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                </div>
                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                <input type="hidden" name="local_video_id" class="selected-files" value="{{$localVideoId}}">
            </div>
            <div class="file-preview box sm">
            </div>
            <small class="text-muted">{{translate('Use 16:9 ratio Video.')}}</small>
        </div>
    </div>
</div>