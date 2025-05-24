@inject('lawyers', 'Modules\Lawyer\Entities\Lawyer')

<div class="col-md-3">
  <div class="form-group">
    <label class="control-label">
      {{
      __('reservation::dashboard.reservations.datatable.owners')
      }}
    </label>
    <select name="owners"
      id="single"
      class="form-control select2">
      <option value="">
        {{__('reservation::dashboard.reservations.datatable.owners')}}
      </option>
      @foreach ($lawyers->active()->get() as $lawyer)
      <option value="{{ $lawyer->id }}">
        {{ $lawyer->name }}
      </option>
      @endforeach
    </select>
  </div>
</div>
