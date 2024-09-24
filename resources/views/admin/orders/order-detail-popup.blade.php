<?php

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Enums\RefundStatus;

$userDetails = $order->orderUserDetails;

?>

<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header border-0">
            <div class="head-flex">
                <h3 class="mb-0">
                    {{ $order->order_type == OrderType::Delivery ? trans('rest.food_order.delivery') : trans('rest.food_order.pickup') }}
                    ORDER #{{ $order->id }}</h3>
                <h3 class="mb-0">{{ trans('modal.order_detail.website_order') }}</h3>
                <h3 class="mb-0">{{ date('d-m-Y H:i', strtotime($order->created_at)) }}</h3>
            </div>
        </div>

        <div class="modal-body pt-1 pb-0">
            <div class="border-0 d-flex align-items-center justify-content-between mb-0">

                <div class="order-status">

                    <div class="order-col">
                        <label
                            class="status-option order-status-option {{ $order->order_status == OrderStatus::Accepted ? 'active' : '' }}">
                            <input id="test1" type="radio" name="orderStatus"
                                {{ $order->order_status == OrderStatus::Accepted ? 'checked' : '' }} />
                            <span for="test1"></span>
                            <label>{{ trans('modal.order_detail.new_order') }}</label>
                        </label>
                    </div>

                    <div class="order-col">
                        <label
                            class="order-status-option status-option {{ $order->order_status == OrderStatus::InKitchen ? 'active' : '' }}">
                            <input id="test2" type="radio" name="order-status-option"
                                {{ $order->order_status == OrderStatus::InKitchen ? 'checked' : '' }}
                                onclick="changeOrderStatusNew({{ $order->id }},'{{ OrderStatus::InKitchen }}')" />
                            <span for="test2"></span>
                            <label>{{ trans('modal.order_detail.in_kitchen') }}</label>
                        </label>
                    </div>
                    @if ($order->order_type == OrderType::Delivery)
                        <div class="order-col">
                            <label
                                class="order-status-option status-option {{ $order->order_status == OrderStatus::OutForDelivery ? 'active' : '' }}">
                                <input id="test3" type="radio" name="order-status-option"
                                    {{ $order->order_status == OrderStatus::OutForDelivery ? 'checked' : '' }}
                                    onclick="changeOrderStatusNew({{ $order->id }},'{{ OrderStatus::OutForDelivery }}')" />
                                <span for="test3"></span>
                                <label>{{ trans('modal.order_detail.out_for_delivery') }}</label>
                            </label>
                        </div>
                    @else
                        <div class="order-col">
                            <label
                                class="order-status-option status-option {{ $order->order_status == OrderStatus::ReadyForPickup ? 'active' : '' }}">
                                <input id="test3" type="radio" name="order-status-option"
                                    {{ $order->order_status == OrderStatus::ReadyForPickup ? 'checked' : '' }}
                                    onclick="changeOrderStatusNew({{ $order->id }},'{{ OrderStatus::ReadyForPickup }}')" />
                                <span for="test3"></span>
                                <label>{{ trans('modal.order_detail.ready_for_pickup') }}</label>
                            </label>
                        </div>
                    @endif

                    <div class="order-col">
                        <label
                            class="order-status-option status-option {{ $order->order_status == OrderStatus::Delivered ? 'active' : '' }}">
                            <input id="test4" type="radio" name="order-status-option"
                                {{ $order->order_status == OrderStatus::Delivered ? 'checked' : '' }}
                                onclick="changeOrderStatusNew({{ $order->id }},'{{ OrderStatus::Delivered }}')" />
                            <span for="test4"></span>
                            <label>{{ trans('modal.order_detail.delivered') }}</label>
                        </label>
                    </div>
                </div>

            </div>
            <div class="clearfix">
                <ul class="nav nav-tabs justify-content-between" id="myTab" role="tablist">
                    <!-- First Tab -->
                    <li class="nav-item" role="presentation" style="width: 33%;">
                        <button class="nav-link active w-100" id="tab-1" data-bs-toggle="tab"
                            data-bs-target="#content-1" type="button" role="tab" aria-controls="content-1"
                            aria-selected="true">{{ trans('modal.order_detail.customer_data') }}</button>
                    </li>
                    <!-- Second Tab -->
                    <li class="nav-item" role="presentation" style="width: 33%;">
                        <button class="nav-link w-100" id="tab-2" data-bs-toggle="tab" data-bs-target="#content-2"
                            type="button" role="tab" aria-controls="content-2" aria-selected="false">
                            {{ trans('modal.order_detail.order_item', ['number_of_dish' => count($order->dishDetails)]) }}
                        </button>
                    </li>
                    <!-- Third Tab -->
                    <li class="nav-item" role="presentation" style="width: 33%;">
                        <button class="nav-link w-100" id="tab-3" data-bs-toggle="tab" data-bs-target="#content-3"
                            type="button" role="tab" aria-controls="content-3"
                            aria-selected="false">{{ trans('modal.order_detail.delivery') }}</button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content px-0 pb-0">
                    <!-- Content for Tab 1 -->
                    <div class="tab-pane fade show active" id="content-1" role="tabpanel" aria-labelledby="tab-1">
                        <div class="row">
                            <div class="col-lg-5 mb-3">
                                <div class="table-content">
                                    <table>
                                        <tr>
                                            <th>{{ trans('modal.order_detail.name') }}</th>
                                            <td>{{ $userDetails->order_name }}</td>
                                        </tr>

                                        <tr>
                                            <th>{{ trans('modal.order_detail.address') }}</th>
                                            <td>
                                                @if ($order->order_type == OrderType::Delivery)
                                                    {{ $userDetails->house_no . ', ' . $userDetails->street_name . ', ' . $userDetails->city . ', ' . $userDetails->zipcode }}
                                                @else
                                                    {{ getRestaurantDetail()->rest_address }}
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>{{ trans('modal.order_detail.phone') }}</th>
                                            <td>{{ $userDetails->order_contact_number }}</td>
                                        </tr>

                                        <tr>
                                            <th>{{ trans('modal.order_detail.email') }}</th>
                                            <td>{{ $userDetails->order_email }}</td>
                                        </tr>

                                        <tr>
                                            <th>{{ trans('modal.order_detail.order') }}</th>
                                            <td>{{ trans('modal.order_detail.total') }}
                                                €{{ number_format($order->total_amount, 2) }} <br />
                                                {{ $order->payment_type == PaymentType::Card ? trans('rest.food_order.card') : ($order->payment_type == PaymentType::Cash ? trans('rest.food_order.cod') : 'Ideal') }}
                                            </td>
                                        </tr>
                                        @if ($order->coupon_code)
                                            <tr>
                                                <th>{{ trans('modal.order_detail.promo_code') }}</th>
                                                <td>
                                                    <p class="text-uppercase">
                                                        {{ $order->coupon_code ? $order->coupon_code : '-' }}</p>
                                                </td>
                                            </tr>
                                        @endif
                                        @if ($order->delivery_note)
                                            <tr>
                                                <th>{{ trans('modal.order_detail.note') }}</th>
                                                <td>
                                                    <p class="text-underline">
                                                        {{ $order->delivery_note ? $order->delivery_note : '-' }}</p>
                                                </td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-7 mb-3">
                                <div class="timing-details mb-3">
                                    <div class="timing-row">
                                        <label>{{ trans('modal.order_detail.wished_time') }} </label>
                                        <div class="timing-col">
                                            <div class="t-box bg-transperent"></div>
                                            <div class="text-uppercase">{{ $order->delivery_time }}</div>
                                            <div class="t-box bg-transperent"></div>
                                        </div>
                                    </div>

                                    <div class="timing-row">
                                        <label>{{ trans('modal.order_detail.wished_time') }}</label>
                                        <div class="timing-col">
                                            <button class="t-box">-5</button>
                                            <div class="text-uppercase">
                                                {{ date('H:i', strtotime(\Carbon\Carbon::parse($order->created_at)->addMinutes($orderDeliveryTime))) }}
                                            </div>
                                            <button class="t-box">+5</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-map">
                                    <img src="{{ asset('images/tab-map.png') }}" alt="" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content for Tab 2 -->
                    <div class="tab-pane fade" id="content-2" role="tabpanel" aria-labelledby="tab-2">
                        <div class="row items-in-row">

                            <div class="col-12 mb-3">
                                <div class="dish-details-row">
                                    <?php $itemTotalPrice = 0;
                                    $dishIngredientsTotalAmount = 0; ?>
                                    @foreach ($order->dishDetails as $key => $dish)
                                        <div class="d-flex ord_listing mb-3">
                                            <div class="num-items d-flex gap-1">
                                                <h4>{{ $dish->qty }}X</h4>

                                                <div class="item-option">
                                                    <h5>{{ $dish->dish->name }}</h5>
                                                    @if (count($dish->orderDishOptionDetails) > 0)
                                                        <h6>Options</h6>
                                                        @php
                                                            /*old code comment on 13-08-2024*/
                                                            $htmlStringDishOptionCategory =
                                                                getDishOptionCategoryName(
                                                                    $dish->orderDishOptionDetails->pluck(
                                                                        'dish_option_id',
                                                                    ),
                                                                ) ?? '';
                                                            $cleanedDishOptionHtmlString = str_replace(
                                                                '"',
                                                                '',
                                                                $htmlStringDishOptionCategory,
                                                            );
                                                            $dishIngredientsTotalAmount = getDishOptionCategoryTotalAmount(
                                                                $dish->orderDishOptionDetails->pluck('dish_option_id'),
                                                            );
                                                        @endphp
                                                        <ul>
                                                            {!! $cleanedDishOptionHtmlString !!}
                                                        </ul>
                                                    @else
                                                        @php $dishIngredientsTotalAmount = 0 ;@endphp
                                                    @endif
                                                    <div class="dish-ing">
                                                        {{ getOrderDishIngredients($dish) }}
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $itemPrice = $dish->price * $dish->qty + $dish->paid_ingredient_total + $dishIngredientsTotalAmount; ?>
                                            <div class="price ms-auto">€{{ number_format($itemPrice, 2) }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content for Tab 3 -->
                    <div class="tab-pane fade" id="content-3" role="tabpanel" aria-labelledby="tab-3">

                        <div class="order-status order-delivered">

                            <div class="order-col">
                                <label class="status-option status-option-deliverers">
                                    <input id="test5" type="radio" name="status-option-deliverers" />
                                    <span for="test5"></span>
                                    <label>Serdar</label>
                                </label>
                            </div>

                            <div class="order-col">
                                <label class="status-option active status-option-deliverers">
                                    <input id="test6" type="radio" name="status-option-deliverers" checked />
                                    <span for="test6"></span>
                                    <label>Jamal</label>
                                </label>
                            </div>

                            <div class="order-col">
                                <label class="status-option status-option-deliverers">
                                    <input id="test7" type="radio" name="status-option-deliverers" />
                                    <span for="test7"></span>
                                    <label>Krish</label>
                                </label>
                            </div>

                            <div class="order-col">
                                <label class="status-option status-option-deliverers">
                                    <input id="test8" type="radio" name="status-option-deliverers" />
                                    <span for="test8"></span>
                                    <label>Daman</label>
                                </label>
                            </div>

                            <div class="order-col">
                                <label class="status-option status-option-deliverers">
                                    <input id="test8" type="radio" name="status-option-deliverers" />
                                    <span for="test8"></span>
                                    <label>Jack</label>
                                </label>
                            </div>

                            <div class="order-col">
                                <label class="status-option status-option-deliverers">
                                    <input id="test8" type="radio" name="status-option-deliverers" />
                                    <span for="test8"></span>
                                    <label>Peter</label>
                                </label>
                            </div>

                            <div class="order-col">
                                <label class="status-option status-option-deliverers">
                                    <input id="test8" type="radio" name="status-option-deliverers" />
                                    <span for="test8"></span>
                                    <label>Muhammad</label>
                                </label>
                            </div>

                            <div class="order-col">
                                <label class="status-option status-option-deliverers">
                                    <input id="test8" type="radio" name="status-option-deliverers" />
                                    <span for="test8"></span>
                                    <label>Youssef</label>
                                </label>
                            </div>

                            <div class="order-col">
                                <label class="status-option status-option-deliverers">
                                    <input id="test8" type="radio" name="status-option-deliverers" />
                                    <span for="test8"></span>
                                    <label>Sam</label>
                                </label>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer d-flex align-items-center justify-content-between">
            <div class="clearfix">
                <button type="button" class="btn btn-outline-danger text-danger"
                    data-bs-dismiss="modal">{{ trans('modal.order_detail.cancel') }}</button>
                <a class="btn btn-outline-secondary ms-2 text-secondary d-inline-flex align-items-center gap-3"
                    target="_blank"
                    href="{{ route('orders.printLabel', ['order_id' => $order->id]) }}">{{ trans('rest.food_order.print') }}</a>
            </div>

            <div class="clearfix d-flex align-items-center">
                @if ($order->delivery_note)
                    <h3 class="note d-flex align-items-center">{{ trans('modal.order_detail.see_note') }} <img
                            class="ms-1" src="{{ asset('images/note.png') }}" alt="" /></h3>
                @endif
                <h3 class="note d-flex align-items-center ms-3">
                    {{ $order->payment_type == PaymentType::Cash && $order->order_status != OrderStatus::Delivered ? trans('modal.order_detail.unpaid_order') : trans('modal.order_detail.paid_order') }}
                    <img class="ms-1" src="{{ asset('images/note.png') }}" alt="" />
                </h3>
                <button type="button" class="close-btn ms-3" data-bs-dismiss="modal"
                    aria-label="Close">Close</button>
            </div>
        </div>
    </div>
</div>
