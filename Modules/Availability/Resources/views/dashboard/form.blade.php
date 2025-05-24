@section('css')
<link rel="stylesheet"
  href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<style>
  .is_full_day {
    margin-left: 15px;
    margin-right: 15px;
  }

  .collapse-custom-time {
    display: none;
  }

  .times-row {
    margin-bottom: 5px;
  }

  .ui-timepicker-standard {
    z-index: 1000 !important;
  }

</style>

@endsection
<table class="table table-striped table-bordered table-hover">
  <thead>
    <tr>
      <th>#</th>
      <th>{{__('availability::dashboard.availabilities.form.day')}}</th>
      <th>{{__('availability::dashboard.availabilities.form.time')}}</th>
    </tr>
  </thead>
  <tbody>
    @foreach(__('availability::dashboard.availabilities.form.days') as $code => $day)
    @php
    $availability=optional($model->availabilities()->where('day_code',$code)->first());
    @endphp
    <tr>
      <td>
        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
          <input type="checkbox"
            class="group-checkable"
            value="{{ $code }}"
            @if($model->vacation)
          {{
          in_array($code,$model->vacation?->weekly_vacations) ?'':'checked'
          }}
          @endif
          name="days_status[]">
          <span></span>
        </label>
      </td>
      <td>
        {{ $day }}
      </td>
      <td>
        <div class="form-check form-check-inline">
          <span class="is_full_day">
            <input class="form-check-input check-time"
              type="radio"
              name="availability[{{ $code }}][is_full_day]"
              id="full_time-{{$code}}"
              value="1"
              {{$model->availabilities()->where('day_code', $code)->value('is_full_day') == 1 ? 'checked' : ''}}
            onclick="hideCustomTime('{{$code}}')">
            <label class="form-check-label"
              for="full_time-{{$code}}">
              {{__('availability::dashboard.availabilities.form.full_time')}}
            </label>
          </span>
          <span class="is_full_day">
            <input class="form-check-input check-time"
              type="radio"
              name="availability[{{ $code }}][is_full_day]"
              id="custom_time-{{$code}}"
              value="0"
              {{$model->availabilities()->where('day_code', $code)->value('is_full_day') === 0 ? 'checked' : ''}}
            onClick="showCustomTime('{{$code}}')">
            <label class="form-check-label"
              for="custom_time-{{$code}}">
              {{__('availability::dashboard.availabilities.form.custom_time')}}
            </label>
          </span>
        </div>
      </td>
    </tr>
    <tr id="collapse-{{$code}}"
      class="collapse-custom-time"
      style="{{$model->availabilities()->where('day_code', $code)->value('is_full_day') != 1 ? 'display:
    table-row;' : ''}}">
      <td colspan="3"
        id="div-content-{{$code}}">
        <div class="row"
          style="margin-bottom: 5px;">
          <div class="col-md-3">
            <button type="button"
              class="btn btn-success"
              onclick="addMoreDayTimes(event, '{{$code}}')">
              {{__('availability::dashboard.availabilities.form.btn_more')}}
              <i class="fa fa-plus-circle"></i>
            </button>
          </div>
        </div>

        @foreach((array)$availability->custom_times as $key => $time)
        <div class="row times-row"
          id="rowId-{{$code}}-{{$key}}">
          <div class="col-md-4">
            <div class="input-group">
              <input type="text"
                class="form-control timepicker 24_format"
                name="availability[{{ $code }}][times][{{ $key }}][time_from]"
                data-name="availability[{{ $code }}][times][{{ $key }}][time_from]"
                value="{{ $time['time_from'] }}">
              <span class="input-group-btn">
                <button class="btn default"
                  type="button">
                  <i class="fa fa-clock-o"></i>
                </button>
              </span>
            </div>
          </div>
          <div class="col-md-4">
            <div class="input-group">
              <input type="text"
                class="form-control timepicker 24_format"
                name="availability[{{ $code }}][times][{{ $key }}][time_to]"
                data-name="availability[{{ $code }}][times][{{ $key }}][time_to]"
                value="{{ $time['time_to'] }}">
              <span class="input-group-btn">
                <button class="btn default"
                  type="button">
                  <i class="fa fa-clock-o"></i>
                </button>
              </span>
            </div>
          </div>
          @if($time)
          <div class="col-md-4">
            <button type="button"
              class="btn btn-danger"
              onClick="removeDayTimes('{{$code}}', '{{$key}}', 'row')">
              X
            </button>
          </div>
          @endif
        </div>
        @endforeach
        </div>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>


@section('scripts')

<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

<script>
  var timePicker = $(".timepicker");
        timePicker.timepicker({timeFormat: 'h:mm p',interval: 60});
        var rowCountsArray = [];
        function hideCustomTime(id) {
          $("#collapse-" + id).hide();
        }

        function showCustomTime(id) {
          $("#collapse-" + id).show();
        }

        function addMoreDayTimes(e, dayCode) {

            if (e.preventDefault) {
                e.preventDefault();
            } else {
                e.returnValue = false;
            }

            var rowCount = Math.floor(Math.random() * 9000000000) + 1000000000;
            rowCountsArray.push(rowCount);

            var divContent = $('#div-content-' + dayCode);
            var newRow = `
            <div class="row times-row" id="rowId-${dayCode}-${rowCount}">
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" class="form-control timepicker 24_format"
                         name="availability[${dayCode}][times][${rowCount}][time_from]"
                               data-name="availability[${dayCode}][times][time_from][]" >
                        <span class="input-group-btn">
                            <button class="btn default" type="button">
                                <i class="fa fa-clock-o"></i>
                            </button>
                        </span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" class="form-control timepicker 24_format"
                       name="availability[${dayCode}][times][${rowCount}][time_to]"
                               data-name="availability[${dayCode}][times][time_to][]" >
                        <span class="input-group-btn">
                            <button class="btn default" type="button">
                                <i class="fa fa-clock-o"></i>
                            </button>
                        </span>
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-danger" onclick="removeDayTimes('${dayCode}', ${rowCount}, 'row')">X</button>
                </div>
            </div>
            `;

            divContent.append(newRow);

               $(".timepicker").timepicker({
                 timeFormat: 'h:mm p',interval: 60
              });
        }

        function removeDayTimes(dayCode, index, flag = '') {
            if (flag === 'row') {
                $('#rowId-' + dayCode + '-' + index).remove();
                const i = rowCountsArray.indexOf(index);
                if (i > -1) {
                    rowCountsArray.splice(i, 1);
                }
            }
        }

</script>

@endsection
