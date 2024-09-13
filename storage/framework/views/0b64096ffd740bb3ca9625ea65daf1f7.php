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
              <th scope="col" class="text-center"><?php echo e(trans('rest.settings.payment.order_id')); ?></th>
              <th scope="col" class="text-center"><?php echo e(trans('rest.settings.payment.username')); ?> </th>
              <th scope="col" class="text-center"><?php echo e(trans('rest.settings.payment.date_and_time')); ?></th>
              <th scope="col" class="text-center"><?php echo e(trans('rest.settings.payment.type')); ?></th>
              <th scope="col" class="text-center"><?php echo e(trans('rest.settings.payment.trans_id')); ?></th>
              <th scope="col" class="text-center"><?php echo e(trans('rest.settings.payment.price')); ?></th>
              <th scope="col" class="text-center" width="20%"><?php echo e(trans('rest.settings.payment.reason')); ?> </th>
              <th scope="col" class="text-center"><?php echo e(trans('rest.button.action')); ?> </th>
            </tr>
          </thead>
          <tbody>
            <?php $__currentLoopData = $refundRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td class="text-center">
                <div><?php echo e($order->id); ?></div>
              </td>
              <td class="text-center">
                <div><?php echo e($order->user->fullname); ?></div>
              </td>
              <td class="text-center">
                <div><?php echo e($order->created_at); ?></div>
              </td>
              <td class="text-center">
                <div><?php echo e($order->payment_type == PaymentType::Card ? trans('rest.settings.payment.card'): ($order->payment_type == PaymentType::Cash ? trans('rest.settings.payment.cash'):'Ideal')); ?></div>
              </td>
              <td class="text-center">
                <div><?php echo e($order->transaction_id ? $order->transaction_id : '-'); ?></div>
              </td>
              <td class="text-center">
                <div>€<?php echo e($order->total_amount); ?></div>
              </td>
              <td class="text-left">
                <div><?php echo e($order->refund_description); ?> </div>
              </td>
              <td class="text-center">
                <div class="d-flex align-items-center gap-3 flex-lg-wrap flex-xl-nowrap justify-content-center refund_status_box_<?php echo e($order->id); ?>">
                  <?php if($order->refund_status == RefundStatus::Pending): ?>
                  <a class="btn btn-site-theme btn-default d-block px-2 py-1 rounded-2" onclick="changeRefundStatus(<?php echo e($order->id); ?>,'2')">
                    <span class="align-middle" style="font-size: 11px;"><?php echo e(trans('rest.settings.payment.reject')); ?></span>
                  </a>
                  <a class="btn btn-site-theme btn-default d-block px-2 py-1 rounded-2" onclick="changeRefundStatus(<?php echo e($order->id); ?>,'1')">
                    <span class="align-middle" style="font-size: 11px;"><?php echo e(trans('rest.settings.payment.accept')); ?></span>
                  </a>
                  <?php else: ?>
                   <?php echo e($order->refund_status == RefundStatus::Accepted ? trans('rest.settings.payment.accepted'):trans('rest.settings.payment.rejected')); ?>

                  <?php endif; ?>
                </div>
                <div class="refund_status_text_<?php echo e($order->id); ?>"></div>
              </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center" style="padding: 0 20px 0 20px;">
            <?php echo e($refundRequests->links()); ?>

            <div class="ms-auto d-flex align-items-center custom-pagination justify-content-end w-100">
                <label class="text-nowrap"><?php echo e(trans('rest.button.rows_per_page')); ?></label>
                <select id="per_page_dropdown" onchange="" class="form-control bg-white ms-2">
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
  </div>
<?php /**PATH E:\wamp\www\go-meal\resources\views/admin/settings/refund-history.blade.php ENDPATH**/ ?>