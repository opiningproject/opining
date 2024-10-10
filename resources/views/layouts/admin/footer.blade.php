
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

        // notification sound update on click sound icon
        $('.sound-check').on('click', function() {
            var soundStatus = $(this).find('.orderNotifSound');
            // Get the current value (either "0" or "1")
            var currentValue = soundStatus.val();
            if (currentValue == 1) {
                soundStatus.val(0); // Set to "0"
                // Hide the volume icon and show the volume-slash icon
                $(this).find('.volumeOn').addClass('d-none');
                $(this).find('.volumeOff').removeClass('d-none');
            } else {
                soundStatus.val(1); // Set to "1"
                // Show the volume icon and hide the volume-slash icon
                $(this).find('.volumeOff').addClass('d-none');
                $(this).find('.volumeOn').removeClass('d-none');
            }
            $.ajax({
                url: baseURL + '/update-notification-sound',
                method: 'POST',
                data: { order_notif_sound: soundStatus.val() },
                success: function(response) {
                    console.log('Sound status updated');
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
    var orderColHeight = $('.order-col:last').height();
    function checkNotifiedOrdersPopup() {

    $.ajax({
        type: 'GET',
        url: baseURL + '/orders/not-notified-orders',
        success: function (data) {
            if(data) {
                $('#order-modal-div').html(data)
                // $('.order-notification-popup').modal('show')
                // Check if there are more than 10 orders displayed
                console.log("length", $('.order-column:first .order-col').length)

                if ($('.order-column:first .order-col').length == 8) {
                    // Remove the last order-col from the first order-column only
                    orderColHeight = $('.order-col:first').height()
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
                // var height = $('.order-col:last').height();
                $('.order-column:first').prepend(data.data)
                $('.order-col:first').css({ 'height': orderColHeight})
                // $('.order-notification-popup').modal('show')
                orderDetailNew(data.orderId).click()
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


