{!! field()->langNavTabs() !!}
<div class="tab-content">
  @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
  <div class="tab-pane fade in {{ $code == locale() ? 'active' : '' }}"
    id="first_{{ $code }}">
    {!! field()->text(
    'title[' . $code . ']',
    __('service::dashboard.services.form.title') . '-' . $code,
    $model->getTranslation('title', $code),
    ['data-name' => 'title.' . $code],
    ) !!}
    {!! field()->textarea('desc[' . $code . ']',__('service::dashboard.services.form.description') . '-' . $code,
    $model->getTranslation('desc', $code),
    ['data-name' => 'desc.' . $code,'class'=>'form-control'],
    ) !!}
  </div>
  @endforeach
</div>

{!! field()->file('image', __('service::dashboard.services.form.image'),
$model->getFirstMediaUrl('images')) !!}

{!! field()->checkBox('status', __('service::dashboard.services.form.status')) !!}

{!!
field()->select('type',
__('service::dashboard.services.form.type'),
__('service::dashboard.services.form.types'),null
) !!}
