{!! field()->langNavTabs() !!}

<div class="tab-content">
    @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
    <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}"
        id="first_{{$code}}">
        {!! field()->text('title['.$code.']',
        __('level::dashboard.levels.form.title').'-'.$code ,
        $model->getTranslation('title' , $code),
        ['data-name' => 'title.'.$code]
        ) !!}
    </div>
    @endforeach
</div>

{!! field()->number('winning_count', __('level::dashboard.levels.form.winning_count')) !!}

{!! field()->file('image', __('level::dashboard.levels.form.image'),$model->getFirstMediaUrl('images')) !!}

@if ($model->trashed())
    {!! field()->checkBox('trash_restore', __('category::dashboard.categories.form.restore')) !!}
@endif
