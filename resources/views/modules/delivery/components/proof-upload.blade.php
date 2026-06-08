<div class="dlv-proof-upload">
    <h4 class="dlv-proof-upload__title">
        <i class="las la-camera"></i> {{ translate('Delivery Proof Upload') }}
    </h4>
    <p class="dlv-proof-upload__hint">{{ translate('Upload a photo as proof of delivery (signature, package at doorstep, etc.)') }}</p>

    <form action="{{ route('delivery.upload-proof') }}" method="POST" enctype="multipart/form-data" class="dlv-proof-upload__form">
        @csrf
        <input type="hidden" name="order_id" value="{{ $order->id }}">

        <label class="dlv-proof-upload__dropzone" for="proof_image">
            <input type="file" name="proof_image" id="proof_image" accept="image/*" required class="d-none" data-preview="proof-preview">
            <i class="las la-cloud-upload-alt"></i>
            <span>{{ translate('Tap to upload photo') }}</span>
            <small>{{ translate('JPG, PNG up to 5MB') }}</small>
        </label>

        <div class="dlv-proof-upload__preview" id="proof-preview" style="display:none;">
            <img src="" alt="{{ translate('Preview') }}">
        </div>

        <button type="submit" class="dlv-btn dlv-btn--primary w-100 mt-3">
            <i class="las la-upload"></i> {{ translate('Upload Proof') }}
        </button>
    </form>

    @php
        $proofHistory = $histories->filter(function ($h) {
            return !empty($h->proof_image);
        })->last();
    @endphp
    @if ($proofHistory)
        <div class="dlv-proof-upload__existing mt-3">
            <span>{{ translate('Uploaded proof') }}</span>
            <img src="{{ uploaded_asset($proofHistory->proof_image) }}" alt="{{ translate('Delivery proof') }}">
        </div>
    @endif
</div>
