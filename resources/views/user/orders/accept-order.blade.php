<!-- Order Accepted mobile page HTML starts -->
<div class="order-success-note order-success-note-mobile mobile-accept-order text-center d-none">
    <div class="order-succes-box">
        <div class="icon mb-4">
            <img src="{{ asset('images/checkmark-icon.svg') }}"  alt=""  />
        </div>

        <h1> {{ trans('user.my_orders.order_accepted') }} </h1>
        <p> {{ trans('user.my_orders.details_on_my_orders_page') }} </p>

        <div class="success-footer mt-5">
            <a href="{{ route('user.orders') }}" class="btn btn-site-theme btn-default d-block">{{ trans('user.my_orders.my_order') }}</a>
            <div class="text-center mt-4">
                <a href="{{ route('user.dashboard') }}" class="back-link">{{ trans('user.my_orders.back_to_home') }}</a>
            </div>
        </div>
    </div>
</div>
<!-- Order Accepted mobile page HTML starts -->

<!-- Order Accepted modal HTML starts -->
<div class="modal fade custom-modal orderAcceptedModal" id="orderAcceptedModal" tabindex="-1" aria-labelledby="orderAcceptedModal"
     aria-hidden="false" data-backdrop="static" style="background: rgb(43 42 42 / 80%);">
    <div class="modal-dialog custom-w-441px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="order-success-note text-center">
                    <div class="order-succes-box">
                        <div class="icon mb-3">
                            <img src="{{ asset('images/checkmark-icon.svg') }}" alt=""/>
                        </div>

                        <h1> {{ trans('user.my_orders.order_accepted') }} </h1>
                        <p> {{ trans('user.my_orders.details_on_my_orders_page') }} </p>

                        <div class="success-footer mt-5">
                            <a href="{{ route('user.orders') }}" class="btn btn-site-theme btn-default d-block">{{ trans('user.my_orders.my_order') }}</a>
                            <div class="text-center mt-4">
                                <a href="{{ route('user.dashboard') }}" class="back-link">{{ trans('user.my_orders.back_to_home') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Order Accepted modal HTML ends -->
