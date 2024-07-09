
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
<script src="https://cdn.ckeditor.com/4.24.0/full-all/ckeditor.js"></script>
<script src="{{ asset('js/jquery.timepicker.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/settings.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/settings-profile.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/settings-payment.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/orders.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/inline-svg.js')}}"></script>

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
                @if(getRestaurantDetail()->order_notif_sound)
                // $('.myaudio').play();
                document.getElementById('myaudio').play();
                @endif
                    getLiveOrderList();
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
                $('.order-list-data-div1').html(data)
                $('.order-notification-popup').modal('show')

                // get realtime open order count
               /* var totalAmountCount = $('.order-count').text();
                totalAmountCount = totalAmountCount.replace('€', '').trim();
                var currentOrderCount = $('.order-notification-popup .modal-body .items-list-order .ord_item .total_amount').html();
                var amountWithoutEuro = currentOrderCount.replace('+', '').trim().replace('+', '').replace('€', '').trim();
                currentOrderCount = parseInt(amountWithoutEuro);
                var totalPrice = parseInt(totalAmountCount) + parseInt(currentOrderCount);
                $('.order-count').html('€' + totalPrice);*/
                var currentOrderCount = parseInt($('.order-count').text());
                $('.order-count').html(currentOrderCount + 1);
            }
        },
        error: function (data) {
            alert("Error")
        }
    });
}
@endif
</script>


