@extends('layouts.user-app')
<?php
$zipcode = session('zipcode');
$house_no = session('house_no');
$cartAmount = 0.00;
$deliveryCharges = 0.00;

if ($zipcode) {
    $deliveryCharges = getDeliveryCharges($zipcode)->delivery_charge;
}
$serviceCharge = getRestaurantDetail()->service_charge;

$address = session('address');
$phone_no = session('phone_no');

if ($address) {
    $addressData = getAddressDetails($address);
}
$restaurantOpen = getRestaurantOpenTime();

$couponDiscount = isset($user->cart->coupon) ? ($user->cart->coupon->percentage_off / 100) * $cartAmount : 0;

?>
@section('content')
    <div class="main">
        <div class="main-view">
            <div class="container-fluid bd-gutter bd-layout">
                @include('layouts.user.side_nav_bar')
                <main class="bd-main order-1">
                    <div class="main-content">
                        <div class="section-page-title main-page-title mb-0">
                            <div class="col-xxl-6 col-xl-6 col-lg-5 col-md-6 col-sm-6 col-12">
                                <h1 class="page-title">Checkout</h1>
                            </div>
                        </div>
                        <section class="custom-section checkout-section">
                            <form id="final-checkout-form">
                                <input type="hidden" name="is_address_elected" value="{{ $address ?? 0 }}"
                                       id="address_selected">
                                <div class="row checkout-form-steps">
                                    <div class="checkout-form-item">
                                        <div class="form-step-icon">
                                            <div class="icon-form">
                                                <img src="{{ asset('images/user-white-icon.svg') }}" alt="" class="svg"
                                                     height="28" width="27">
                                            </div>
                                        </div>
                                        <div class="cart-form-card-body d-block">
                                            <div class="card custom-card h-100">
                                                <div class="card-body pb-0 checkout-form">
                                                    @if(session('zipcode'))
                                                        <div class="delivery-details">
                                                            <h4 class="custom-card-title-1 form-group">delivery
                                                                address</h4>
                                                            <div class="row">
                                                                <div
                                                                    class="col-xxl-6 col-xl-6 col-lg-4 col-md-6 col-sm-12 col-12">
                                                                    <div class="form-group">
                                                                        <label for="streetname" class="form-label">Street
                                                                            Name</label>
                                                                        <input type="text" name="street_name"
                                                                               id="street_name" class="form-control"
                                                                               required
                                                                               value="{{ $addressData->street_name ?? '' }}"/>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="col-xxl-6 col-xl-6 col-lg-4 col-md-6 col-sm-12 col-12">
                                                                    <div class="form-group">
                                                                        <label for="housenumber" class="form-label">House
                                                                            Number</label>
                                                                        <input type="number" maxlength="4" min="0"
                                                                               name="house_no" id="house_no"
                                                                               class="form-control"
                                                                               value="{{ $addressData->house_no ?? $house_no }}"
                                                                               required/>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="col-xxl-6 col-xl-6 col-lg-4 col-md-6 col-sm-12 col-12">
                                                                    <div class="form-group">
                                                                        <label for="zipcode" class="form-label">Zip
                                                                            Code</label>
                                                                        <input type="text" name="zipcode" id="zipcode"
                                                                               class="form-control"
                                                                               value="{{ $addressData->zipcode ?? $zipcode }}"
                                                                               readonly/>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="col-xxl-6 col-xl-6 col-lg-4 col-md-6 col-sm-12 col-12">
                                                                    <div class="form-group">
                                                                        <label for="city"
                                                                               class="form-label">City</label>
                                                                        <input type="text" maxlength="25" required
                                                                               name="city" id="city"
                                                                               class="form-control"
                                                                               value="{{ $addressData->city ?? '' }}"/>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="col-xxl-6 col-xl-6 col-lg-4 col-md-6 col-sm-12 col-12">
                                                                    <div class="form-group">
                                                                        <label for="companyname" class="form-label">Company
                                                                            Name
                                                                            (optional)</label>
                                                                        <input type="text" maxlength="30"
                                                                               class="form-control" name="company_name"
                                                                               value="{{ $addressData->company_name ?? '' }}"/>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="col-xxl-6 col-xl-6 col-lg-4 col-md-6 col-sm-12 col-12">
                                                                    <div class="form-group">
                                                                        <label for="companyname" class="form-label">Add
                                                                            Delivery
                                                                            instruction</label>
                                                                        <input type="text" class="form-control"
                                                                               name="instructions" maxlength="50"
                                                                               value=""/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <h4 class="custom-card-title-1 form-group">Personal Details <span
                                                            class="text-muted-lead-2">(For Contacting About Order Status or Issues)</span>
                                                    </h4>
                                                    <div class="row">
                                                        <div
                                                            class="col-xxl-6 col-xl-6 col-lg-4 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group">
                                                                <label for="firstname" class="form-label">First
                                                                    Name</label>
                                                                <input type="text" class="form-control"
                                                                       name="first_name" required
                                                                       value="{{ $user->first_name }}"/>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="col-xxl-6 col-xl-6 col-lg-4 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group">
                                                                <label for="lastname" class="form-label">Last
                                                                    Name</label>
                                                                <input type="text" class="form-control" name="last_name"
                                                                       value="{{ $user->last_name }}"/>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="col-xxl-6 col-xl-6 col-lg-4 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group">
                                                                <label for="restaurantpermit"
                                                                       class="form-label">Phone</label>
                                                                <div class="input-group countrycode-phone-control">
                                                                    <button class="dropdown-toggle no-arrow"
                                                                            type="button"
                                                                            data-bs-toggle="dropdown"
                                                                            aria-expanded="false">
                                                                        <img
                                                                            src="{{ asset('images/netherlands-flag.svg') }}"
                                                                            alt="netherlands Flag" class="img-fluid">
                                                                    </button>
                                                                    <input type="text"
                                                                           class="form-control countrycode-input"
                                                                           value="+31">
                                                                    <input type="number" class="form-control"
                                                                           minlength="9" maxlength="9" required
                                                                           name="phone_no" min="1"
                                                                           value="{{ $user->phone_no == '' ? $phone_no : $user->phone_no }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="col-xxl-6 col-xl-6 col-lg-4 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group">
                                                                <label for="email" class="form-label">Email</label>
                                                                <input type="email" required name="email"
                                                                       class="form-control" readonly
                                                                       value="{{ $user->email }}"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="checkout-form-item">
                                        <div class="form-step-icon">
                                            <div class="icon-form">
                                                <img src="{{ asset('images/delivery-time-icon.svg') }}" alt=""
                                                     class="svg"
                                                     height="28" width="28">
                                            </div>
                                        </div>
                                        <div class="cart-form-card-body d-block">
                                            <div class="card custom-card h-100">
                                                <div class="card-body pb-0 checkout-form">
                                                    <h4 class="custom-card-title-1 form-group">Delivery time</h4>
                                                    <div class="row">
                                                        <div
                                                            class="col-xxl-6 col-xl-6 col-lg-4 col-md-12 col-sm-12 col-12 my-auto">
                                                            <div class="custom-radio custom-checkbox-group mobile-mb-10"
                                                                 style="margin-bottom: 30px">
                                                                <div class="radio">
                                                                    <input id="radio-1" name="del_radio" type="radio"
                                                                           class="radio-del-time" checked value="asap">
                                                                    <label for="radio-1"
                                                                           class="radio-label radio-del-time" id="asap">As
                                                                        Soon As
                                                                        Possible</label>
                                                                </div>
                                                                <div class="radio">
                                                                    <input id="radio-2" name="del_radio" type="radio"
                                                                           class="radio-del-time"
                                                                           value="customize-time">
                                                                    <label for="radio-2" id="customize-time"
                                                                           class="radio-label radio-del-time">customize
                                                                        Time </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="col-xxl-3 col-xl-6 col-lg-4 col-md-6 col-sm-12 col-12 customize-time-div"
                                                            style="display: none">
                                                            <div class="form-group">
                                                                <label for="selecttime" class="form-label">Select
                                                                    Time</label>

                                                                <input type="text"
                                                                       class="timepicker form-control time-form-control"
                                                                       name="custom-delivery-time"
                                                                       id="custom-delivery-time"
                                                                       style="max-height: fit-content">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="checkout-form-item">
                                        <div class="form-step-icon">
                                            <div class="icon-form">
                                                <img src="{{ asset('images/timer.svg') }}" alt="" class="svg"
                                                     height="26"
                                                     width="26">
                                            </div>
                                        </div>
                                        <div class="cart-form-card-body cart-form-card-body-last d-block">
                                            <div class="card custom-card h-100 mb-4">
                                                <div class="card-body pb-0 checkout-form">
                                                    <div class=" payment-nav">
                                                        <div class="payment-navigation">
                                                            <h4 class="custom-card-title-1 form-group">Payment</h4>
                                                            <div class="nav flex-column nav-pills" id="v-pills-tab"
                                                                 role="tablist" aria-orientation="vertical">
                                                                <button class="nav-link active payment-type-tab"
                                                                        id="v-pills-ideal-tab" data-type="3"
                                                                        data-bs-toggle="pill"
                                                                        data-bs-target="#v-pills-ideal" type="button"
                                                                        role="tab" aria-controls="v-pills-ideal"
                                                                        aria-selected="true">
                                                                    <img src="{{ asset('images/ideal.svg') }}" alt=""
                                                                         height="22" width="25" class="svg">
                                                                    iDEAL
                                                                </button>
                                                                <button class="nav-link payment-type-tab" data-type="1"
                                                                        id="v-pills-creditanddebitcard-tab"
                                                                        data-bs-toggle="pill"
                                                                        data-bs-target="#v-pills-creditanddebitcard"
                                                                        type="button" role="tab"
                                                                        aria-controls="v-pills-creditanddebitcard"
                                                                        aria-selected="false">
                                                                    <img src="{{ asset('images/stripe.svg') }}" alt=""
                                                                         height="20" width="27" class="svg">
                                                                    Credit & Debit cards
                                                                </button>
                                                                <button class="nav-link payment-type-tab"
                                                                        id="v-pills-cashondelivery-tab" data-type="2"
                                                                        data-bs-toggle="pill"
                                                                        data-bs-target="#v-pills-cashondelivery"
                                                                        type="button" role="tab"
                                                                        aria-controls="v-pills-cashondelivery"
                                                                        aria-selected="false">
                                                                    <img src="{{ asset('images/cod.svg') }}" alt=""
                                                                         height="30" width="31" class="svg"> Cash on
                                                                    Delivery
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="w-100">
                                                            <div class="tab-content w-100" id="v-pills-tabContent">
                                                                <div class="tab-pane fade show active"
                                                                     id="v-pills-ideal"
                                                                     role="tabpanel" aria-labelledby="v-pills-ideal-tab"
                                                                     tabindex="0">
                                                                    <main class="bd-main order-1">
                                                                        <div class="main-content d-flex flex-column ">
                                                                            <div
                                                                                class="section-page-title main-page-title row justify-content-between d-none d-sm-block">
                                                                                <div
                                                                                    class="col-xxl-6 col-xl-6 col-lg-5 col-md-6 col-sm-6 col-12">
                                                                                    <h1 class="page-title">Order
                                                                                        payment</h1>
                                                                                </div>
                                                                            </div>
                                                                            <form id="payment-form">
                                                                                <!--
                                                                                  Using a label with a for attribute that matches the ID of the
                                                                                  Element container enables the Element to automatically gain focus
                                                                                  when the customer clicks on the label.
                                                                                -->
                                                                                <label for="ideal-bank-element"
                                                                                       class="mb-3">
                                                                                    iDEAL Banks
                                                                                </label>
                                                                                <div id="ideal-bank-element">
                                                                                    <!-- A Stripe Element will be inserted here. -->
                                                                                </div>

                                                                                {{--                                                                                <button type="submit">Pay</button>--}}

                                                                                <!-- Used to display form errors. -->
                                                                                <div id="error-message"
                                                                                     role="alert"></div>
                                                                            </form>

                                                                            <div id="messages" role="alert"
                                                                                 style="display: none;"></div>
                                                                        </div>
                                                                    </main>
                                                                </div>
                                                                <div class="tab-pane fade"
                                                                     id="v-pills-creditanddebitcard" role="tabpanel"
                                                                     aria-labelledby="v-pills-creditanddebitcard-tab"
                                                                     tabindex="0">
                                                                    <h4 class="custom-card-title-1 form-group">Add new
                                                                        card </h4>
                                                                    <div class="payment-form-card">
                                                                        <input type="text" class="form-control cardNumber" name="card_number" required
                                                                               placeholder="Card number">
                                                                        <div class="row g-0">
                                                                            <div
                                                                                class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                                                <input type="text" name="exp_date" required
                                                                                       class="form-control expireYear"
                                                                                       placeholder="Valid through (MM/YY)">
                                                                            </div>
                                                                            <div
                                                                                class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                                                <input type="number" name="cvv" required
                                                                                       class="form-control form-control-br-left"
                                                                                       placeholder="CVV" minlength="3"
                                                                                       maxlength="3">
                                                                            </div>
                                                                        </div>
                                                                        <input type="text" class="form-control border-0" name="card_name" required
                                                                               placeholder="Name on card">
                                                                    </div>
                                                                </div>
                                                                <div class="tab-pane fade" id="v-pills-cashondelivery"
                                                                     role="tabpanel"
                                                                     aria-labelledby="v-pills-cashondelivery-tab"
                                                                     tabindex="0"></div>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" value="3" id="payment_type"
                                                               name="payment_type">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-check form-group custom-checkbox">
                                                <input class="form-check-input check-input-secondary" type="checkbox"
                                                       name="receive_mail"
                                                       id="receiveemail" value="1">
                                                <label class="form-check-label text-capitalize align-middle"
                                                       for="receiveemail"> Receive emails about discounts, push-mails
                                                    and
                                                    other updates </label>
                                            </div>
                                            <div class="row">
                                                <div class="col-xxl-6 col-xl-6 col-lg-4 col-md-6 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <a class="btn btn-custom-yellow btn-default d-block">
                                                            <button type="submit"
                                                                    class="align-middle bg-transparent border-0">Pay
                                                                €{{ orderTotalPayAmount() }} with <span
                                                                    id="total-amt-pay-btn">iDEAL</span>
                                                            </button>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </section>
                    </div>
                    <aside class="cart-sidebar position-relative">
                        <div class="offcanvas-lg offcanvas-end h-100" tabindex="-1" id="bdSidebarCart"
                             aria-labelledby="bdSidebarCartOffcanvasLabel">
                            <div class="offcanvas-header p-0" style="display: block;"></div>
                            <div class="offcanvas-body h-100">
                                <div class="navbar navbar-expand-lg pt-0 h-100">
                                    <div class="cart-sidebar-content position-relative h-100">
                                        <div class="navbar-collapse cartbox-collapse">
                                            <div class="cart-section cart-checkout-section">
                                                <h6 class="cart-title">Order Details</h6>
                                                @foreach($user->cart->dishDetails as $dishDetails)
                                                        <?php
                                                        $cartAmount += ($dishDetails->qty * $dishDetails->dish->price);
                                                        $cartAmount += isset($dishDetails->orderDishPaidIngredients) ? $dishDetails->orderDishPaidIngredients()->select(\Illuminate\Support\Facades\DB::raw('sum(quantity * price) as total'))->get()->sum('total') : 0;
                                                        ?>
                                                    <div class="cart-items">
                                                        <div class="row">
                                                            <div
                                                                class="col-xx-3 col-xl-3 col-lg-col-md-12 col-sm-12 col-12 position-relative">
                                                                <span
                                                                    class="order-total-item">x{{ $dishDetails->qty}}</span>
                                                                <img src="images/burger-common-img.svg"
                                                                     alt="{{ $dishDetails->dish->name }}"
                                                                     class="img-fluid" width="86" height="74px">
                                                            </div>
                                                            <div
                                                                class="col-xx-9 col-xl-9 col-lg-col-md-12 col-sm-12 col-12">
                                                                <div class="cart-item-detail">
                                                                    <div
                                                                        class="d-flex align-items-center justify-content-between">
                                                                        <p class="d-inline-block item-name mb-0"> {{ $dishDetails->dish->name }}</p>
                                                                        <span
                                                                            class="cart-item-price">+€{{ $dishDetails->dish->price }}</span>
                                                                    </div>
                                                                    <div class="d-flex">
                                                                        <p class="mb-0 item-options mb-0"> grilled, </p>
                                                                        <span class="item-desc">-Ketchup,fresh onion(2X) kvjbvwjk fkjfbeqjfb</span>
                                                                        <a class="item-customize"
                                                                           href="javascript:void(0);">read more</a>
                                                                    </div>
                                                                    <div class="from-group addnote-from-group mb-0">
                                                                        <div class="form-group">
                                                                            <label for="dishnameenglish"
                                                                                   class="form-label">Add
                                                                                notes</label>
                                                                            <input type="text" class="form-control dish-notes" value="{{ $dishDetails->notes }}" data-id="{{ $dishDetails->id }}"
                                                                                   placeholder="Type here...">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <!--                          <div class="cart-items">
                            <div class="row">
                              <div class="col-xx-3 col-xl-3 col-lg-col-md-12 col-sm-12 col-12 position-relative">
                                <span class="order-total-item">x1</span>
                                <img src="images/burger-common-img.svg" alt="burger image" class="img-fluid" width="86" height="74px">
                              </div>
                              <div class="col-xx-9 col-xl-9 col-lg-col-md-12 col-sm-12 col-12">
                                <div class="cart-item-detail">
                                  <div class="d-flex align-items-center justify-content-between">
                                    <p class="d-inline-block item-name mb-0"> big mac with Cheese</p>
                                    <span class="cart-item-price">+€20</span>
                                  </div>
                                  <div class="d-flex">
                                    <p class="mb-0 item-options mb-0"> grilled, </p>
                                    <span class="item-desc">-Ketchup,fresh onion(2X) kvjbvwjk fkjfbeqjfb</span>
                                    <a class="item-customize" href="javascript:void(0);">read more</a>
                                  </div>
                                  <div class="from-group addnote-from-group mb-0">
                                    <div class="form-group">
                                      <label for="dishnameenglish" class="form-label">Add notes</label>
                                      <input type="text" class="form-control" placeholder="Type here...">
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>-->
                                                <div class="bill-detail-invoice">
                                                    <h6 class="cart-title">Bill Details</h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-borderless">
                                                            <tbody>
                                                            <tbody>
                                                            <tr>
                                                                <td class="text-start">
                                                                    <span class="text-muted-1 bill-count-name">Item Total </span>
                                                                </td>
                                                                <td class="text-end">
                                                                    <span
                                                                        class="bill-count">€{{ getCartTotalAmount() }}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-start">
                                                                    <span
                                                                        class="text-muted-1 bill-count-name">Service</span>
                                                                </td>
                                                                <td class="text-end">
                                                                    <span
                                                                        class="bill-count">{{ $serviceCharge }}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-start">
                                                                    <span class="text-muted-1 bill-count-name">Delivery Charges</span>
                                                                </td>
                                                                <td class="text-end">
                                                                    <span
                                                                        class="bill-count">€{{ $deliveryCharges }}</span>
                                                                </td>
                                                            </tr>
                                                            <tr {{ isset($user->cart->coupon) ? '' : 'style=display:none' }}>

                                                                <td class="text-start">
                                                                    <span
                                                                        class="text-custom-light-green bill-count-name">Coupon Discount({{ $user->cart->coupon_code }})</span>
                                                                </td>
                                                                <td class="text-end">
                                                                    <span
                                                                        class="text-custom-light-green bill-count">-€{{ $couponDiscount }}</span>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                            <tfoot>
                                                            <tr>
                                                                <td class="text-start">Total</td>
                                                                <td class="text-end">
                                                                    <span
                                                                        class="bill-total-count"
                                                                        id="total-payment-text">€{{ orderTotalPayAmount() }}</span>
                                                                </td>
                                                            </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </aside>
                </main>
            </div>
        </div>
        <!-- start footer -->
        @include('layouts.user.footer_design')
        <!-- end footer -->
    </div>
