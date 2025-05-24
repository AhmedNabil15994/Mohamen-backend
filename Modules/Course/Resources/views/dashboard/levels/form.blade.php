@inject('exams', 'Modules\Exam\Entities\Exam')

{!! field()->langNavTabs() !!}
<div class="tab-content">
    @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
    <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}"
        id="first_{{$code}}">
        {!! field()->text('title['.$code.']',
        __('course::dashboard.levels.form.title').'-'.$code ,
        $model->getTranslation('title' , $code),
        ['data-name' => 'title.'.$code]
        ) !!}
        {!! field()->text('short_desc['.$code.']',
        __('course::dashboard.levels.form.short_desc').'-'.$code ,
        $model->getTranslation('short_desc' , $code),
        ['data-name' => 'short_desc.'.$code]
        ) !!}
        {!! field()->ckEditor5('desc['.$code.']',
        __('course::dashboard.levels.form.desc').'-'.$code ,
        $model->getTranslation('desc' , $code),
        ['data-name' => 'desc.'.$code]
        ) !!}

        {!! field()->ckEditor5('requirements['.$code.']',
        __('course::dashboard.levels.form.requirements').'-'.$code ,
        $model->getTranslation('title' , $code),
        ['data-name' => 'requirements.'.$code]
        ) !!}

    </div>
    @endforeach
</div>



{!! field()->file('image', __('course::dashboard.courses.form.image'),$model->getFirstMediaUrl('images'),[
'accept'=>"image/*"
]) !!}


{!! field()->file('pdf', __('course::dashboard.levels.form.pdf')) !!}


{!! field()->checkBox('require_start_exam', __('course::dashboard.levels.form.required_start_exam')) !!}
<div class="start_exam"
    {{
    $model->require_start_exam!=1?'hidden':'' }} >
    {!!
    field()->select('start_exam',__('course::dashboard.levels.form.start_exam'),$exams->pluck('title','id')->toArray(),null,['disabled'=>$model->require_start_exam!=1?'disabled':false])
    !!}
</div>



{!! field()->checkBox('require_end_exam', __('course::dashboard.levels.form.required_end_exam')) !!}


<div class="end_exam"
    {{
    $model->require_end_exam!=1?'hidden':'' }}
    >
    {!!
    field()->select('end_exam','',$exams->pluck('title','id')->toArray(),null,['disabled'=>$model->require_end_exam!=1?'disabled':false])
    !!}
</div>


{!! field()->checkBox('paid', __('course::dashboard.levels.form.paid')) !!}

<div class="price"
    {{
    $model->paid!=1?'hidden':'' }}>
    {!!
    field()->number('price',__('course::dashboard.levels.form.price'),null,['disabled'=>$model->paid!=1?'disabled':false])!!}
</div>







@if ($model->trashed())
{!! field()->checkBox('trash_restore', __('course::dashboard.levels.form.restore')) !!}
@endif


@push('scripts')
<script>
    let options={
            '#paid':'price',
            '#require_start_exam':'start_exam',
            '#require_end_exam':'end_exam',
        }

        for (const key in options) {
            $(key).on('switchChange.bootstrapSwitch',function(event,hidden){
                $(`.${options[key]}`).attr('hidden',!hidden)
                $(`.${options[key]}`).find(`#${options[key]}`).attr('disabled',!hidden)
            })
        }

</script>
@endpush
