@extends('apps::frontend.layouts.app')
@section('title', __('course::frontend.events.index.title') )
@section('content')

<section class="page-head align-items-center text-center d-flex">
    <div class="container">
        <h1>{{ __('course::frontend.events.index.title') }}</h1>
        <ul class="mt-20">
            <li><a href="index.php"><i class="ti-home"></i> {{ __('apps::frontend.navbar.home') }} /</a></li>
            <li class="active">{{ __('course::frontend.events.index.title') }}</li>
        </ul>
    </div>
</section>

<div class="inner-page">
    <div class="container">
        <div class="row event-search d-flex align-items-center mb-40">
            <div class="col-md-3">
                <div class="input-group">
                    <label>Event From</label>
                    <div class="input-with-icon">
                        <i class="ti-calendar"></i>
                        <input class="date" type="text" placeholder="" />
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <label>Event To</label>
                    <div class="input-with-icon">
                        <i class="ti-calendar"></i>
                        <input class="date" type="text" placeholder="" />
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <label>Search For</label>
                    <div class="input-with-icon">
                        <i class="ti-search"></i>
                        <input type="text" placeholder="" />
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="filter_days mt-20">
                    <div class="input-wrapper">
                        <input type="checkbox" id="checkbox" name="checkbox">
                        <label for="checkbox">Sun</label>

                        <input type="checkbox" id="checkbox2" name="checkbox">
                        <label for="checkbox2">Mon</label>

                        <input type="checkbox" id="checkbox3" name="checkbox">
                        <label for="checkbox3">Tue</label>

                        <input type="checkbox" id="checkbox4" name="checkbox">
                        <label for="checkbox4">Wed</label>

                        <input type="checkbox" id="checkbox5" name="checkbox">
                        <label for="checkbox5">Thu</label>

                        <input type="checkbox" id="checkbox6" name="checkbox">
                        <label for="checkbox6">Fri</label>

                        <input type="checkbox" id="checkbox7" name="checkbox">
                        <label for="checkbox7">Sat</label>
                        <input type="checkbox" id="checkbox8" name="checkbox">
                        <label for="checkbox8">Morning</label>

                        <input type="checkbox" id="checkbox9" name="checkbox">
                        <label for="checkbox9">Afternoon</label>

                        <input type="checkbox" id="checkbox10" name="checkbox">
                        <label for="checkbox10">Evening</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach ($events as $event)
            <div class="col-md-4 wow fadeInUp">
                <div class="event-block mb-30">
                    <div class="img-block">
                        <img class="img-fluid" src="{{ url($event->image) }}" alt="" />
                        <a class="view-det" href="{{url(route('frontend.events.show',$event->translate('en')->slug))}}">
                            {{ __('apps::frontend.buttons.view') }}
                        </a>
                    </div>
                    <div class="content-block">
                        <h3>
                            <a href="{{url(route('frontend.events.show',$event->translate('en')->slug))}}" class="event-title">
                                {{ $event->translate(locale())->title }}
                            </a>
                        </h3>
                        <ul class="content-list">
                            <li><i class="ti-timer"></i> {{ $event->start_time }} - {{ $event->end_time }}</li>
                            <li><i class="ti-timer"></i> {{ $event->start_date }} - {{ $event->end_date }}</li>
                            <li><i class="ti-location-pin"></i> {{ $event->address }}</li>
                        </ul>
                        <div class="content-head d-flex align-items-center">
                            <span class="event-price"> {{ $event->price }} KWD</span>
                            @if (count($event->subscribed) <= 0)
                            <a href="{{url(route('frontend.events.ticket',$event->translate('en')->slug))}}" class="event-booking">
                                {{ __('apps::frontend.buttons.get_ticket') }}
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="pagination-items mt-20">

            <ul class="pagination d-md-flex justify-content-center align-items-md-center">
                {{ $events->appends(Request::except('page'))->links() }}
            </ul>

        </div>
    </div>
</div>

@stop
