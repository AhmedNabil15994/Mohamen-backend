@foreach($course->lessons as $key => $lesson)
<div class="lecture-group-wrapper">
    <div class="lecture-group-title d-flex collapsed"
        data-toggle="collapse"
        data-target="#collapse6"
        aria-expanded="false">
        <div class="title flex-1">
            {{ $lesson->title }}
        </div>
    </div>
    <div id="collapse6"
        class="lecture-list collapse show">
        <ul>
            @foreach($lesson->lessonContents as $key => $lessonContent)
            @if($lessonContent->type=='video')
            <li data-toggle="modal"
                data-target="#VideoPreviewModal"
                class="lecture has-preview lesson_video video-btn"
                data-lesson-content-id="{{ $course->video->id }}"
                data-video-id="{{ $lessonContent->video->video_link}}">
                <span class="lecture-title"> {{ $lessonContent->title }}</span>
                <span class="lecture-time"> {{ $lessonContent->video->video_minutes
                    }} </span>
            </li>
            @elseif($lessonContent->type=='exam')
            <li>


                <a class="btn btn-info"
                    href="{{ route('frontend.exams.show',$lessonContent->exam->id) }}">
                    <span class="lecture-title"> {{ $lessonContent->title }}</span>

                </a>
            </li>
            @endif
            @endforeach
        </ul>
    </div>
</div>
@endforeach
