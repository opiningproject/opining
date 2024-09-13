<?php $theme = \Request::session()->get('theme'); ?>

<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" data-theme="<?php echo e($theme); ?>">
<?php echo $__env->make('layouts.admin.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<body>

<div class="position-fixed inset-0 bg-transparent-layer d-none" id="loader">
    <img src="<?php echo e(asset('images/loader.gif')); ?>" style="height: 250px">
</div>

<?php echo $__env->yieldContent('content'); ?>


 <!-- start order category Modal -->
    <div class="order-modal-div" id="order-modal-div"></div>
 <!-- end order category  Modal -->
 <audio id="myaudio" src="<?php echo e(asset('/notificationSound/notification-sound.mp3')); ?>"> </audio>

<?php echo $__env->make('layouts.admin.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldContent('script'); ?>

</body>
</html>
<?php /**PATH E:\wamp\www\go-meal\resources\views/layouts/app.blade.php ENDPATH**/ ?>