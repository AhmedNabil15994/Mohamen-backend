@extends('apps::frontend.layouts.app')
@section('title', $blog->title)
@section('content')
    <section class="page-head align-items-center text-center d-flex">
        <div class="container">
            <h1>{{ __('blog::frontend.index.title')}} / {{ $blog->title }}</h1>
        </div>
    </section>
    <div class="inner-page grey-bg">
        <div class="container">
            <div class="blog-post">
                <div class="img-block">
                    <img class="img-fluid" src="{{url($blog->image)}}"/>
                </div>
                <div class="blog-content">
                    <h2>{{$blog->title}}</h2>
                    <ul class="post-footer">
                        <li>{{__('blog::frontend.by')}}: {{optional($blog->trainer)->name}}</li>
                        <li>
                            {{ date('M,d Y' , strtotime($blog->created_at)) }}
                        </li>
                    </ul>
                    <div class="post-content">
                        {!! $blog->description !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
