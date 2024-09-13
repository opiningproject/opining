<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, shrink-to-fit=no, user-scalable=no" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', config('app.name', 'Laravel')); ?></title>
    <!-- Bootstrap CSS -->
    <link href="<?php echo e(asset('css/bootstrap.min.css')); ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo e(asset('css/font_bootstrap_icons.css')); ?>">
    <link rel="shortcut icon" href="<?php echo e(getRestaurantDetail()->restaurant_logo); ?>">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="<?php echo e(asset('css/datepicker.min.css')); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/jquery.timepicker.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/swiper-bundle.min.css')); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/style.css')); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/admin-style.css')); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/dark-mode.css')); ?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.js']); ?>

    <span id="image_type_error" class="d-none"><?php echo e(trans('rest.message.image_type_error')); ?></span>
    <span id="image_size_error" class="d-none"><?php echo e(trans('rest.message.image_size_error')); ?></span>
    <span id="edit_coupon" class="d-none"><?php echo e(trans('rest.coupons.edit')); ?></span>
    <span id="add_coupon" class="d-none"><?php echo e(trans('rest.coupons.add')); ?></span>
    <span id="time_error" class="d-none"><?php echo e(trans('rest.message.time_error')); ?></span>
    <span id="password_error" class="d-none"><?php echo e(trans('rest.message.password_error')); ?></span>
    <span id="settings_update_success" class="d-none"><?php echo e(trans('rest.message.settings_update_success')); ?></span>

</head>
<?php /**PATH E:\wamp\www\go-meal\resources\views/layouts/admin/header.blade.php ENDPATH**/ ?>