@if($model->id)
<div>
    @if($model->video->video_status == 'loaded')
        {!! $extraData['video_view'] !!}
    @else
        <div class="text-center" style="background-color: #ffc96559;
padding: 14px;
border: 1px solid orange;">{{__('course::dashboard.lessoncontents.form.types.video')}}</div>
    @endif
</div>
@endif
