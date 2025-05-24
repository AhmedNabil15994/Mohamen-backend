@extends('apps::frontend.layouts.app')
@section('title', __('blog::frontend.media_center.title') )
@section('content')
    <section class="page-head align-items-center text-center d-flex">
        <div class="container">
            <h1>{{__('blog::frontend.media_center.title')}}</h1>
        </div>
    </section>
    <div class="inner-page grey-bg">
        <div class="container">
            <div class="row">

                @foreach ($blogs as $blog)
                    <div class="col-md-4 wow fadeInUp">
                        <div class="podcast-block">
                            <div class="img-block">
                                <img class="img-fluid" src="{{ url($blog->image) }}"/>
                            </div>
                            <div class="podcast-content blog-content">
                                <h3>
                                    <a class="bodcast-title" href="{{route('frontend.blogs.show',$blog->slug)}}">
                                        {{ $blog->title }}
                                    </a>
                                </h3>
                                <ul class="post-footer">
                                    <li>{{__('blog::frontend.by')}}: {{optional($blog->trainer)->name}}</li>
                                    <li>{{ date('M' , strtotime($blog->created_at)) }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @include('apps::frontend.layouts.components.paginations',['paginator' => $blogs])
        </div>
    </div>
@stop
