<div class="{{ $wrapperClass }}">
    <div class="course-block">
        <div class="img-block">
            <img class="img-fluid"
                src="{{ asset($course->image) }}">
        </div>
        <div class="course-content">
            <h3><a class="title"
                    href="{{ route('frontend.courses.show',$course->slug) }}">{{ $course->title }}</a></h3>
            <div class="d-flex align-items-center justify-content-between">
                <a class="tutor-name"
                    href="{{ route('frontend.trainers.show',$course->trainer->id) }}">{{ $course->trainer->name }}</a>
                <span class="course-users"><i class="fas fa-users"></i> {{ $course->order_course_count }}</span>
            </div>
            <div class="star-rating"
                data-rating="{{ $course->stars}}"></div>
            <div class="d-flex align-items-center justify-content-between">
                <span class="price">{{ $course->price}} {{ __('KWD') }}</span>

                @if ($course->subscribed()->count() <= 0)
                    <a
                    href="{{route('frontend.cart.add',['course',$course->slug])}}"
                    class="btn theme-btn2 add-cart">{{ __('Add To Cart') }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
