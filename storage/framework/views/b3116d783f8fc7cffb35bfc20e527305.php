<?php

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Enums\PaymentType;

?>
<?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php $userDetails = $order->orderUserDetails; ?>

    <div class="modal fade custom-modal order-notification-popup" id="newOrderModal" tabindex="-1"
         aria-labelledby="newOrderModal"
         aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content border-radius">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-1">
                    <div class="text-center mb-4">
                        <h1 class="mb-4 font-18 text-center"><?php echo e($order->order_type == OrderType::Delivery ? trans('rest.food_order.delivery') : trans('rest.food_order.pickup')); ?></h1>
                        <h3 class="mb-2 font-16 text-center"><?php echo e($order->delivery_time); ?> </h3>
                        <?php
                            $currentUrl = url()->previous(); // or you can use Request::url()
                            $hasOrders = strpos($currentUrl, '/orders') !== false;
                        ?>
                        <?php if($hasOrders): ?>
                            <button class="btn btn-site-theme fw-400 text-uppercase font-sebibold px-5 mt-2 font-18 order_details_button" data-id="<?php echo e($order->id); ?>" onclick="orderDetail(<?php echo e($order->id); ?>)" ><?php echo e(trans('rest.food_order.order_details')); ?></button>
                        <?php else: ?>
                            <a href="<?php echo e(route('orders', ['date_filter' => $order->id])); ?>" target="_blank"
                               class="btn btn-site-theme fw-400 text-uppercase font-sebibold px-5 mt-2 font-18 order_details_button"><?php echo e(trans('rest.food_order.order_details')); ?></a>
                        <?php endif; ?>

                    </div>
                    <div class="orderTop d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                        <div class="left d-flex align-items-center">
                            <h3 class="font-14"><?php echo e(trans('rest.food_order.order')); ?> #<?php echo e($order->id); ?></h3>
                            <h3 class="font-14">&nbsp;<?php echo e($order->created_at); ?></h3>
                        </div>
                        <div class="right d-flex align-items-center ml-auto font-14">
                            <h3 class="font-14"><i class="fa fa-phone font-12 text-yellow-2"></i> +31 <?php echo e($userDetails->order_contact_number ?? "-"); ?> </h3>
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="col-md-6 mb-3">
                            <div class="font-14">
                                <h3 class="font-14"><i class="fa fa-location-dot font-12 text-yellow-2"></i>
                                    <?php if($order->order_type == OrderType::Delivery): ?>
                                        <?php
                                        echo $userDetails->house_no . ', ' . $userDetails->street_name . ', ' . $userDetails->city . ', ' . $userDetails->zipcode;
                                        ?>
                                    <?php else: ?>
                                        <?php echo e(getRestaurantDetail()->rest_address); ?>

                                    <?php endif; ?>
                                </h3>
                                <?php if($order->delivery_note): ?>
                                    <p><span class="text-black"><?php echo e(trans('rest.food_order.instruction')); ?>:</span>
                                        <?php echo e($order->delivery_note ?? '-'); ?>

                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>


                        <div class="col-md-5 text-md-left mb-3">
                            <div class="font-14">
                                <h4 class="text-black-50 font-14"><span class="text-black"><?php echo e(trans('rest.food_order.delivery_mode')); ?>:</span>
                                    <?php echo e($order->delivery_time); ?></h4>
                                <h4 class="text-black-50 font-14"><span class="text-black"><?php echo e(trans('rest.food_order.payment_method')); ?>:</span>
                                    <?php echo e($order->payment_type == PaymentType::Card ? trans('rest.food_order.card'): ($order->payment_type == PaymentType::Cash ? trans('rest.food_order.cod'):'Ideal')); ?>

                                </h4>
                                <h4 class="text-black-50 font-14"><span class="text-black"><?php echo e(trans('rest.food_order.order_type')); ?>:</span>
                                    <?php echo e($order->order_type == OrderType::Delivery ? trans('rest.food_order.delivery') : trans('rest.food_order.pickup')); ?>

                                </h4>
                            </div>
                        </div>
                    </div>

                    <div class="items-list-order">
                        <h3 class="cart-title mb-4"><?php echo e(trans('rest.food_order.item_list')); ?>

                            (<?php echo e(count($order->dishDetails)); ?>

                            x <?php echo e(trans('rest.food_order.items')); ?>)</h3>

                        <div class="orders_item justify-content-between">
                            <?php $__currentLoopData = $order->dishDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="ord_item">
                                    <h2><span class="me-2 d-inline-block"><?php echo e($item->qty); ?> x</span> <?php echo e($item->dish->name); ?></h2>
                                    <h4 class="total_amount" >+€<?php echo e((($item->price * $item->qty) + $item->paid_ingredient_total)); ?></h4>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH E:\wamp\www\go-meal\resources\views/admin/orders/new-order-popup.blade.php ENDPATH**/ ?>