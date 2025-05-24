@extends('apps::frontend.layouts.app')
@section('title', $service->title)
@section('content')
<section class="page-head align-items-center text-center d-flex">
    <div class="container">
        <h1>{{ __('service::frontend.index.title')}} / {{ $service->title }}</h1>
    </div>
</section>
<div class="inner-page grey-bg">
    <div class="container">
        <div class="service-post">
            <div class="img-block">
                <img class="img-fluid"
                    src="{{url($service->image)}}" />
            </div>
            <div class="service-content">
                <h2>{{$service->title}}</h2>
                <ul class="post-footer">
                    <li>{{__('service::frontend.by')}}: {{optional($service->trainer)->name}}</li>
                    <li>
                        {{ date('M,d Y' , strtotime($service->created_at)) }}
                    </li>
                </ul>
                <div class="post-content">
                    {!! $service->description !!}
                </div>
            </div>
        </div>
    </div>
</div>
@stop
