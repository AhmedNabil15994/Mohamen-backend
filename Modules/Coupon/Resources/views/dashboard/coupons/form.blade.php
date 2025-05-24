<div class="form-group">
  <label class="col-md-2">
    {{ __('coupon::dashboard.coupons.form.type')}}
  </label>
  <div class="col-md-9">
    <div class="form-check">

      @foreach(__('coupon::dashboard.coupons.form.types') as $key => $value)
      <span style="margin: 10px;">
        <input type="radio"
          class="type"
          name="type"
          id="{{ $key }}"
          value="{{ $key }}"
          {{$key==$model->type?'checked':'' }}>
        <label class="form-check-label"
          for="{{ $key }}">
          {{ $value }}
        </label>
      </span>
      @endforeach

    </div>
  </div>
</div>
<div id="courses_wrap">
  {!! field()->select('courses[]',__('coupon::dashboard.coupons.form.types.courses'),
  $extraData['courses']->pluck('title','id'), null ,['multiple'=>'multiple','data-name'=>'courses'] ) !!}
</div>
<div id="lawyers_wrap">
  {!! field()->select('lawyers[]',__('coupon::dashboard.coupons.form.types.lawyers'),
  $extraData['lawyers']->pluck('name','id'), $model->lawyers ,['multiple'=>'multiple','data-name'=>'lawyers'] ) !!}
</div>

{!! field()->text('code',__('coupon::dashboard.coupons.form.code'))!!}
{!! field()->checkBox('is_fixed', __('coupon::dashboard.coupons.form.is_fixed'),1,['checked'=>true]) !!}
{!! field()->text('amount',__('coupon::dashboard.coupons.form.amount'))!!}
{!! field()->text('max_use',__('coupon::dashboard.coupons.form.max_use'))!!}
{!! field()->text('max_use_user',__('coupon::dashboard.coupons.form.max_use_user'))!!}
<div class="form-group">
  <label class="col-md-2">
    {{ __('coupon::dashboard.coupons.form.expired_at') }}
  </label>
  <div class="col-md-9">
    <div class="input-group input-medium date date-picker"
      data-date-format="yyyy-mm-dd"
      data-date-start-date="+0d">
      <input type="text"
        class="form-control"
        name="expired_at"
        value="{{ $model->expired_at }}">
      <span class="input-group-btn">
        <button class="btn default"
          type="button">
          <i class="fa fa-calendar"></i>
        </button>
      </span>
    </div>
  </div>
</div>
{!! field()->checkBox('status', __('coupon::dashboard.coupons.form.status')) !!}

@section("scripts")
<script>
  $('.type').change(function (e) {
           let val=$(this).val();
           $(`#lawyers_wrap`).hide()
           $(`#courses_wrap`).hide()
           $(`#${val}_wrap`).show()
    }).change();
</script>
@stop
