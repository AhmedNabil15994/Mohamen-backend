<div class="description-box mb-30">
    <h3>{{ __('Course Content ') }}</h3>
    <div class="course-curriculum-box mt-20">
        <div class="course-curriculum-accordion">

            @if (count($course->subscribed) > 0)
            @if ($course->is_live == 0)
            @include('course::frontend.courses.show-partials.course-content')
            @else
            <a href="{{ route('course.live',$course->id) }}">{{ __('Course is Live') }}</a>
            @endif
            @else
            @include('course::frontend.courses.show-partials.subscriped-link')
            @endif
        </div>
    </div>
</div>
