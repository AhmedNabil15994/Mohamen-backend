{!! field()->langNavTabs() !!}

<div class="tab-content">
  @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
  <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}"
    id="first_{{$code}}">
    {!! field()->text('job_title['.$code.']',
    __('lawyer::dashboard.lawyers.create.form.job_title').'-'.$code ,
    optional( $model->profile)->getTranslation('job_title',$code),
    ['data-name' => 'job_title.'.$code,]
    ) !!}


    {!! field()->textarea('about['.$code.']',
    __('lawyer::dashboard.lawyers.create.form.about').'-'.$code ,
    optional($model->profile)->getTranslation('about',$code),
    ['data-name' => 'about.'.$code,'class'=>'form-control']
    ) !!}
  </div>
  @endforeach
</div>


{!! field()->select('city_id',__('area::dashboard.states.form.cities'),$extraData['countries']) !!}
