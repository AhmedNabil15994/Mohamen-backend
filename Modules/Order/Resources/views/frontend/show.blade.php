@extends('apps::frontend.layouts.app')
@section('title', __('order::frontend.show.Checkout'))
@section('content')
<div class="inner-page grey-bg">
    <div class="container">
        {!! Form::open([
        'method' => 'POST',
        'id'=>'form',
        ]) !!}
        <div class="order-list checkout-page bg-white">
            @foreach ($cart as $item)
            @if($item->attributes->type == 'course')
            <div class="order-block d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="img-block">
                        <img class="img-fluid" src="{{url($item->attributes->image) }}">
                    </div>
                    <div class="course-content">
                        <h3><a class="title" href="{{route('frontend.courses.show',$item->attributes->product->slug)}}"> {{$item->attributes->product->title}}</a></h3>
                        <a class="tutor-name" href="index.php?page=tutor-profile">By {{ $item->attributes->product->trainer->name }}</a>
                    </div>
                </div>
                <div class="order-status">
                    <span class="price"> {{ $item->price }} KWD</span>
                </div>
            </div>
            @endif
            @endforeach
            <div class="checkout-summery row justify-content-end">

                <div class="col-md-4">
                    <div class="check-row d-flex align-items-center justify-content-between">
                        <h5>{{ __('Subtotal') }}</h5>
                        <span class="price"> {{ Cart::getTotal() }} <span>KWD</span></span>
                    </div>
                    {{-- <div class="check-row d-flex align-items-center justify-content-between">
                        <h5>Coupon</h5>
                        <span class="price"> -50 <span>KWD</span></span>
                    </div> --}}
                    <div class="check-row d-flex align-items-center justify-content-between total-price">
                        <h5>Total</h5>
                        <span class="price"> {{ Cart::getTotal() }} <span>KWD</span></span>
                    </div>
                    <span class="payment-note">{{ __('Note: The amount paid is not refundable or exchangeable') }}</span>
                    <div class="cart-payment">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="customRadioInline8" checked="checked" name="customRadioInline1" class="custom-control-input">
                            <label class="custom-control-label" for="customRadioInline8"> @lang('Pay with')<img class="" src="{{ asset('frontend/images/payments.svg') }}" alt=""></label>
                        </div>
                    </div>
                    <button type="submit" id="submit" class="btn theme-btn2 w-100" style="width: 100%">{{__('Pay')}}</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>



@stop
