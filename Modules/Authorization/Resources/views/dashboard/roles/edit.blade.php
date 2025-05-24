@extends('apps::dashboard.layouts.app')
@section('title', __('authorization::dashboard.roles.routes.update'))
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
                    <a href="{{ url(route('dashboard.roles.index')) }}">
                        {{__('authorization::dashboard.roles.routes.index')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('authorization::dashboard.roles.routes.update')}}</a>
                </li>
            </ul>
        </div>



        <div class="row">
            <form id="updateForm"
                role="form"
                class="form-horizontal form-row-seperated"
                method="post"
                enctype="multipart/form-data"
                action="{{route('dashboard.roles.update',$role->id)}}">
                @csrf
                @method('PUT')
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
                                                    {{ __('authorization::dashboard.roles.form.tabs.general') }}
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
                            {{-- UPDATE FORM --}}
                            <div class="tab-pane active fade in"
                                id="general">
                                <div class="col-md-10">
                                    {!! field()->langNavTabs() !!}
                                    <div class="tab-content">
                                        @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
                                        <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}"
                                            id="first_{{$code}}">
                                            {!! field()->text("display_name[$code]",
                                            __('authorization::dashboard.roles.form.name').'-'.$code ,
                                            $role->getTranslation('display_name' , $code),
                                            ['data-name' => 'display_name.'.$code]
                                            ) !!}


                                        </div>
                                        @endforeach
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{ __('authorization::dashboard.roles.form.permissions') }}
                                        </label>
                                        <div class="col-md-9">
                                            <div class="mt-checkbox-list">
                                                <ul>
                                                    @foreach ($permissions->groupBy('category') as $key => $perm)
                                                    <li style="list-style-type:none">
                                                        <label class="mt-checkbox">
                                                            <input type="checkbox"
                                                                class="permission-group">
                                                            <strong>{{$key}}</strong>
                                                            <span></span>
                                                        </label>
                                                        <ul class="row"
                                                            style="list-style-type:none">
                                                            @foreach($perm as $permission)
                                                            <li style="list-style-type:none">
                                                                <label class="mt-checkbox col-md-4">
                                                                    <input class="child"
                                                                        type="checkbox"
                                                                        name="permission[]"
                                                                        value="{{$permission->id}}"
                                                                        {{
                                                                        $role->hasPermissionTo($permission->name) ?
                                                                    'checked=""' : ''}}>
                                                                    {{ $permission->display_name }}
                                                                    <span></span>
                                                                </label>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                    <hr>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- END UPDATE FORM --}}
                        </div>
                    </div>

                    {{-- PAGE ACTION --}}
                    <div class="col-md-12">
                        <div class="form-actions">
                            @include('apps::dashboard.layouts._ajax-msg')
                            <div class="form-group">
                                <button type="submit"
                                    id="submit"
                                    class="btn btn-lg green">
                                    {{__('apps::dashboard.buttons.edit')}}
                                </button>
                                <a href="{{url(route('dashboard.roles.index')) }}"
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

@section('scripts')
<script>
    $(document).ready(
            function () {
                $(".permission-group").click(function () {
                    $(this).parents('li').find('.child').prop('checked', this.checked);
                });
            }
        );
</script>
@stop
