@extends('apps::frontend.layouts.app')
@section('title', __('service::frontend.index.title') )
@section('content')
<section class="page-head align-items-center text-center d-flex">
    <div class="container">
        <h1>{{__('service::frontend.index.title')}}</h1>
    </div>
</section>
<div class="inner-page grey-bg">
    <div class="container">
        <div class="row">

            @foreach ($services as $service)
            <div class="col-md-4 wow fadeInUp">
                <div class="podcast-block">
                    <div class="img-block">
                        <img class="img-fluid"
                            src="{{ url($service->image) }}" />
                    </div>
                    <div class="podcast-content service-content">
                        <h3>
                            <a class="bodcast-title"
                                href="{{route('frontend.services.show',$service->slug)}}">
                                {{ $service->title }}
                            </a>
                        </h3>
                        <ul class="post-footer">
                            <li>{{__('service::frontend.by')}}: {{optional($service->trainer)->name}}</li>
                            <li>{{ date('M' , strtotime($service->created_at)) }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @include('apps::frontend.layouts.components.paginations',['paginator' => $services])
    </div>
</div>
@stop
