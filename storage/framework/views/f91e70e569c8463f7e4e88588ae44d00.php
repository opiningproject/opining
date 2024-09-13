<?php

use App\Enums\OrderStatus;
use App\Enums\OrderType;

?>


<?php if(count($orders)): ?>
    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $active = ''
            ?>
        <?php if($activeId != 0 && $orderExist): ?>
            <?php if($order->id == $activeId): ?>
                    <?php
                    $active = 'active';
                    ?>
            <?php endif; ?>
        <?php else: ?>
            <?php if($key ==  0): ?>
                    <?php
                    $active = 'active';
                    ?>
            <?php endif; ?>
        <?php endif; ?>
        <div class="foodorder-box-list-item d-flex order-<?php echo e($order->id); ?>"
             onclick="orderDetailArchive(<?php echo e($order->id); ?>)" id="order-<?php echo e($order->id); ?>" data-id="<?php echo e($order->id); ?>">
            <div class="details w-100 d-flex flex-column gap-3">
                <div class="title"><?php echo e(trans('rest.food_order.order')); ?>

                    #<?php echo e($order->id); ?> | <?php echo e($order->created_at); ?></div>
                <div
                    class="icontext-grp d-flex align-items-center justify-content-between">
                    <div class="icontext-item d-flex align-items-center gap-1">
                        <img src="<?php echo e(asset('images/fork-knife-icon.svg')); ?>"
                             class="img-fluid svg" alt="" height="22" width="22">
                        <div
                            class="text"><?php echo e($order->order_type == OrderType::Delivery ? trans('rest.food_order.delivery'):trans('rest.food_order.pickup')); ?> </div>
                    </div>
                    <div class="icontext-item d-flex align-items-center gap-1">
                        <img src="<?php echo e(asset('images/hand-money-icon.svg')); ?>" alt=""
                             class="img-fluid svg" width="30" height="29">
                        <div class="text total_amount">
                            €<?php echo e(number_format($order->total_amount, 2)); ?></div>
                    </div>
                </div>
            </div>
            <div
                class="time d-flex flex-column align-items-center justify-content-center text-center gap-1">
                <img
                    src="<?php echo e(asset('images/clock-gray.svg')); ?>"
                    alt="time"
                    class="img-fluid svg" width="29" height="29">
                <div class="text"><?php echo e($order->delivery_time); ?></div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
    <span class="no-data"><?php echo e(trans('rest.food_order.no_order')); ?></span>
<?php endif; ?>
<?php /**PATH E:\wamp\www\go-meal\resources\views/admin/archive/orders-list.blade.php ENDPATH**/ ?>