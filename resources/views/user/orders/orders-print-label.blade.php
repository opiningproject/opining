@extends('layouts.user-app')
@section('title', 'Order Receipt')
@section('content')

    <?php

    use App\Enums\OrderStatus;
    use App\Enums\OrderType;
    use App\Enums\PaymentStatus;
    use App\Enums\PaymentType;
    use App\Enums\RefundStatus;

    ?>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 10px 15px !important; /* Adjust padding */
            max-width: 100%; /* Full width */
            font-size: 14px;
        }

        .header {
            text-align: center;
            margin-bottom: 10px; /* Adjust margin */
        }

        .header img {
            width: 80px; /* Adjust image size */
            margin-bottom: 5px; /* Adjust margin */
            filter: grayscale(100%) brightness(0%);
        }

        .header h1 {
            margin: 0;
            font-size: 20px; /* Adjust font size */
        }

        .section {
            margin-bottom: 5px; /* Adjust margin */
        }

        .section p {
            margin: 0px 0px; /* Adjust margin */
        }

        .bold {
            font-weight: bold;
        }

        .amount-description-price, .amount-description-bottom {
            display: flex;
            justify-content: space-between;
        }

        .total {
            font-weight: bold;
        }

        .center {
            text-align: center;
        }

        .amount-description-price-header {
            display: flex;
            font-weight: bold;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
            margin-bottom: 5px;
            padding-top: 5px;
        }

        .amount-description-price-header p:last-child,
        .amount-description-price p:last-child {
            margin-left: auto;
            padding-left: 5px;
        }

        .amount-description-price-header p:first-child,
        .amount-description-price p:first-child {
            flex: 0 0 35px;
            max-width: 35px;
        }

        .amount-description-price span {
            font-size: 12px;
        }

        .amount-description-price p {
            margin-top: 5px;
        }

        .back-arrow {
            position: absolute;
            top: 20px;
            left: 10px;
            z-index: 9;
        }

        .back-arrow svg{
            width: 20px;
            height: 20px;
        }

        @media print {
        .no-print {
            display: none !important;
        }
        }
    </style>
    <div class="main">


<div class="no-print" id="no_print">
    <a href="{{ route('user.ordersDetailMobile',['order_id' => $order->id]) }}" class="back-arrow">
    <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="512" height="512"><path d="M17.17,24a1,1,0,0,1-.71-.29L8.29,15.54a5,5,0,0,1,0-7.08L16.46.29a1,1,0,1,1,1.42,1.42L9.71,9.88a3,3,0,0,0,0,4.24l8.17,8.17a1,1,0,0,1,0,1.42A1,1,0,0,1,17.17,24Z"/></svg>
