<div class="tab-pane fade" id="open-orders" role="tabpanel" aria-labelledby="open-orders-tab">
    <div class="foodorder-box-list d-flex flex-column mt-2 order-list-data-div1" id="order-list-data-div">
    <?php

    use App\Enums\OrderStatus;
    use App\Enums\OrderType;

    ?>

    @if(count($openOrders) && $order != '')
            @foreach($openOrders as $key => $ord)
            <div  class="{{ $order->id == $ord->id ? 'active' : '' }} foodorder-box-list-item d-flex order-{{ $ord->id }}"
                 onclick="orderDetail({{ $ord->id }})" id="order-{{ $ord->id }}" data-id="{{ $ord->id }}">
                <div class="details w-100 d-flex flex-column gap-3">
                    <div class="title">{{ trans('rest.food_order.order') }}
                        #{{$ord->id}} | {{ $ord->created_at }}</div>
                    <div
                        class="icontext-grp d-flex align-items-center justify-content-between">
                        <div class="icontext-item d-flex align-items-center gap-1">
                            <img src="{{ asset('images/fork-knife-icon.svg') }}"
                                 class="img-fluid svg" alt="" height="22" width="22">
                            <div
                                class="text">{{ $ord->order_type == OrderType::Delivery ? trans('rest.food_order.delivery'):trans('rest.food_order.take_away') }} </div>
                        </div>
                        <div class="icontext-item d-flex align-items-center gap-1">
                            <img src="{{ asset('images/hand-money-icon.svg') }}" alt=""
                                 class="img-fluid svg" width="30" height="29">
                            <div class="text total_amount">
                                €{{ number_format($ord->total_amount, 2) }}</div>
                        </div>
                    </div>
                </div>
                <div
                    class="time d-flex flex-column align-items-center justify-content-center text-center gap-1 order-status-{{ $ord->id }}">
                    <img
                        src="{{ $ord->order_status >= OrderStatus::Delivered ? asset('images/clock-gray.svg') : asset('images/clock-gray.svg') }}"
                        alt="time"
                        class="img-fluid svg" width="29" height="29">
                    <div class="text">{{ $ord->delivery_time }}</div>
                </div>
            </div>
        @endforeach
    @else
        <span class="no-data">{{ trans('rest.food_order.no_order') }}</span>
    @endif

    </div>
</div>
