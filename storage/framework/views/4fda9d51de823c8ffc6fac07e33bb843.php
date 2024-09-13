<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, shrink-to-fit=no, user-scalable=no" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', config('app.name', 'Laravel')); ?></title>
    <!-- Bootstrap CSS -->
    <link rel="shortcut icon" href="<?php echo e(getRestaurantDetail()->restaurant_logo); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/bootstrap.min.css')); ?>"  />
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/font_bootstrap_icons.css')); ?>">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/datepicker.min.css')); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/jquery.timepicker.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/swiper-bundle.min.css')); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/dark-mode.css')); ?>" />

    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/user-style.css')); ?>" />

    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/user-style.css.map')); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/user-payment-base.css')); ?>" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.js']); ?>

</head>
<?php /**PATH E:\wamp\www\go-meal\resources\views/layouts/user/header.blade.php ENDPATH**/ ?>