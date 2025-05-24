{!! field()->langNavTabs() !!}
<div class="tab-content">
  @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
  <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}"
    id="first_{{$code}}">
    {!! field()->text('title['.$code.']',
    __('course::dashboard.lessoncontents.form.title').'-'.$code ,
    $model->getTranslation('title' , $code),
    ['data-name' => 'title.'.$code]
    ) !!}
  </div>
  @endforeach
</div>
{!! field()->select('lesson_id',__('course::dashboard.lessoncontents.form.lessons'),$extraData['courses']) !!}

{!! field()->number('order', __('course::dashboard.lessoncontents.form.order')) !!}

{!! field()->file('video', __('course::dashboard.lessoncontents.form.types.video')) !!}



@if($model->type=='video')
@include('course::dashboard.lessoncontents.forms.video')
@endif

<input type="hidden"
  name="type"
  value="video">
