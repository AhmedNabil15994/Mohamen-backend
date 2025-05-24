@php
$modelServices=$model->load('services')->services;
@endphp
<div class="col-md-10">
  <div class="form-group">
    <table class="table table-striped table-bordered table-hover">
      <thead>
        <tr>
          <th style="width: 50%;">{{__('lawyer::dashboard.lawyers.create.form.services')}}</th>
          <th style="width: 50%;">{{__('lawyer::dashboard.lawyers.create.form.price')}}</th>
        </tr>
      </thead>
      <tbody>
        @foreach($extraData['services'] as $key => $service)
        <tr>
          <th style="width: 50%;">{{$service->title}}</th>
          <input type="hidden"
            name="services[{{ $key }}][service_id]"
            value="{{ $service->id }}">
          <th style="width: 50%;">
            {!!
            field()->number("services[$key][price]",__('lawyer::dashboard.lawyers.create.form.price'),
            $modelServices->where('id',$service->id)->first()?->pivot->price
            )
            !!}
          </th>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

</div>
