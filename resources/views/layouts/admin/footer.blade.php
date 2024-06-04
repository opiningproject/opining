
<script type="text/javascript" src="{{ asset('js/bootstrap.bundle.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/swiper-bundle.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/dark-mode-switch.min.js')}}"></script>
{{--<script type="text/javascript" src="{{ asset('js/custom-modal.js')}}"></script>--}}
<script type="text/javascript" src="{{ asset('js/jquery.validate.min.js')}}"></script>

<script type="text/javascript" src="{{ asset('js/jquery.datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/custom.js')}}"></script>
<script src="https://cdn.ckeditor.com/4.8.0/full-all/ckeditor.js"></script>
<script src="{{ asset('js/jquery.timepicker.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/settings.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/settings-profile.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/settings-payment.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/orders.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/inline-svg.js')}}"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>

<script type="text/javascript" src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.socket.io/4.7.5/socket.io.min.js"
        integrity="sha384-2huaZvOR9iDzHqslqwpR87isEmrfxqyWOF7hr7BY6KG0+hVKLoEXMPUJw3ynWuhO"
        crossorigin="anonymous"></script>
<script>
    var baseURL = "{{ url('/') }}"
    var theme = "{{ session('theme') }}";

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /*jQuery(document).ajaxStart(function(){
        $('#loader').removeClass('d-none');

    })
    jQuery(document).ajaxStop(function(){
        $('#loader').addClass('d-none');
    })*/

    if(theme == 'dark')
    {
        $(window).on('load', function() {
         $(".cke_wysiwyg_frame").contents().find("body").css({ 'background-color': 'black', 'color': 'white'});
        });
    }

    const svg_options = {
            svgSelector: 'img.svg', // the class attached to all images that should be inlined
            initClass: 'js-inlinesvg', // class added to <html>
        }

    inlineSVG.init(svg_options, () => console.log('All SVGs inlined'));
</script>


