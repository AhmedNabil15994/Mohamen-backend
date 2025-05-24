@extends('apps::frontend.layouts.app')
@section('title', $event->translate(locale())->title)
@section('content')

<section class="page-head align-items-center text-center d-flex">
    <div class="container">
        <h1>{{ $event->translate(locale())->title }}</h1>
        <ul class="mt-20">
            <li>
                <a href="{{ url(route('frontend.home')) }}">
                    <i class="ti-home"></i> {{ __('apps::frontend.navbar.home') }} /
                </a>
            </li>
            <li>
                <a href="{{ url(route('frontend.events.index')) }}">
                    {{ __('course::frontend.events.index.title') }} /
                </a>
            </li>
            <li class="active">{{ $event->translate(locale())->title }}</li>
        </ul>
    </div>
</section>
<div class="inner-page">
    <div class="container">
        <div class="row event-header mb-30">
            <div class="col-md-8">
                <h2>{{ $event->translate(locale())->title }}</h2>
                <ul class="content-list">
                    <li><i class="ti-timer"></i> {{ $event->start_date }} - {{ $event->end_date }}</li>
                    <li><i class="ti-location-pin"></i> {{ $event->address }}</li>
                </ul>
            </div>
            @if (count($event->subscribed) <= 0) <div class="col-md-4 text-right">
                <a href="{{url(route('frontend.events.ticket',$event->translate('en')->slug))}}">
                    <button class="btn theme-btn"><span>{{ __('apps::frontend.buttons.get_ticket') }}</span></button>
                </a>
        </div>
        @endif
    </div>
    <div class="row mb-30">
        <div class="col-md-8">
            <div class="event-img">
                <img class="img-fluid" src="{{ url($event->image) }}" alt="" />
            </div>
        </div>
        <div class="col-md-2">
            {!! $event->map !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 event-details">
            <h4>{{ __('course::frontend.events.show.description') }}</h4>
            <p>{!! $event->translate(locale())->description !!}</p>

            {{-- <div class="d-md-flex align-items-md-center share-buttons mt-20">
                    <b>Share:</b>
                    <a class="btn btn-sm rounded-circle" href="#">
                        <span class="ti-facebook"></span>
                    </a>
                    <a class="btn btn-sm rounded-circle" href="#">
                        <span class="ti-twitter"></span>
                    </a>
                    <a class="btn btn-sm rounded-circle" href="#">
                        <span class="ti-linkedin"></span>
                    </a>
                    <a class="btn btn-sm rounded-circle" href="#">
                        <span class="ti-pinterest"></span>
                    </a>
                </div> --}}
            {{-- <div class="mt-30">
                    <h4>Tags</h4>
                    <div class="post-tags">
                        <a class="btn" href="#">Yoga</a>
                        <a class="btn" href="#">Joya</a>
                        <a class="btn" href="#">Training</a>
                        <a class="btn" href="#">Meditation</a>
                        <a class="btn" href="#">Education</a>
                        <a class="btn" href="#">events</a>
                        <a class="btn" href="#">Therapy</a>
                    </div>
                </div> --}}
            @if ($event->is_certificated)
            <div class="certificate-block align-items-center d-flex pt-30">
                <img src="/frontend/en/images/certificate.png" alt="" />
                <div>
                    <h5>{{ __('course::frontend.events.show.is_certificated') }}</h5>
                </div>
            </div>
            @endif
        </div>
        <div class="col-md-4">
            <div class="widget">
                <h4 class="widget-title">{{ __('course::frontend.events.show.details') }}</h4>
                <ul>
                    @if (!is_null($event->start_date))
                        <li> <i Class="ti-calendar"></i> {{ $event->start_date }} - {{ $event->end_date }}</li>
                    @endif
                    @if (!is_null($event->start_time))
                        <li> <i Class="ti-timer"></i> {{ $event->start_time }} - {{ $event->end_time }}</li>
                    @endif
                    @if (!is_null($event->address))
                        <li> <i Class="ti-location-pin"></i> {{$event->address}}</li>
                    @endif
                    @if (!is_null($event->price))
                        <li> <i Class="ti-wallet"></i> {{ $event->price }} KWD</li>
                    @endif
                </ul>

            </div>
            <div class="widget">
                <h4 class="widget-title"> {{ __('course::frontend.events.show.trainer') }}</h4>
                <ul>
                    <li class="organizer">
                        <a href="#." class="d-flex align-items-center">
                            <img class="img-fluid" src="{{ url($event->trainer->image) }}" alt="" />
                            {{ $event->trainer->name  }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
</div>
<section class="section-block theme-bg2">
    <div class="container">
        <div class="section-header-style mb-60 text-center">
            <h2 class="section-title">{{ __('course::frontend.events.show.related') }}</h2>
            <img class="title-border" src="/frontend/en/images/title-line.png" />
        </div>
        <div class="list-events owl-carousel">
            @foreach ($events as $related)
            <div class="item wow fadeInUp">
                <div class="event-block">
                    <div class="img-block">
                        <img class="img-fluid" src="{{ url($related->image) }}" alt="" />
                        <a class="view-det" href="{{url(route('frontend.events.show',$related->translate('en')->slug))}}">
                            {{ __('apps::frontend.buttons.view') }}
                        </a>
                    </div>
                    <div class="content-block">
                        <h3>
                            <a href="{{url(route('frontend.events.show',$related->translate('en')->slug))}}" class="event-title">
                                {{ $related->translate(locale())->title }}
                            </a>
                        </h3>
                        <ul class="content-list">
                            <li><i class="ti-timer"></i> {{ $related->start_time }} - {{ $related->end_time }}</li>
                            <li><i class="ti-timer"></i> {{ $related->start_date }} - {{ $related->end_date }}</li>
                            <li><i class="ti-location-pin"></i> {{ $related->address }}</li>
                        </ul>
                        <div class="content-head d-flex align-items-center">
                            <span class="event-price"> {{ $related->price }} KWD</span>


                            @if ($course->medical_profile == false)
                                @if (count($course->subscribed) <= 0)
                                    <div class="buy-btns text-center mt-50 mb-40">
                                        <a href="{{ url(route('frontend.cart.add',$course->translate('en')->slug)) }}" class="btn theme-btn">
                                            <span>
                                                <i class="ti-shopping-cart"></i>
                                                {{ __('apps::frontend.buttons.add_to_cart') }}
                                            </span>
                                        </a>
                                    </div>
                               @endif
                            @else
                                @if (auth()->user()->profile)
                                    @if (auth()->user()->profile->is_reviewed == true)
                                        @if (count($related->subscribed) <= 0)
                                            <a href="{{url(route('frontend.events.show',$related->translate('en')->slug))}}" class="event-booking">
                                                {{ __('apps::frontend.buttons.get_ticket') }}
                                            </a>
                                        @endif
                                    @else
                                        <div class="alert alert-danger" role="alert">
                                            {{ __('course::frontend.courses.show.under_review') }}
                                        </div>
                                    @endif
                                @else
                                    <div class="alert alert-warning" role="alert">
                                        {{ __('course::frontend.courses.show.complete_profile') }}
                                    </div>
                                    <center>
                                        <a href="{{url(route('frontend.profile.medical'))}}" class="event-title">
                                            {{ __('course::frontend.courses.show.complete_now') }}
                                        </a>
                                    </center>
                                @endif
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


@stop
