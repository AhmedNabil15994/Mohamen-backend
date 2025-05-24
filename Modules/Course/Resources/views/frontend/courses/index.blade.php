@extends('apps::frontend.layouts.app')
@section('title', __('Courses') )
@section('content')
<section class="page-head align-items-center text-center d-flex">
    <div class="container">
        <h1>{{ __('Courses') }}</h1>
    </div>
</section>
<div class="inner-page grey-bg">
    <div class="container">
        <div class="row">
            @include('course::frontend.courses.index-partials.sidebar')
            <div class="col-md-9">
                <div class="courses-block">
                    <h2 class="inner-title">{{ __('Female') }}</h2>
                    <div class="row">
                        @foreach($femaleCourses as $key => $course)
                        @includeIf('course::frontend.courses.index-partials.course-block',['wrapperClass'=>'col-md-4 wow
                        fadeInUp'])
                        @endforeach
                    </div>
                </div>


                <div class="courses-block">
                    <h2 class="inner-title">{{ __('Male') }}</h2>
                    <div class="row">
                        @foreach($maleCourses as $key => $course)
                        @includeIf('course::frontend.courses.index-partials.course-block',['wrapperClass'=>'col-md-4 wow
                        fadeInUp'])
                        @endforeach

                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

@endsection
