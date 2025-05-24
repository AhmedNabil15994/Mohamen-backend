@extends('apps::frontend.layouts.app')
@section('title',$level->title)
@section('content')

<div class="page-head d-flex align-items-center text-center">
    <div class="container position-relative">
        <h1>   {{ $level->title }}</h1>
        <div class="breadcrumb justify-content-center">
            <span>
                <a title="Homepage" href="{{ route('frontend.home') }}"><i class="ti ti-home"></i> {{ __('apps::frontend.navbar.home') }}</a>
            </span>
            <span class="bread-sep">&nbsp; | &nbsp;</span>
            <span>   {{ $level->title }}</span>
        </div>
    </div>
</div>
<div class="page-content">
    <div class="container">
        <div class="row">
    @foreach($level->courses as $key => $course)

            <div class="col-md-4 wow fadeInUp">
                <div class="course-grid">
                    <div class="img-block">
                        <img class="img-fluid" src="{{ asset($course->image) }}" alt=""/>
                        <a class="btn-start btn btn-theme" href="{{ route('frontend.courses.show',$course->slug) }}"><span>@lang('course::frontend.levels.show.show_more')</span></a>
                    </div>
                    <div class="course-content">
                        <h3 class="d-flex align-items-center justify-content-between">
                            <a href="index.php?page=course"> {{ $level->title }} : {{  $course->title }}</a>
                        </h3>
                        <p>{{ $course->short_desc }}</p>
                        <ul class="d-flex align-items-center justify-content-between">
                            <li><img src="{{ asset('frontend/images/icon-13.png') }}" class="img-fluid" alt=""/> {{ $course->lessons_count }} @lang('course::frontend.levels.show.lectures')</li>
                            <li><img src="{{ asset('frontend/images/icon-15.png') }}" class="img-fluid" alt=""/> {{ $course->period }}  @lang('course::frontend.levels.show.hour')</li>
                        </ul>
                    </div>
                </div>
            </div>

    @endforeach


        </div>
    </div>
</div>

@stop
