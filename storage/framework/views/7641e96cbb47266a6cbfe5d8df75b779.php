<div class="tab-pane fade show active" id="all-orders" role="tabpanel" aria-labelledby="all-orders-tab">
    <div class="foodorder-box-list d-flex flex-column mt-2 order-list-data-div1 all-orders all-orders-new" id="order-list-data-div1">
    <?php

    use App\Enums\OrderStatus;
    use App\Enums\OrderType;

    ?>

    <?php if(count($allOrders)): ?>
        <?php $__currentLoopData = $allOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $ord): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div  class="<?php echo e($order->id == $ord->id ? 'active' : ''); ?> foodorder-box-list-item d-flex order-<?php echo e($ord->id); ?>"
                 onclick="orderDetail(<?php echo e($ord->id); ?>)" id="order-<?php echo e($ord->id); ?>" data-id="<?php echo e($ord->id); ?>">
                <div class="details w-100 d-flex flex-column gap-3">
                    <div class="title"><?php echo e(trans('rest.food_order.order')); ?>

                        #<?php echo e($ord->id); ?> | <?php echo e($ord->created_at); ?></div>
                    <div
                        class="icontext-grp d-flex align-items-center justify-content-between">
                        <div class="icontext-item d-flex align-items-center gap-1">
                            <img src="<?php echo e(asset('images/fork-knife-icon.svg')); ?>"
                                 class="img-fluid svg" alt="" height="22" width="22">
                            <div
                                class="text"><?php echo e($ord->order_type == OrderType::Delivery ? trans('rest.food_order.delivery'):trans('rest.food_order.pickup')); ?> </div>
                        </div>
                        <div class="icontext-item d-flex align-items-center gap-1">
                            <img src="<?php echo e(asset('images/hand-money-icon.svg')); ?>" alt=""
                                 class="img-fluid svg" width="30" height="29">
                            <div class="text total_amount">
                                €<?php echo e(number_format($ord->total_amount, 2)); ?></div>
                        </div>
                    </div>
                </div>
                <div
                    class="time d-flex flex-column align-items-center justify-content-center text-center gap-1 order-status-<?php echo e($ord->id); ?>">
                    <img
                        src="<?php echo e($ord->order_status >= OrderStatus::Delivered ? asset('images/clock-gray.svg') : asset('images/clock-gray.svg')); ?>"
                        alt="time"
                        class="img-fluid svg" width="29" height="29">
                    <div class="text"><?php echo e($ord->delivery_time); ?></div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <span class="no-data"><?php echo e(trans('rest.food_order.no_order')); ?></span>
    <?php endif; ?>
    </div>

</div>
<?php /**PATH E:\wamp\www\go-meal\resources\views/admin/orders/all.blade.php ENDPATH**/ ?>