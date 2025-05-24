@extends('apps::dashboard.layouts.app')
@section('title', __('lawyer::dashboard.lawyers.create.title'))
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
          <a href="{{ url(route('dashboard.lawyers.index')) }}">
            {{__('lawyer::dashboard.lawyers.index.title')}}
          </a>
          <i class="fa fa-circle"></i>
        </li>
        <li>
          <a href="#">{{__('lawyer::dashboard.lawyers.create.title')}}</a>
        </li>
      </ul>
    </div>



    <div class="row">
      {!! Form::open([
      'url'=> route('dashboard.lawyers.store'),
      'id'=>"form",
      'role'=>"form",
      'method'=>'POST',
      'class'=>'form-horizontal form-row-seperated',
      'files' => true
      ])
      !!}




      <div class="col-md-12">

        {{-- RIGHT SIDE --}}
        <div class="col-md-3">
          <div class="panel-group accordion scrollable"
            id="accordion2">
            <div class="panel panel-default">

              <div id="collapse_2_1"
                class="panel-collapse in">
                <div class="panel-body">
                  <ul class="nav nav-pills nav-stacked">
                    <li class="active">
                      <a href="#global_setting"
                        data-toggle="tab">
                        {{ __('lawyer::dashboard.lawyers.create.form.general') }}
                      </a>
                    </li>
                    <li class="">
                      <a href="#profile"
                        data-toggle="tab">
                        {{ __('lawyer::dashboard.lawyers.create.form.profile') }}
                      </a>
                    </li>
                    <li class="">
                      <a href="#availabilities"
                        data-toggle="tab">
                        {{ __('availability::dashboard.availabilities.form.availabilities') }}
                      </a>
                    </li>
                    <li class="">
                      <a href="#services"
                        data-toggle="tab">
                        {{ __('lawyer::dashboard.lawyers.create.form.services') }}
                      </a>
                    </li>
                    <li class="">
                      <a href="#vacations"
                        data-toggle="tab">
                        {{ __('availability::dashboard.vacations.title') }}
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        {{-- PAGE CONTENT --}}
        <div class="col-md-9">
          <div class="tab-content">

            {{-- CREATE FORM --}}
            <div class="tab-pane active fade in"
              id="global_setting">

              <div class="col-md-10">
                @include('lawyer::dashboard.lawyers.form.form')
              </div>
            </div>
            <div class="tab-pane  fade in"
              id="availabilities">
              <div class="col-md-10">
                @include('availability::dashboard.form')
              </div>
            </div>
            <div class="tab-pane  fade in"
              id="vacations">
              <div class="col-md-10">
                @include('availability::dashboard.vacations')
              </div>
            </div>
            <div class="tab-pane fade in"
              id="profile">
              <div class="col-md-10">
                @include('lawyer::dashboard.lawyers.form.profile')
              </div>
            </div>
            <div class="tab-pane fade in"
              id="services">
              <div class="col-md-10">
                @include('lawyer::dashboard.lawyers.form.services')
              </div>
            </div>
          </div>
        </div>

        {{-- PAGE ACTION --}}
        <div class="col-md-12">
          <div class="form-actions">
            @include('apps::dashboard.layouts._ajax-msg')
            <div class="form-group">
              <button type="submit"
                id="submit"
                class="btn btn-lg blue">
                {{__('apps::dashboard.buttons.add')}}
              </button>
              <a href="{{url(route('dashboard.lawyers.index')) }}"
                class="btn btn-lg red">
                {{__('apps::dashboard.buttons.back')}}
              </a>
            </div>
          </div>
        </div>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>
@stop
