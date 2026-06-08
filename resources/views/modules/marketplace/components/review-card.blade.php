<div class="mp-review">
    <div class="mp-review__stars">{{ renderStarRating($review->rating) }}</div>
    <p style="margin:0.5rem 0;font-size:0.9rem;">{{ $review->comment }}</p>
    <small style="color:var(--mp-muted);">{{ $review->user->name ?? translate('Customer') }} · {{ $review->created_at->diffForHumans() }}</small>
</div>
