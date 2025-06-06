@extends('apps::dashboard.layouts.app')
@section('title', __('authorization::dashboard.permissions.routes.create'))
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
          <a href="{{ url(route('dashboard.permissions.index')) }}">
            {{__('authorization::dashboard.permissions.routes.index')}}
          </a>
          <i class="fa fa-circle"></i>
        </li>
        <li>
          <a href="#">{{__('authorization::dashboard.permissions.routes.create')}}</a>
        </li>
      </ul>
    </div>



    <div class="row">
      <form id="form"
        role="form"
        class="form-horizontal form-row-seperated"
        method="post"
        enctype="multipart/form-data"
        action="{{route('dashboard.permissions.store')}}">
        @csrf
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
                        <a href="#general"
                          data-toggle="tab">
                          {{ __('authorization::dashboard.permissions.form.tabs.general') }}
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
              {{-- CREATE FORM --}}
              <div class="tab-pane active fade in"
                id="general">
                <div class="col-md-10">
                  <div class="form-group">
                    <label class="col-md-2">
                      {{__('authorization::dashboard.permissions.form.key')}}
                    </label>
                    <div class="col-md-9">
                      <input type="text"
                        name="display_name"
                        placeholder="users"
                        class="form-control"
                        data-name="display_name">
                      <div class="help-block"></div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-2">
                      {{ __('authorization::dashboard.roles.form.permissions') }}
                    </label>
                    <div class="col-md-9">
                      <div class="mt-checkbox-list">
                        <ul style="list-style-type:none">
                          <li style="list-style-type:none">
                            <label class="mt-checkbox">
                              <input class="child"
                                type="checkbox"
                                name="permission[]"
                                value="add">
                              {{__('authorization::dashboard.permissions.form.add')}}
                              <span></span>
                            </label>
                          </li>
                          <li style="list-style-type:none">
                            <label class="mt-checkbox">
                              <input class="child"
                                type="checkbox"
                                name="permission[]"
                                value="edit">
                              {{__('authorization::dashboard.permissions.form.edit')}}
                              <span></span>
                            </label>
                          </li>
                          <li style="list-style-type:none">
                            <label class="mt-checkbox">
                              <input class="child"
                                type="checkbox"
                                name="permission[]"
                                value="delete">
                              {{__('authorization::dashboard.permissions.form.delete')}}
                              <span></span>
                            </label>
                          </li>
                          <li style="list-style-type:none">
                            <label class="mt-checkbox">
                              <input class="child"
                                type="checkbox"
                                name="permission[]"
                                value="show">
                              {{__('authorization::dashboard.permissions.form.show')}}
                              <span></span>
                            </label>
                          </li>
                        </ul>
                      </div>
                      <div class="help-block"></div>
                    </div>
                  </div>

                </div>
              </div>

              {{-- END CREATE FORM --}}
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-actions">
              @include('apps::dashboard.layouts._ajax-msg')
              <div class="form-group">
                <button type="submit"
                  id="submit"
                  class="btn btn-lg blue">
                  {{__('apps::dashboard.buttons.add')}}
                </button>
                <a href="{{url(route('dashboard.permissions.index')) }}"
                  class="btn btn-lg red">
                  {{__('apps::dashboard.buttons.back')}}
                </a>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@stop
