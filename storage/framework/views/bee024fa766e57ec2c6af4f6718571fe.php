<?php

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Enums\PaymentStatus;
use App\Enums\PaymentType;

$userDetails = $order->orderUserDetails;

?>
<style>
    .text-green {
        color: var(--theme-success3) !important;
    }
</style>
<div class="footer-box-details-header d-flex align-items-center justify-content-between gap-lg-3 flex-wrap">
    <ul class="list-inline text-grp mb-0 p-0 d-flex align-items-center flex-fill">
        <li class="list-inline-item d-flex align-items-center"><?php echo e(trans('rest.food_order.order')); ?>

            #<?php echo e($order->id); ?></li>
        <li class="list-inline-item d-flex align-items-center"><?php echo e($order->created_at); ?></li>
    </ul>
    <ul class="d-inline-flex flex-wrap gap-3 contact-list mb-0 p-0 justify-content-end">
        <li class="list-inline-item">
            <a href="#" class="d-flex align-items-center gap-2">
                <img src="<?php echo e(asset('images/user-icon-up.svg')); ?>" alt="user" class="img-fluid svg" width="17"
                     height="18">
                <?php echo e($userDetails->order_name); ?>

            </a>
        </li>
        <li class="list-inline-item">
            <a href="#" class="d-flex align-items-center gap-2">
                <img src="<?php echo e(asset('images/call-icon-up.svg')); ?>" alt="call" class="img-fluid svg" width="19"
                     height="19">
                +31 <?php echo e($userDetails->order_contact_number); ?>

            </a>
        </li>
    </ul>
