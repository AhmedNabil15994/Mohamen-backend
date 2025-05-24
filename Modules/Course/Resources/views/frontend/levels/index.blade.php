@extends('apps::frontend.layouts.app')
@section('title', __('course::frontend.levels.index.title'))
@section('content')
<div class="page-head d-flex align-items-center text-center">
    <div class="container position-relative">
        <h1>  @lang('course::frontend.levels.index.title')</h1>
        <div class="breadcrumb justify-content-center">
            <span>
                <a title="Homepage" href="{{ route('frontend.home') }}"><i class="ti ti-home"></i> @lang('apps::frontend.navbar.home')</a>
            </span>
            <span class="bread-sep">&nbsp; | &nbsp;</span>
            <span> @lang('course::frontend.levels.index.title')</span>
        </div>
    </div>
</div>
<div class="page-content">
    <div class="container">
        <div class="row">
            @foreach($levels as $key => $level)
            <div class="col-md-4 wow fadeInUp">
                <div class="course-grid">
                    <a class="img-block" href="{{ route('frontend.levels.show',$level->id) }}">
                        <img class="img-fluid" src="{{ $level->getFirstMediaUrl('images') }}" alt=""/>
                    </a>
                    <div class="course-content">
                        <h3 class="d-flex align-items-center justify-content-between"><a href="{{ route('frontend.levels.show',$level->id) }}">{{  $level->title }}</a> </h3>
                        <p>{{  $level->short_desc }}</p>
                        <ul class="d-flex align-items-center justify-content-between">
                            <li><img src="{{ asset('frontend/images/icon-6.png') }}" class="img-fluid" alt=""/> {{ $level->courses_count }}</li>

                        </ul>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>

@stop
