@extends('apps::dashboard.layouts.app')
@section('title', __('reservation::dashboard.reservations_calendar.routes.index'))
@section('content')
<div class="page-content-wrapper">
  <div class="page-content">
    <div class="page-bar">
      <ul class="page-breadcrumb">
        <li>
          <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.index.title') }}</a>
          <i class="fa fa-circle"></i>
        </li>
        <li>
          <a href="#">{{ __('reservation::dashboard.reservations_calendar.routes.index') }}</a>
        </li>
      </ul>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="portlet light bordered">

          {{-- END DATATABLE FILTER --}}
          <div class="portlet-title">
            <div class="caption font-dark">
              <i class="icon-settings font-dark"></i>
              <span class="caption-subject bold uppercase">
                {{ __('reservation::dashboard.reservations_calendar.routes.index') }}
              </span>
            </div>
          </div>

          {{-- DATATABLE CONTENT --}}

          <div class="form-group"
            id="club_id_wrap">

            <label for="club_id"
              class="col-md-2"
              style="">
              {{ __('apps::dashboard._layout.aside.lawyers') }}
            </label>

            <div class="col-md-9"
              style="">
              <select class="form-control select2 select2-hidden-accessible"
                id="lawyer_id"
                name="lawyer_id">
                <option value="">{{ __('apps::dashboard._layout.aside.lawyers') }}</option>
                @foreach ($lawyers as $lawyer)
                <option data-services="{{ json_encode($lawyer->services) }}"
                  value="{{ $lawyer->id }}"
                  {{
                  $loop->iteration == 1 ? 'selected' : '' }}>
                  {{ $lawyer->name }}
                </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="portlet-body">
            @include('reservation::dashboard.reservations-calendar.calendar-view')
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
