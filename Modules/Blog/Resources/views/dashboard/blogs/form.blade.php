{!! field()->langNavTabs() !!}
<div class="tab-content">
  @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
    <div class="tab-pane fade in {{ $code == locale() ? 'active' : '' }}" id="first_{{ $code }}">
      {!! field()->text(
          'title[' . $code . ']',
          __('blog::dashboard.blogs.form.title') . '-' . $code,
          $model->getTranslation('title', $code),
          ['data-name' => 'title.' . $code],
      ) !!}
      {!! field()->textarea(
          'desc[' . $code . ']',
          __('blog::dashboard.blogs.form.description') . '-' . $code,
          $model->getTranslation('desc', $code),
          ['data-name' => 'desc.' . $code,'class'=>'form-control'],
      ) !!}
    </div>
  @endforeach
</div>

{!! field()->file('image', __('blog::dashboard.blogs.form.image')) !!}

{!! field()->checkBox('status', __('blog::dashboard.blogs.form.status')) !!}
