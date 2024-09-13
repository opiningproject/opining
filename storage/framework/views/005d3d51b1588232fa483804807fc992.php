<?php $theme = \Request::session()->get('theme'); ?>

    <!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" data-theme="<?php echo e($theme); ?>">
<?php echo $__env->make('layouts.user.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<body>

<div class="position-fixed inset-0 bg-transparent-layer d-none" id="loader">
    <img src="<?php echo e(asset('images/loader.gif')); ?>" style="height: 250px">
</div>

<?php echo $__env->yieldContent('content'); ?>



<?php if(!Auth::user()): ?>
    <?php echo $__env->make('user.modals.signup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('user.modals.forgot-password', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>

<?php echo $__env->make('user.modals.signin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layouts.user.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldContent('script'); ?>
</body>
</html>
<?php /**PATH E:\wamp\www\go-meal\resources\views/layouts/user-app.blade.php ENDPATH**/ ?>