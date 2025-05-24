{!! field()->langNavTabs() !!}

<div class="tab-content">
  @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
  <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}"
    id="first_{{$code}}">
    {!! field()->text('title['.$code.']',
    __('course::dashboard.courses.form.title').'-'.$code ,
    $model->getTranslation('title' , $code),
    ['data-name' => 'title.'.$code]
    ) !!}

    {!! field()->textarea('desc['.$code.']',
    __('course::dashboard.courses.form.description').'-'.$code ,
    $model->getTranslation('title' , $code),
    ['data-name' => 'desc.'.$code,'class'=>'form-control']
    ) !!}

  </div>
  @endforeach
</div>

{!! field()->text('period', __('course::dashboard.courses.form.period').'/ Hrs') !!}
{!! field()->number('price', __('course::dashboard.courses.form.price'),null,
['data-name' =>'price','class'=>'form-control','step'=>'0.1']) !!}


{!!
field()->select('instructor_id',__('course::dashboard.courses.form.instructors'),$extraData['instructors'],
) !!}

{!!
field()->select('categories[]',__('course::dashboard.courses.form.tabs.categories'),$extraData['categories'],$model->categories,['multiple'=>'multiple','data-name'=>'categories']
) !!}

{!! field()->file('intro_video', __('course::dashboard.courses.form.intro_video')) !!}
@if($model->id)
<div>
  @if($model?->video?->video_status == 'loaded')
  {!! $extraData['video_view'] !!}
  @else
  <div class="text-center"
    style="background-color: #ffc96559;
padding: 14px;
border: 1px solid orange;">{{__('course::dashboard.videos.loading')}}</div>
  @endif
</div>
@endif


{!! field()->file('image',
__('course::dashboard.courses.form.image'),$model->id?$model->getFirstMediaUrl('images'):null) !!}




{!! field()->checkBox('status', __('course::dashboard.levels.form.status')) !!}
@if ($model->trashed())
{!! field()->checkBox('trash_restore', __('course::dashboard.levels.form.restore')) !!}
@endif





@push('scripts')
<script type="text/javascript">
  $(function() {
        $('#jstree').jstree();

        $('#jstree').on("changed.jstree", function(e, data) {
            $('#root_category').val(data.selected);
        });
    });
</script>
@endpush
