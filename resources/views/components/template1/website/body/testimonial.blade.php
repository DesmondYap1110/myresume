<section class="resume-section p-3 p-lg-5 d-flex flex-column" id="reviews">
    <div class="row my-auto">
        <div class="col-12">
            <h2 class="text-center">What Clients Say</h2>
            <div class="mb-5 heading-border"></div>
        </div>
    </div>
    <div class="row my-auto">
        @foreach($testimonial as $review)
        <div class="col-md-4 col-sm-6 mb-4">
            <blockquote class="card review-card mx-0 p-4 h-100">
                <div class="review-stars" aria-label="{{ $review->rating }} out of 5 stars">
                    @for($i = 1; $i <= 5; $i++)
                    <i class="fa fa-star {{ $i <= $review->rating ? 'is-on' : '' }}"></i>
                    @endfor
                </div>
                <p class="review-text">"{{ $review->message }}"</p>
                <footer class="review-by">
                    @if($review->image)
                    <img src="{{ $review->image }}" alt="{{ $review->name }}">
                    @else
                    <span class="review-initials">{{ $review->initials() }}</span>
                    @endif
                    <span>
                        <b>{{ $review->name }}</b>
                        @if($review->position)<small>{{ $review->position }}</small>@endif
                    </span>
                </footer>
            </blockquote>
        </div>
        @endforeach
    </div>
</section>
