@extends('layouts.app')
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
            padding: 20px;
            max-width: 342px;
            margin: auto;
            border: 1px solid #ddd;
            padding: 20px;
            margin-top: 10px !important;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 100px;
            margin-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section p {
            margin: 5px 0;
        }

        .bold {
            font-weight: bold;
        }

        .amount-description-price {
            display: flex;
            justify-content: space-between;
        }

        .amount-description-bottom {
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
            /* justify-content: space-between; */
            font-weight: bold;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
            margin-bottom: 5px;
            padding-top: 10px;
        }

        .amount-description-price-header p:last-child,
        .amount-description-price p:last-child {
            margin-left: auto;
        }

        .amount-description-price-header p:first-child,
        .amount-description-price p:first-child {
            flex: 0 0 80px;
            max-width: 80px;
        }
        .amount-description-price-no-flex {
            text-align: center;
        }
        .amount-description-price span {
            font-size: 12px;
        }

        .amount-description-price p {
            margin-top: 5px;
        }
    </style>
    <div class="main">
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
                    <?php $itemPrice = ($dish->price * $dish->qty) + $dish->paid_ingredient_total; ?>

                    <div class="amount-description-price">
                        <p>{{$dish->qty }}x</p>
                        <p>{{ $dish->dish->name }}
                            <br>
                            <span>{!! getOrderDishIngredients2($dish) !!}</span>
                        </p>
                        <p>€{{ $itemPrice }}</p>
                    </div>
                @endforeach

                <br />

                <div class="amount-description-bottom">
                    <p>{{ trans('rest.food_order.tax') }}</p>
                    <p>€{{  round($order->tax_amount, 2) }}</p>
                </div>
                <div class="amount-description-bottom">
                    <p>{{ trans('rest.food_order.sub_total') }}</p>
                    <p>€{{  round($order->sub_total, 2) }}</p>
                </div>
                <div class="amount-description-bottom">
                    <p>{{ trans('rest.food_order.item_total') }}</p>
                    <p>€{{  round(getOrderGrossAmount($order), 2) }}</p>
                </div>
                <div class="amount-description-bottom">
                    <p>{{ trans('rest.food_order.service_charge') }}</p>
                    <p>€{{ $order->platform_charge }}</p>
                </div>
                <div class="amount-description-bottom">
                    <p>{{ $order->delivery_charge ? trans('rest.food_order.delivery_charge'):trans('rest.food_order.free_delivery') }}</p>
                    <p>€{{ $order->delivery_charge }}</p>
                </div>
                <div class="amount-description-bottom" style="color: #4ECA39">
                    <p>{{ trans('rest.food_order.discount') }}</p>
                    <p>-€{{ $order->coupon_discount }}</p>
                </div>
                <div class="amount-description-bottom">
                    <p>{{ trans('rest.food_order.total') }}</p>
                    <p>€{{ round($order->total_amount, 2) }}</p>
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
@endsection
