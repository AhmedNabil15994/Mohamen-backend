@extends('apps::dashboard.layouts.app')
@section('title', __('reservation::dashboard.reservations.routes.show'))
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
          <a href="{{ url(route('dashboard.reservations.index')) }}">
            {{__('reservation::dashboard.reservations.routes.index')}}
          </a>
          <i class="fa fa-circle"></i>
        </li>
        <li>
          <a href="#">{{__('reservation::dashboard.reservations.routes.show')}}</a>
        </li>
      </ul>
    </div>



    <div class="row">


      <div class="col-md-12">

        <div class="col-md-3">
          <div class="panel-group accordion scrollable"
            id="accordion2">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title"><a class="accordion-toggle"></a></h4>
              </div>
              <div id="collapse_2_1"
                class="panel-collapse in">
                <div class="panel-body">
                  <ul class="nav nav-pills nav-stacked">
                    <li class="active">
                      <a href="#global_setting"
                        data-toggle="tab">
                        {{ __('reservation::dashboard.reservations.show.tabs.general') }}
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-9">
          <div class="tab-content">
            <div class="tab-pane active fade in"
              id="global_setting">
              <div class="col-md-10">
                @include('reservation::dashboard.reservations.details')
              </div>
            </div>
          </div>
        </div>

        {{-- PAGE ACTION --}}


      </div>

    </div>
  </div>
</div>
@stop
