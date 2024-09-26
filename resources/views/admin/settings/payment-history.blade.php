<?php

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Enums\RefundStatus;

?>

<div class="tab-pane fade" id="paymentHistory-tab-pane" role="tabpanel" aria-labelledby="paymentHistory-tab" tabindex="0">

    <h2 class="content-title">Payment History</h2>

    <div class="card-body bg-white">
        <div class="paymentHistory-card-body border-custom-1 py-3 pt-0">
            <div class="paymentHistory-table custom-table">
                <table class="table mb-3">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">{{ trans('rest.settings.payment.order_id') }}</th>
                            <th scope="col" class="text-center">{{ trans('rest.settings.payment.type') }}</th>
                            <th scope="col" class="text-center">{{ trans('rest.settings.payment.trans_id') }}</th>
                            <th scope="col" class="text-left">{{ trans('rest.settings.payment.delivery_add') }} </th>
                            <th scope="col" class="text-center">{{ trans('rest.settings.payment.date_and_time') }}
                            </th>
                            <th scope="col" class="text-center">{{ trans('rest.settings.payment.total') }} </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $key => $order)
                            <tr>
                                <td class="text-center">
                                    <div>{{ $order->id }}</div>
                                </td>
                                <td class="text-center">
                                    <div>
                                        {{ $order->payment_type == PaymentType::Card ? trans('rest.settings.payment.card') : ($order->payment_type == PaymentType::Cash ? trans('rest.settings.payment.cash') : 'Ideal') }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div>{{ $order->transaction_id ? $order->transaction_id : '-' }}</div>
                                </td>
                                <td class="text-left">
                                    <div class="d-flex align-items-start gap-2 justify-content-start">
                                        <img src="{{ asset('images/location-yellowicon-up.svg') }}" alt=""
                                            class="svg" height="18" width="13" style="flex: 0 0 18px">
                                        <div class="text">
                                            <?php
                                            if ($order->order_type == OrderType::Delivery) {
                                                $address = $order->orderUserDetails;
                                            
                                                echo $address->house_no . ', ' . $address->street_name . ', ' . $address->city . ', ' . $address->zipcode;
                                            } else {
                                                echo getRestaurantDetail()->rest_address;
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="text">{{ $order->created_at }}</div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center gap-2 justify-content-center">
                                        <div class="text fw-600">€{{ $order->total_amount }}</div>
                                        <img src="{{ asset('images/checkmark.svg') }}" alt="" class="svg"
                                            height="14" width="14">
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-between align-items-center" style="padding: 0 20px 0 20px;">
                    {{ $orders->links() }}
                    <div class="ms-auto d-flex align-items-center custom-pagination justify-content-end w-100">
                        <label class="text-nowrap">{{ trans('rest.button.rows_per_page') }}</label>
                        <select id="per_page_dropdown" class="form-control bg-white ms-2">
                            @for ($i = 5; $i <= 20; $i += 5)
                                <option {{ $perPage == $i ? 'selected' : '' }}
                                    value="{{ Request::url() . '?per_page=' }}{{ $i }}">
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
