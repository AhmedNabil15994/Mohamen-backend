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
        <form id="new-reservation-modal-form">
          @include('apps::dashboard.layouts._ajax-msg')
          {{-- <input type="text"
            class=" form-control"
            id="nameField"
            placeholder="{{ __('reservation::dashboard.reservations_calendar.form.name') }}">
          <br>
          <input type="text"
            class=" form-control"
            id="moblieField"
            placeholder="{{ __('reservation::dashboard.reservations_calendar.form.mobile') }}">
          <br> --}}
          <select class="form-control select2 select2-hidden-accessible" name="user_id" id="userIdField" required>
            <option value="">-- {{__('reservation::dashboard.reservations_calendar.form.select')}} --</option>
            @forelse (\Modules\User\Entities\User::cursor() as $user)
                <option value="{{$user->id}}">{{$user->name}}</option>
            @empty
                
            @endforelse
          </select>
          <p></p>
          <select class="form-control select2 select2-hidden-accessible"
            id="service_id"
            name="service_id">
          </select>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button"
          id="confirm"
          class="btn btn-primary">{{ __('reservation::dashboard.reservations_calendar.form.btn') }}</button>
      </div>
    </div>
  </div>
</div>