</a>
</div>

        @if(!empty($order))
        <?php $userDetails = $order->orderUserDetails; ?>
        <div class="header">
            <img src="{{ getRestaurantDetail()->restaurant_logo }}" class="web-logo">
            <h1> {{getRestaurantDetail()->restaurant_name}}</h1>
            <p> {{getRestaurantDetail()->rest_address}} <br> +{{ getRestaurantDetail()->phone_no }}</p>

        </div>

        <div class="section">
            <p><strong>{{ trans('rest.food_order.order') }}:</strong> #{{$order->id }}</p>
            <p><strong>{{trans('rest.food_order.order_time')}}:</strong> {{ $order->created_at }}</p>
            <p><strong>{{ trans('rest.food_order.delivery_mode') }}:</strong> {{ $order->delivery_time }}</p>
            <p><strong>{{ trans('rest.food_order.type') }}:</strong> {{ $order->order_type == OrderType::Delivery ? trans('rest.food_order.delivery'):trans('rest.food_order.pickup') }}</p>
        </div>

        <div class="section">

            <p><strong>{{$userDetails->order_name}}</strong></p>
            <p><strong>Tel:</strong> +31 {{ $userDetails->order_contact_number }}</p>

            @if($order->order_type == OrderType::Delivery)
                <p><strong>{{ $userDetails->house_no }} {{ $userDetails->street_name}}</strong></p>
                <p><strong>{{ $userDetails->city }} - {{$userDetails->zipcode}}</strong></p>

            @else
                <p><strong>{{ getRestaurantDetail()->rest_address }}</strong></p>
            @endif

        </div>

        <div class="section">
            <p><strong>{{ $order->delivery_note ?? '' }}</strong></p>
        </div>

        <div class="section">
            <div class="amount-description-price-header">
                <p>{{ trans('rest.food_order.order_amount') }}</p>
                <p>{{ trans('rest.food_order.order_description') }}</p>
                <p>{{ trans('rest.food_order.order_price') }}</p>
            </div>
            @foreach($order->dishDetails as $key => $dish)

            <div class="amount-description-price">
                <p>{{$dish->qty }}x</p>
                <p>{{ $dish->dish->name }}
                    @php
                      $dishIngredientsTotalAmount = getDishOptionCategoryTotalAmount($dish->orderDishOptionDetails->pluck('dish_option_id'));
                    @endphp
                    @if($dishIngredientsTotalAmount > 0)
                        <br>
                    @endif
                    <span><b> {!! getDishOptionCategoryName2($dish->orderDishOptionDetails->pluck('dish_option_id')) ?? '' !!} </b> </span>
                    <br>
                    <span>{!! getOrderDishIngredients2($dish) !!}</span>
                    <span><u>{{ $dish->notes }}</u></span>
                </p>
                <?php $itemPrice = ($dish->price * $dish->qty) + $dish->paid_ingredient_total + $dishIngredientsTotalAmount; ?>
                <p>€{{ number_format($itemPrice, 2) }}</p>
            </div>
            @endforeach

            <br />

            <div class="amount-description-bottom">
                <p>{{ trans('rest.food_order.tax') }}</p>
                <p>€{{  number_format($order->tax_amount, 2) }}</p>
            </div>
            <div class="amount-description-bottom">
                <p>{{ trans('rest.food_order.sub_total') }}</p>
                <p>€{{  number_format($order->sub_total, 2) }}</p>
            </div>
            <div class="amount-description-bottom">
                <p>{{ trans('rest.food_order.item_total') }}</p>
                <p>€{{  number_format(getOrderGrossAmount($order), 2) }}</p>
            </div>
            @if($order->platform_charge > 0)
            <div class="amount-description-bottom">
                <p>{{ trans('rest.food_order.service_charge') }}</p>
                <p>€{{ number_format($order->platform_charge, 2) }}</p>
            </div>
            @endif

            @if($order->delivery_charge > 0)
                <div class="amount-description-bottom">
                    <p>{{ $order->delivery_charge ? trans('rest.food_order.delivery_charge'):trans('rest.food_order.free_delivery') }}</p>
                    <p>€{{ number_format($order->delivery_charge, 2) }}</p>
                </div>
            @endif
            @if($order->coupon_discount > 0)
                <div class="amount-description-bottom">
                    <p>{{ trans('rest.food_order.discount') }}</p>
                    <p>-€{{ number_format($order->coupon_discount,2) }}</p>
                </div>
            @endif
            <div class="amount-description-bottom">
                <p>{{ trans('rest.food_order.total') }}</p>
                <p>€{{ number_format($order->total_amount, 2) }}</p>
            </div>
        </div>

        <div class="footer center">
            <p><strong>{{ trans('rest.food_order.payment_method') }} : </strong> {{ $order->payment_type == PaymentType::Card ? trans('rest.food_order.card'): ($order->payment_type == PaymentType::Cash ? trans('rest.food_order.cod'):'Ideal') }}</p>
            <p>{{ trans('rest.food_order.order_enjoy') }}</p>
        </div>
        @endif
    </div>
@endsection
@section('script')
    <script>
        $(function () {
            var interval = setInterval(makePrintLabel, 500);

            function makePrintLabel() {
                window.print()
                clearInterval(interval)
            }
        })

        function checkScreenSize() {
            if ($(window).width() <= 767) {
                $('#no_print').show();
            } else {
                $('#no_print').hide();
            }
        }

        checkScreenSize()
        // Add event listener for window resize
        $(window).on('resize', checkScreenSize);

    </script>
@endsection
