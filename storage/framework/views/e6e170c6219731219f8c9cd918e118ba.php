
<script type="text/javascript" src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/bootstrap.bundle.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/swiper-bundle.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/dark-mode-switch.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jquery.validate.min.js')); ?>"></script>

<script src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
<script src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
<script src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.gammel.js"></script>
<script src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.charts.js"></script>
<script src="https://unpkg.com/jquery-fusioncharts@1.1.0/dist/fusioncharts.jqueryplugin.js"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jquery.datepicker.min.js')); ?>"></script>

<script type="text/javascript" src="<?php echo e(asset('js/user-auth.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/settings-profile.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/user-settings.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/user-dishes.js')); ?>"></script>

<script>
    var baseURL = "<?php echo e(url('/')); ?>"

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

    });
    // timepicker
</script>
<?php /**PATH /var/www/html/go-meal/resources/views/layouts/user/footer.blade.php ENDPATH**/ ?>