</div>
<div class="footer-box-main archive-footer-box-main">
    <div class="footer-box-main-orderdetails d-flex justify-content-between   ">
        <div class="footer-box-main-orderdetails-item d-flex align-items-start gap-2">
            <img src="<?php echo e(asset('images/location-yellowicon-up.svg')); ?>" alt="" class="img-fluid svg" width="13" height="18"
                 style="margin-top: 1px;">
            <div class="text-grp ms-0">
                <?php if($order->order_type == OrderType::Delivery): ?>
                    <div class="title mb-2">
                            <?php
                            echo $userDetails->house_no . ', ' . $userDetails->street_name . ', ' . $userDetails->city . ', ' . $userDetails->zipcode;
                            ?>
                    </div>
                <?php else: ?>
                    <div class="title mb-2">
                        <?php echo e(getRestaurantDetail()->rest_address); ?>

                    </div>
                <?php endif; ?>
                <div class="text">
                    <span><?php echo e(trans('rest.food_order.instruction')); ?>:</span> <?php echo e($order->delivery_note ?? '-'); ?>

                </div>
            </div>
        </div>
        <div class="footer-box-main-orderdetails-item d-flex align-items-start gap-2">
            <div class="text-grp">
                <div class="text">
                    <span><?php echo e(trans('rest.food_order.delivery_mode')); ?>: </span><?php echo e($order->delivery_time); ?>

                </div>
                <div class="text">
                    <span><?php echo e(trans('rest.food_order.payment_method')); ?>: </span><?php echo e($order->payment_type == PaymentType::Card ? trans('rest.food_order.card'): ($order->payment_type == PaymentType::Cash ? trans('rest.food_order.cod'):'Ideal')); ?>

                </div>
                <div class="text">
                    <span><?php echo e(trans('rest.food_order.type')); ?>: </span><?php echo e($order->order_type == OrderType::Delivery ? trans('rest.food_order.delivery'):trans('rest.food_order.pickup')); ?>

                </div>
            </div>
        </div>
    </div>
    <div class="footer-box-main-progressbar position-relative d-flex align-items-center justify-content-between gap-1">
        <div
            class="active footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
            <div class="img d-flex align-items-center justify-content-center cursor-pointer">
                <img src="<?php echo e(asset('images/order-accept.svg')); ?>" class="img-fluid svg" width="18" height="18">
            </div>
            <div class="text"><?php echo e(trans('rest.order_status.accepted')); ?></div>
        </div>

        <?php $order_status = trans('rest.order_status.in_kitchen'); ?>
        <?php if($order->order_status >= OrderStatus::InKitchen): ?>
            <div
                class="active footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                <div class="img d-flex align-items-center justify-content-center cursor-pointer">
                    <img src="<?php echo e(asset('images/orderinkitchen-black.svg')); ?>" class="img-fluid svg" width="25"
                         height="19">
                </div>
                <div class="text"><?php echo e($order_status); ?></div>
            </div>
        <?php else: ?>
            <div
                class="footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                <div class="img d-flex align-items-center justify-content-center cursor-pointer">
                    <img src="<?php echo e(asset('images/orderinkitchen-white.svg')); ?>" class="img-fluid svg" width="25"
                         height="19">
                </div>
                <div class="text"><?php echo e($order_status); ?></div>
            </div>
        <?php endif; ?>

        <?php if($order->order_type == OrderType::Delivery): ?>
                <?php $order_status = trans('rest.order_status.ready'); ?>
            <?php if($order->order_status >= OrderStatus::Ready): ?>
                <div
                    class="active footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                    <div class="img d-flex align-items-center justify-content-center cursor-pointer">
                        <img src="<?php echo e(asset('images/pickup-black.svg')); ?>" class="img-fluid svg" width="19" height="19">
                    </div>
                    <div class="text"><?php echo e($order_status); ?></div>
                </div>
            <?php else: ?>
                <div
                    class="footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                    <div class="img d-flex align-items-center justify-content-center cursor-pointer">
                        <img src="<?php echo e(asset('images/pickup-white.svg')); ?>" class="img-fluid svg" width="19" height="19">
                    </div>
                    <div class="text"><?php echo e($order_status); ?></div>
                </div>
            <?php endif; ?>

                <?php $order_status = trans('rest.order_status.out_for_delivery'); ?>
            <?php if($order->order_status >= OrderStatus::OutForDelivery): ?>
                <div
                    class="active footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                    <div class="img d-flex align-items-center justify-content-center cursor-pointer">
                        <img src="<?php echo e(asset('images/out-for-delivery-black.svg')); ?>" class="img-fluid svg" width="27"
                             height="20">
                    </div>
                    <div class="text"><?php echo e($order_status); ?></div>
                </div>
            <?php else: ?>
                <div
                    class="footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                    <div class="img d-flex align-items-center justify-content-center cursor-pointer">
                        <img src="<?php echo e(asset('images/out-for-delivery.svg')); ?>" class="img-fluid svg" width="27"
                             height="20">
                    </div>
                    <div class="text"><?php echo e($order_status); ?></div>
                </div>
            <?php endif; ?>

                <?php $order_status = trans('rest.order_status.delivered'); ?>
            <?php if($order->order_status >= OrderStatus::Delivered): ?>
                <div
                    class="active footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                    <div class="img d-flex align-items-center justify-content-center cursor-pointer">
                        <img src="<?php echo e(asset('images/order-accept.svg')); ?>" class="img-fluid svg" width="19" height="19">
                    </div>
                    <div class="text"><?php echo e($order_status); ?></div>
                </div>
            <?php else: ?>
                <div
                    class="footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                    <div class="img d-flex align-items-center justify-content-center cursor-pointer">
                        <img src="<?php echo e(asset('images/delivered.svg')); ?>" class="img-fluid svg" width="19" height="19">
                    </div>
                    <div class="text"><?php echo e($order_status); ?></div>
                </div>
            <?php endif; ?>
        <?php else: ?>
                <?php $order_status = trans('rest.order_status.ready_for_pickup'); ?>
            <?php if($order->order_status >= OrderStatus::ReadyForPickup): ?>
                <div
                    class="active footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                    <div class="img d-flex align-items-center justify-content-center cursor-pointer">
                        <img src="<?php echo e(asset('images/pickup-black.svg')); ?>" class="img-fluid svg" width="19" height="19">
                    </div>
                    <div class="text"><?php echo e($order_status); ?></div>
                </div>
            <?php else: ?>
                <div
                    class="footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                    <div class="img d-flex align-items-center justify-content-center cursor-pointer">
                        <img src="<?php echo e(asset('images/pickup-white.svg')); ?>" class="img-fluid svg" width="19" height="19">
                    </div>
                    <div class="text"><?php echo e($order_status); ?></div>
                </div>
            <?php endif; ?>

                <?php $order_status = trans('rest.order_status.delivered'); ?>
            <?php if($order->order_status >= OrderStatus::Delivered): ?>
                <div
                    class="active footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                    <div class="img d-flex align-items-center justify-content-center cursor-pointer">
                        <img src="<?php echo e(asset('images/order-accept.svg')); ?>" class="img-fluid svg" width="19" height="19">
                    </div>
                    <div class="text"><?php echo e($order_status); ?></div>
                </div>
            <?php else: ?>
                <div
                    class="footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                    <div class="img d-flex align-items-center justify-content-center cursor-pointer">
                        <img src="<?php echo e(asset('images/delivered.svg')); ?>" class="img-fluid svg" width="19" height="19">
                    </div>
                    <div class="text"><?php echo e($order_status); ?></div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <div class="footer-box-main-orderlist">
        <div class="footer-box-main-orderlist-header d-flex align-items-center justify-content-between">
            <div class="text-grp d-flex align-items-center gap-1">
                <div class="title"><?php echo e(trans('rest.food_order.order_list')); ?> :</div>
                <div class="number">(<?php echo e(count($order->dishDetails)); ?> x <?php echo e(trans('rest.food_order.items')); ?>)</div>
            </div>
            <button id="toggleOrderList"
                class="bg-transparent border-0 d-flex align-items-center justify-content-center">
                <img src="<?php echo e(asset('images/upward-arrow.svg')); ?>" alt="call"
                    class="uparrowOrderList" class="img-fluid svg" width="17"
                    height="10">

                <img src="<?php echo e(asset('images/downward-arrow.svg')); ?>"
                    class="downarrowOrderList" style="display: none !important;"
                    alt="call" class="img-fluid svg" width="17"
                    height="10">
            </button>
        </div>
        <div class="footer-box-main-orderlist-main d-flex flex-column" id="orderList">
            <?php $itemTotalPrice = 0;  $dishIngredientsTotalAmount = 0;?>
            <?php $__currentLoopData = $order->dishDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $dish): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="footer-box-main-orderlist-main-item d-flex">
                    <div class="text-grp orderRead-more">
                    <span><?php echo e($dish->qty); ?>x</span>

                       <div class="content-for-orders">
                       <div class="title"><?php echo e($dish->dish->name); ?></div>
                         <div class="text" id="order-ingredient-<?php echo e($dish->id); ?>">
                             
                            <?php if(count($dish->orderDishOptionDetails) > 0): ?>
                                 <b><span style="font-size: 12px"> Options </span></b>
                                 <?php
                                     /*old code comment on 13-08-2024*/
                                     $htmlStringDishOptionCategory = getDishOptionCategoryName($dish->orderDishOptionDetails->pluck('dish_option_id')) ?? '' ;
                                     $cleanedDishOptionHtmlString = str_replace(
                                         '"',
                                         '',
                                         $htmlStringDishOptionCategory,
                                     );
                                 $dishIngredientsTotalAmount = getDishOptionCategoryTotalAmount($dish->orderDishOptionDetails->pluck('dish_option_id'));
                                 ?>
                                 <ul class="items-additional mb-2"
                                     id="item-ing-desc">
                                     <?php echo $cleanedDishOptionHtmlString; ?>

                                 </ul>
                             <?php else: ?>
                                 <?php $dishIngredientsTotalAmount = 0 ;?>
                            <?php endif; ?>
                            <?php echo e(getOrderDishIngredients($dish)); ?>

                        </div>

                       </div>
                    </div>
                    <?php if(!empty($dish->notes)): ?>
                            <div class="notes">
                                <u><?php echo e($dish->notes); ?></u>
                            </div>
                        <?php endif; ?>
                    <div class="price d-flex flex-column">
                            <?php $itemPrice = ($dish->price * $dish->qty) + $dish->paid_ingredient_total + $dishIngredientsTotalAmount; ?>
                        <div class="title">€<?php echo e(number_format($itemPrice, 2)); ?></div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <div class="footer-main-total">
        <div class="footer-main-total-header d-flex align-items-center justify-content-between">
            <div class="text-grp d-flex align-items-center gap-2">
                <div class="title"><?php echo e(trans('rest.food_order.total')); ?> :</div>
                <div class="number">€<?php echo e(number_format(getOrderGrossAmount($order), 2)); ?></div>
            </div>
            <button id="toggleTotal"
            class="bg-transparent border-0 d-flex align-items-center justify-content-center">
            <img src="<?php echo e(asset('images/upward-arrow.svg')); ?>" alt="call"
                class="uparrowTotal" class="img-fluid svg" width="17"
                height="10">

            <img src="<?php echo e(asset('images/downward-arrow.svg')); ?>"
                class="downarrowTotal" style="display: none !important;"
                alt="call" class="img-fluid svg" width="17"
                height="10">
        </button>
        </div>
        <div class="footer-main-total-main" id="totalList">
            <div class="title"><?php echo e(trans('rest.food_order.bill_details')); ?></div>
            <div class="text-grp d-flex flex-column gap-3">
                <div class="text d-flex align-items-center justify-content-between gap-2">
                    <div class="key"><?php echo e(trans('rest.food_order.item_total')); ?></div>
                    <div class="value">€<?php echo e(number_format(getOrderGrossAmount($order), 2)); ?></div>
                </div>
                <div class="text d-flex align-items-center justify-content-between gap-2" <?php echo e($order->platform_charge > 0 ? '' : 'style=display:none'); ?>>
                    <div class="key"><?php echo e(trans('rest.food_order.service_charge')); ?></div>
                    <div class="value">€<?php echo e(number_format($order->platform_charge, 2)); ?></div>
                </div>

                <div class="text d-flex align-items-center justify-content-between gap-2" style="<?php echo e($order->order_type == '2' ? 'display:none !important;' : ''); ?>">
                    <div
                        class="key"><?php echo e($order->delivery_charge ?   trans('user.my_orders.delivery_charges') :  trans('user.my_orders.delivery')); ?></div>
                    <div class="value <?php echo e($order->delivery_charge > 0 ? '' : 'text-green'); ?>">
                        <?php echo e($order->delivery_charge > 0 ? '€'.number_format($order->delivery_charge, 2) : 'FREE'); ?>

                    </div>
                </div>

                <div class="active text d-flex align-items-center justify-content-between gap-2">
                    <div class="key"><?php echo e(trans('rest.food_order.discount')); ?></div>
                    <div class="value">-€<?php echo e(number_format($order->coupon_discount, 2)); ?></div>
                </div>
            </div>
        </div>
        <div class="footer-main-total-footer">
            <div class="text-grp d-flex align-items-center gap-2 justify-content-between">
                <div class="key"><?php echo e(trans('rest.food_order.total')); ?></div>
                <div class="value">€<?php echo e(number_format($order->total_amount,2)); ?></div>
            </div>
        </div>
    </div>
</div>

<?php /**PATH E:\wamp\www\go-meal\resources\views/admin/archive/order-detail.blade.php ENDPATH**/ ?>