
<script type="text/javascript" src="{{ asset('js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.bundle.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/swiper-bundle.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/dark-mode-switch.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.validate.min.js')}}"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>

<script src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
<script src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
<script src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.gammel.js"></script>
<script src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.charts.js"></script>
<script src="https://unpkg.com/jquery-fusioncharts@1.1.0/dist/fusioncharts.jqueryplugin.js"></script>
<script type="text/javascript" src="{{ asset('js/jquery.datepicker.min.js')}}"></script>
<script src="{{ asset('js/jquery.timepicker.min.js')}}"></script>

<script type="text/javascript" src="{{ asset('js/settings-profile.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/inline-svg.js')}}"></script>

<script type="text/javascript" src="{{ asset('js/user/user-auth.js')}}"></script>
<script>
    var validationMsg = {
        asap: '{{ trans('user.checkout.asap') }}',
        enter_coupon: '{{ trans('rest.coupons.enter_coupon') }}',
        alpha_numeric: '{{ trans('validation.custom.alphaNumeric') }}',
        alpha_regex: '{{ trans('validation.custom.alphaRegex') }}',
        settings_update_success: '{{ trans('rest.message.settings_update_success') }}',
        password_error: '{{ trans('rest.message.password_error') }}',
        quantity_error: '{{ trans('rest.message.quantity_max') }}',
    }
</script>
<script type="text/javascript" src="{{ asset('js/user/user-settings.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/user/user-dishes.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/user/user-address.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/user/cart.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/user/orders.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/custom.js')}}"></script>

<input type="hidden" id="auth-check" value="{{ auth()->check() ? 1 : 0 }}">
<script>
    var baseURL = "{{ url('/') }}"

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
