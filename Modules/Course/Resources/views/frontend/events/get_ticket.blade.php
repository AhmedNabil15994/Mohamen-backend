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
            <li>
                <a href="{{url(route('frontend.events.show',$event->translate('en')->slug))}}">
                    {{ $event->translate(locale())->title }} /
                </a>
            </li>
            <li class="active">{{ __('course::frontend.events.index.get_ticket') }}</li>
        </ul>
    </div>
</section>

<div class="inner-page">
    <div class="container">
        <div class="row">
            <div class="col-md-9 account-content cart-items">
                @include('apps::frontend.layouts._msg')
                <div class="items">
                    <div class="myclass-block media d-flex align-items-center wow fadeInUp mb-30">
                        <div class="media-img">
                            <img class="img-fluid" src="{{ url($event->image) }}" alt="" />
                        </div>
                        <div class="media-body">
                            <h3 class="align-items-center d-flex">
                                <a href="#" class="event-title">
                                    {{$event->translate(locale())->title }}
                                </a>
                            </h3>
                            <div class="event-price"> {{ $event->price }} KWD</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="order-summery">
                    <div class="d-flex mb-20 align-items-center">
                        <span class="d-inline-block right-side flex-1">{{__('cart::frontend.show.subtotal')}}</span>
                        <span class="d-inline-block left-side">{{ $event['price'] }} KWD</span>
                    </div>
                    {{-- <div class="d-flex mb-20 promo-code align-items-center">
                        <span class="d-inline-block right-side flex-1">
                            <input type="text" placeholder="Insert coupon"></span>
                        <span class="d-inline-block left-side"> <button class="btn btn-add" type="submit">Add</button></span>
                        <span class="d-inline-block left-side remove" title="Remove coupon"><i class="ti-close"></i></span>
                    </div> --}}
                    <hr>
                    <div class="minicart-footer">
                        <div class="subtotal d-flex text-center justify-content-center mb-20">
                            <span class="label"> {{__('cart::frontend.show.total')}} :</span>
                            <span class="price">{{ $event['price'] }} KWD </span>
                        </div>
                    </div>
                    <hr>
                    <div class="col-md-12 account-content">
                        <h5>{{__('order::frontend.show.payments')}} :</h5>
                        <form action="{{ url(route('frontend.order.event')) }}" method="POST">
                            <div class="choose-time mt-30">
                                @csrf
                                <input type="hidden" name="slug" value="{{ $event->translate('en')->slug }}">
                                <div class="checkboxes radios mb-20">
                                    <input id="check-et" type="radio" name="payment" value="payment">
                                    <label for="check-et"> {{__('order::frontend.show.payment')}}</label>
                                </div>
                            </div>
                            <button class="btn theme-btn" type="submit">
                                <span>{{__('order::frontend.show.order_now')}}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
