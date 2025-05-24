<div class="modal fade"
  id="event-modal"
  tabindex="-1"
  role="dialog"
  aria-labelledby="event-modalTitle"
  aria-hidden="true">
  <div class="modal-dialog"
    role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"
          id="exampleModalLongTitle">{{ __('reservation::dashboard.reservations_calendar.form.title') }}</h5>
        <button type="button"
          class="close"
          data-dismiss="modal"
          aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('dashboard.reservations.store')}}">
            @csrf
            <input id="lawyer_id_hidden" type="hidden" value="">
          @include('apps::dashboard.layouts._ajax-msg')
          
          <div class="form-group">
            <label for="" class="form-label">{{ __('reservation::dashboard.reservations.datatable.user') }} <span class="text-danger">*</span></label>
            <select class="form-control select2 select2-hidden-accessible" name="user_id" id="userIdField" required>
                <option value="">-- {{__('reservation::dashboard.reservations_calendar.form.select')}} --</option>
                @forelse (\Modules\User\Entities\User::cursor() as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                @empty
                    
                @endforelse
              </select>
          </div>
          <div class="form-group">
            <label for="" class="form-label">{{ __('reservation::dashboard.reservations.datatable.lawyer') }} <span class="text-danger">*</span></label>
            <select class="form-control select2 select2-hidden-accessible" name="lawyer_id" id="lawyerIdField" required>
                <option value="">-- {{__('reservation::dashboard.reservations_calendar.form.select')}} --</option>
                @forelse (\Modules\Lawyer\Entities\Lawyer::cursor() as $lawyer)
                    <option value="{{$lawyer->id}}" data-id="{{$lawyer->id}}">{{$lawyer->name}}</option>
                @empty
                    
                @endforelse
              </select>
          </div>
          <div class="form-group">
            <label for="" class="form-label">{{ __('reservation::dashboard.reservations.datatable.service') }} <span class="text-danger">*</span></label>
          <select class="form-control select2 select2-hidden-accessible"
            id="serviceIdField"
            name="service_id" required>
            <option value="">-- {{__('reservation::dashboard.reservations_calendar.form.select')}} --</option>
            
          </select>
          </div>
          
          <div class="form-group" id="date-div" style="display: none;">
            <label for="" class="form-label">{{ __('reservation::dashboard.reservations.datatable.reservation_date') }} <span class="text-danger">*</span></label>
            <input data-lawyer-id="" type="date" name="date" class="form-control" id="date">
          </div>
          <div class="form-group">
            <label for="" class="form-label">{{ __('reservation::dashboard.reservations.datatable.reservation_time') }} <span class="text-danger">*</span></label>
            <div id="times"></div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit"
          class="btn btn-primary">{{ __('reservation::dashboard.reservations_calendar.form.btn') }}</button>
      </div>
    </div>
</form>
  </div>
</div>