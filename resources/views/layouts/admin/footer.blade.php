
<script type="text/javascript" src="{{ asset('js/bootstrap.bundle.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/swiper-bundle.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/dark-mode-switch.min.js')}}"></script>
{{--<script type="text/javascript" src="{{ asset('js/custom-modal.js')}}"></script>--}}
<script type="text/javascript" src="{{ asset('js/jquery.validate.min.js')}}"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script type="text/javascript" src="{{ asset('js/jquery.datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/custom.js')}}"></script>
{{--<script src="https://cdn.ckeditor.com/4.24.0/full-all/ckeditor.js"></script>--}}
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.8.0/ckeditor.js"></script>

<script src="{{ asset('js/jquery.timepicker.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/settings.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/settings-profile.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/settings-payment.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/orders.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/inline-svg.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/archive-orders.js')}}"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>

<script type="text/javascript" src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="https://cdn.socket.io/4.7.5/socket.io.min.js"
        integrity="sha384-2huaZvOR9iDzHqslqwpR87isEmrfxqyWOF7hr7BY6KG0+hVKLoEXMPUJw3ynWuhO"
        crossorigin="anonymous"></script>
<script>

    var socket = io("https://gomeal-qa.inheritxdev.in/web-socket", {transports: ['websocket', 'polling', 'flashsocket']});

    var baseURL = "{{ url('/') }}"
    var theme = "{{ session('theme') }}";

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // language dropdown code
    $(document).ready(function() {
        $('.custom-select-trigger').on('click', function() {
            $(this).siblings('.custom-options').toggle();
        });

        $('.custom-option').on('click', function() {
            var value = $(this).data('value');
            var text = $(this).html();
            $('.custom-select-trigger span').html(text);
            $('#language').val(value).change();
            $('.custom-options').hide();
            $('.custom-option').removeClass('selected');
            $(this).addClass('selected');
            if (value == "en") {
                window.location.href = "{{ route('app.setLocal', 'en') }}";
            } else if(value == "nl") {
                window.location.href = "{{ route('app.setLocal', 'nl') }}";
            }
        });

        // Close dropdown when clicking outside
        $(document).click(function(e) {
            if (!$(e.target).closest('.custom-select').length) {
                $('.custom-options').hide();
            }
        });

        function goFullscreen() {
            // Check if the Fullscreen API is supported
            if (document.documentElement.requestFullscreen) {
                document.documentElement.requestFullscreen();
            } else if (document.documentElement.mozRequestFullScreen) { // Firefox
                document.documentElement.mozRequestFullScreen();
            } else if (document.documentElement.webkitRequestFullscreen) { // Chrome, Safari and Opera
                document.documentElement.webkitRequestFullscreen();
            } else if (document.documentElement.msRequestFullscreen) { // IE/Edge
                document.documentElement.msRequestFullscreen();
            }
        }
        function exitFullscreen() {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.mozCancelFullScreen) { // Firefox
                document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) { // Chrome, Safari and Opera
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) { // IE/Edge
                document.msExitFullscreen();
            }

            // Remove fullscreen state from localStorage
            localStorage.removeItem("fullscreen");
        }

        // Add event listener to the button
        // document.getElementById("maximize-screen").addEventListener("click", goFullscreen);
        $('.maximize-screen').on('click', function(){
            goFullscreen()
            $('.minimize-screen').removeClass('d-none')
            $('.maximize-screen').addClass('d-none')
        });
        $('.minimize-screen').on('click', function(){
            exitFullscreen()
            $('.maximize-screen').removeClass('d-none')
            $('.minimize-screen').addClass('d-none')
        });

        document.addEventListener('DOMContentLoaded', function () {
            document.addEventListener('keydown', function(event) {
                if (event.key === "Escape") {
                    console.log('Escape key pressed'); // Should log to console when Escape key is pressed
                    exitFullscreen();
                    $('.maximize-screen').removeClass('d-none');
                    $('.minimize-screen').addClass('d-none');
                }
            });
        });
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
    // show popup by socket io

    @if(auth()->user())
    socket.on('socketConnectionSecured', (message) => {
        $('#socket-id').val(message)
    });
    socket.on('sendNotificationToAdmin', () => {
        // document.getElementById('myaudio').play();
        checkNotifiedOrdersPopup()
    });
    // code for open popup
    checkNotifiedOrdersPopup()

    function checkNotifiedOrdersPopup() {

    $.ajax({
        type: 'GET',
        url: baseURL + '/orders/not-notified-orders',
        success: function (data) {
            if(data) {
                $('#order-modal-div').html(data)
                $('.order-notification-popup').modal('show')
                // Check if there are more than 10 orders displayed
                console.log("length", $('.order-column:first .order-col').length)

                if ($('.order-column:first .order-col').length == 8) {
                    // Remove the last order-col from the first order-column only
                    $('.order-column:first .order-col:last').remove();
                }
                @if(getRestaurantDetail()->order_notif_sound)
                // $('.myaudio').play();
                document.getElementById('myaudio').play();
                @endif
                // setInterval(function() {
                    // Call the function to add a new order
                    getLiveOrderList();
                // }, 10000);
            }
        },
        error: function (data) {
            alert("Error")
        }
    });
}
function getLiveOrderList() {
    var activeId = $('.foodorder-box-list-item.active').attr('data-id')
    $.ajax({
        type: 'POST',
        url: baseURL + '/orders/getRealTimeOrder',
        data: {
            activeId
        },
        datatype: 'json',
        success: function (data) {
            if(data) {
                var height = $('.order-col:last').height()
                $('.order-column:first').prepend(data.data)
                $('.order-col:first').css({ 'height': height})
                $('.order-notification-popup').modal('show')
                var currentOrderCount = parseInt($('.order-count').text());
                $('.order-count').html(currentOrderCount + 1);
                $('.count-order').html(currentOrderCount + 1);
            }
        },
        error: function (data) {
            alert("Error")
        }
    });
}
@endif
</script>