@endsection

@section('script')
    <script type="text/javascript" async
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCgn-yE-BywHdBacEmRH9IWEFbuaM4PWGw&loading=async"></script>
    <script type="text/javascript" src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript" src="{{ asset('js/user/check-out.js') }}"></script>
    <script>
        $(function () {
            var startTime = '<?= date('H:i', strtotime('+30 mins')) ?>';
            var endTime = '<?= $restaurantOpen->end_time ?>';
            $('.timepicker').timepicker({
                timeFormat: 'HH:mm',
                interval: 30,
                dynamic: true,
                dropdown: true,
                scrollbar: true,
                minTime: startTime,
                maxTime: endTime,
            });
        })
        var public_key = '{{ config('params.stripe.sandbox.public_key') }}';
        const stripe = Stripe(public_key, {
            apiVersion: '2020-08-27'
        });

        const elements = stripe.elements();
        const idealBank = elements.create('idealBank');
        idealBank.mount('#ideal-bank-element');

        async function addOrder() {

            var deliveryType = $('input[name=del_radio]:checked').val()
            var paymentType = $('#payment_type').val()

            var zipcode = $('#zipcode').val()
            console.log('zipcode',zipcode)

            if (deliveryType == 'customize-time' && $('#custom-delivery-time').val() == '') {
                alert('Please select time')
                return false
            }

            var checkoutData = new FormData(document.getElementById('final-checkout-form'))
            var latitude = ''
            var longitude = ''

            if(zipcode != undefined){
                var streetName = $('#street_name').val()
                var houseNo = $('#house_no').val()
                var city = $('#city').val()
                var address = houseNo + ' ' + streetName + ' ' + city
                var geocoder = new google.maps.Geocoder();

                await geocoder.geocode({'address': address}, function (results, status) {

                    if (status == google.maps.GeocoderStatus.OK) {
                        latitude = results[0].geometry.location.lat();
                        longitude = results[0].geometry.location.lng();
                    }
                });
            }

            checkoutData.append('longitude', longitude)
            checkoutData.append('latitude', latitude)

            await $.ajax({
                url: baseURL + '/user/place-order',
                type: 'POST',
                processData: false,
                contentType: false,
                data: checkoutData,
                async success(response) {
                    if (response.status == 200) {
                        if(paymentType == '2'){
                            window.location.replace(baseURL + '/user/orders')
                        }else if(paymentType == '3'){
                            const {error, paymentIntent} = await stripe.confirmIdealPayment(
                                response.message.paymentIntent.client_secret, {
                                    payment_method: {
                                        ideal: idealBank,
                                    },
                                    return_url: 'http://localhost/go-meal/user/redirect-ideal-payment',
                                },
                            );
                            if (error) {
                                alert(error.message);
                                return;
                            }
                        }else{
                            if(response.message.cardPayment){
                                window.location.replace(baseURL + '/user/orders')
                            }else{
                                alert(response.message)
                            }
                        }
                    } else {
                        alert(response.message)
                    }
                },
                error(response) {

                }
            })


            // window.location.replace(baseURL + '/user/ideal-payment')

        }
    </script>
@endsection
