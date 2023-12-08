
<script type="text/javascript" src="{{ asset('js/bootstrap.bundle.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/swiper-bundle.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/dark-mode-switch.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/custom-modal.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.validate.min.js')}}"></script>

<script type="text/javascript" src="{{ asset('js/jquery.datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/custom.js')}}"></script>
<script src="https://cdn.ckeditor.com/4.8.0/full-all/ckeditor.js"></script>
<script src="{{ asset('js/jquery.timepicker.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/settings.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/settings-profile.js')}}"></script>

<script>
    var baseURL = "{{ url('/') }}"

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

    });
    // timepicker
</script>


