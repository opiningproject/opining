<?php

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Enums\RefundStatus;

?>

<div class="tab-pane fade" id="paymentHistory-tab-pane" role="tabpanel" aria-labelledby="paymentHistory-tab" tabindex="0">
  <div class="card-body">
    <div class="paymentHistory-card-body border-custom-1 py-3 pt-0">
      <div class="paymentHistory-table custom-table">
        <table class="table mb-3">
          <thead>
            <tr>
              <th scope="col" class="text-center"><?php echo e(trans('rest.settings.payment.order_id')); ?></th>
              <th scope="col" class="text-center"><?php echo e(trans('rest.settings.payment.type')); ?></th>
              <th scope="col" class="text-center"><?php echo e(trans('rest.settings.payment.trans_id')); ?></th>
              <th scope="col" class="text-left"><?php echo e(trans('rest.settings.payment.delivery_add')); ?> </th>
              <th scope="col" class="text-center"><?php echo e(trans('rest.settings.payment.date_and_time')); ?> </th>
              <th scope="col" class="text-center"><?php echo e(trans('rest.settings.payment.total')); ?> </th>
            </tr>
          </thead>
          <tbody>
            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td class="text-center">
                <div><?php echo e($order->id); ?></div>
              </td>
              <td class="text-center">
                <div><?php echo e($order->payment_type == PaymentType::Card ? trans('rest.settings.payment.card'):($order->payment_type == PaymentType::Cash ? trans('rest.settings.payment.cash'):'Ideal')); ?></div>
              </td>
              <td class="text-center">
                <div><?php echo e($order->transaction_id ? $order->transaction_id : '-'); ?></div>
              </td>
              <td class="text-left">
                <div class="d-flex align-items-start gap-2 justify-content-start">
                  <img src="<?php echo e(asset('images/location-yellowicon-up.svg')); ?>" alt="" class="svg" height="18" width="13" style="flex: 0 0 18px">
                  <div class="text">
                    <?php
                      if($order->order_type == OrderType::Delivery)
                      {
                        $address = $order->orderUserDetails;

                        echo $address->house_no . ', ' . $address->street_name . ', ' . $address->city . ', ' . $address->zipcode;
                      }
                      else
                      {
                        echo getRestaurantDetail()->rest_address;
                      }
                    ?>
                  </div>
                </div>
              </td>
              <td class="text-center">
                <div class="text"><?php echo e($order->created_at); ?></div>
              </td>
              <td class="text-center">
                <div class="d-flex align-items-center gap-2 justify-content-center">
                  <div class="text fw-600">€<?php echo e($order->total_amount); ?></div>
                  <img src="<?php echo e(asset('images/checkmark.svg')); ?>" alt="" class="svg" height="14" width="14">
                </div>
              </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center" style="padding: 0 20px 0 20px;">
            <?php echo e($orders->links()); ?>

             <div class="ms-auto d-flex align-items-center custom-pagination justify-content-end w-100">
                <label class="text-nowrap"><?php echo e(trans('rest.button.rows_per_page')); ?></label>
                <select id="per_page_dropdown" class="form-control bg-white ms-2">
                    <?php for($i=5; $i<=20; $i+=5): ?>
                    <option <?php echo e($perPage == $i ? 'selected' : ''); ?> value="<?php echo e(Request::url().'?per_page='); ?><?php echo e($i); ?>">
                        <?php echo e($i); ?>

                    </option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>
      </div>
    </div>
  </div>
</div><?php /**PATH E:\wamp\www\go-meal\resources\views/admin/settings/payment-history.blade.php ENDPATH**/ ?>