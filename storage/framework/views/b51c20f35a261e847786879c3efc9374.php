
<script type="text/javascript" src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/bootstrap.bundle.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/swiper-bundle.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/dark-mode-switch.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jquery.validate.min.js')); ?>"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>

<script src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
<script src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
<script src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.gammel.js"></script>
<script src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.charts.js"></script>
<script src="https://unpkg.com/jquery-fusioncharts@1.1.0/dist/fusioncharts.jqueryplugin.js"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jquery.datepicker.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/jquery.timepicker.min.js')); ?>"></script>

<script type="text/javascript" src="<?php echo e(asset('js/settings-profile.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/inline-svg.js')); ?>"></script>

<script type="text/javascript" src="<?php echo e(asset('js/user/user-auth.js')); ?>"></script>
<script>
    var validationMsg = {
        asap: '<?php echo e(trans('user.checkout.asap')); ?>',
        enter_coupon: '<?php echo e(trans('rest.coupons.enter_coupon')); ?>',
        alpha_numeric: '<?php echo e(trans('validation.custom.alphaNumeric')); ?>',
        alpha_regex: '<?php echo e(trans('validation.custom.alphaRegex')); ?>',
        settings_update_success: '<?php echo e(trans('rest.message.settings_update_success')); ?>',
        password_error: '<?php echo e(trans('rest.message.password_error')); ?>',
        quantity_error: '<?php echo e(trans('rest.message.quantity_max')); ?>',
    }
</script>
<script type="text/javascript" src="<?php echo e(asset('js/custom.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/user/user-settings.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/user/user-dishes.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/user/user-address.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/user/cart.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/user/orders.js')); ?>"></script>

<input type="hidden" id="auth-check" value="<?php echo e(auth()->check() ? 1 : 0); ?>">
<script>
    var baseURL = "<?php echo e(url('/')); ?>"

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

  /*  $(document).ajaxStart(function(){
        $('#loader').removeClass('d-none');
    })
    $(document).ajaxStop(function(){
        $('#loader').addClass('d-none');
    })*/


        const svg_options = {
            svgSelector: 'img.svg', // the class attached to all images that should be inlined
            initClass: 'js-inlinesvg', // class added to <html>
        }

    inlineSVG.init(svg_options, () => console.log('All SVGs inlined'));

</script>
<?php /**PATH E:\wamp\www\go-meal\resources\views/layouts/user/footer.blade.php ENDPATH**/ ?>