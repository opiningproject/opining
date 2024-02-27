<?php

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Enums\RefundStatus;

?>

<div class="tab-pane fade " id="refundPayment-tab-pane" role="tabpanel" aria-labelledby="refundPayment-tab" tabindex="0">
  <div class="card-body">
    <div class="refundPayment-card-body rounded-custom-12 border-custom-1 py-3 ">
      <div class="refundPayment-table custom-table">
        <table class="table mb-3">
          <thead>
            <tr>
              <th scope="col" class="text-center">Order Id</th>
              <th scope="col" class="text-center">User Name </th>
              <th scope="col" class="text-center">Date and Time </th>
              <th scope="col" class="text-center">Payment Type</th>
              <th scope="col" class="text-center">Transaction ID </th>
              <th scope="col" class="text-center">Price </th>
              <th scope="col" class="text-center" width="20%">Reason </th>
              <th scope="col" class="text-center">Action </th>
            </tr>
          </thead>
          <tbody>
            @foreach($refundRequests as $key => $order)
            <tr>
              <td class="text-center">
                <div>{{ $order->id }}</div>
              </td>
              <td class="text-center">
                <div>{{ $order->user->fullname }}</div>
              </td>
              <td class="text-center">
                <div>{{ $order->created_at }}</div>
              </td>
              <td class="text-center">
                <div>{{ $order->payment_type == PaymentType::Card ? 'Card': ($order->payment_type == PaymentType::Cash ? 'Cash':'Ideal') }}</div>
              </td>
              <td class="text-center">
                <div>{{ $order->transaction_id ? $order->transaction_id : '-' }}</div>
              </td>
              <td class="text-center">
                <div>€{{ $order->total_amount }}</div>
              </td>
              <td class="text-left">
                <div>{{ $order->refund_description }} </div>
              </td>
              <td class="text-center">
                <div class="d-flex align-items-center gap-3 flex-lg-wrap flex-xl-nowrap justify-content-center refund_status_box_{{ $order->id }}">
                  @if($order->refund_status == RefundStatus::Pending)
                  <a class="btn btn-custom-yellow btn-default d-block px-2 py-1 rounded-2" onclick="changeRefundStatus({{ $order->id }},'2')">
                    <span class="align-middle" style="font-size: 11px;">Reject</span>
                  </a>
                  <a class="btn btn-custom-yellow btn-default d-block px-2 py-1 rounded-2" onclick="changeRefundStatus({{ $order->id }},'1')">
                    <span class="align-middle" style="font-size: 11px;">Accept</span>
                  </a>
                  @else
                   {{ $order->refund_status == RefundStatus::Accepted ? 'Accepted':'Rejected' }}
                  @endif
                </div>
                <div class="refund_status_text_{{ $order->id }}"></div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center" style="padding: 0 20px 0 20px;">
            {{ $refundRequests->links() }}
            <div class="ms-auto d-flex align-items-center custom-pagination justify-content-end w-100">
                <label class="text-nowrap">Rows per Page</label>
                <select id="per_page_dropdown" onchange="" class="form-control bg-white ms-2">
                    @for($i=5; $i<=20; $i+=5)
                    <option {{ $perPage == $i ? 'selected' : '' }} value="{{ Request::url().'?per_page=' }}{{ $i }}">
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
</div>