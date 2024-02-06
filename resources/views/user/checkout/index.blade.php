@extends('layouts.user-app')
<?php
$zipcode = session('zipcode');
$house_no = session('house_no');
$cartAmount = 0;

$deliveryCharges = getDeliveryCharges($zipcode);
$serviceCharge = getRestaurantDetail()->service_charge
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
                                                                        <input type="text" name="street_name" id="street_name" class="form-control" required
                                                                               value=""/>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="col-xxl-6 col-xl-6 col-lg-4 col-md-6 col-sm-12 col-12">
                                                                    <div class="form-group">
                                                                        <label for="housenumber" class="form-label">House
                                                                            Number</label>
                                                                        <input type="number" maxlength="4" min="0" name="house_no" id="house_no" class="form-control"
                                                                               value="{{ $house_no }}" required/>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="col-xxl-6 col-xl-6 col-lg-4 col-md-6 col-sm-12 col-12">
                                                                    <div class="form-group">
                                                                        <label for="zipcode" class="form-label">Zip
                                                                            Code</label>
                                                                        <input type="text" name="zipcode" class="form-control"
                                                                               value="{{ $zipcode }}" readonly/>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="col-xxl-6 col-xl-6 col-lg-4 col-md-6 col-sm-12 col-12">
                                                                    <div class="form-group">
                                                                        <label for="city"
                                                                               class="form-label">City</label>
                                                                        <input type="text" maxlength="25" required name="city" id="city" class="form-control"
                                                                               value=""/>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="col-xxl-6 col-xl-6 col-lg-4 col-md-6 col-sm-12 col-12">
                                                                    <div class="form-group">
                                                                        <label for="companyname" class="form-label">Company
                                                                            Name
                                                                            (optional)</label>
                                                                        <input type="text" maxlength="30" class="form-control" name="company_name"
                                                                               value=""/>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="col-xxl-6 col-xl-6 col-lg-4 col-md-6 col-sm-12 col-12">
                                                                    <div class="form-group">
                                                                        <label for="companyname" class="form-label">Add
                                                                            Delivery
                                                                            instruction</label>
                                                                        <input type="text" class="form-control" name="instructions" maxlength="50"
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
                                                                <input type="text" class="form-control" name="first_name" required value=""/>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="col-xxl-6 col-xl-6 col-lg-4 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group">
                                                                <label for="lastname" class="form-label">Last
                                                                    Name</label>
                                                                <input type="text" class="form-control" name="last_name" value=""/>
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
                                                                    <input type="number" class="form-control" maxlength="9" required name="phone_no"
                                                                           value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="col-xxl-6 col-xl-6 col-lg-4 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group">
                                                                <label for="email" class="form-label">Email</label>
                                                                <input type="email" required name="email" class="form-control"
                                                                       value=""/>
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
                                                                <select class="form-select"
                                                                        aria-label="Default select example">
                                                                    <option value="1" selected>11:05</option>
                                                                    <option value="2">12:10</option>
                                                                    <option value="3">01:30</option>
                                                                </select>
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
                                                                <button class="nav-link active payment-type-tab" id="v-pills-ideal-tab" data-type="3"
                                                                        data-bs-toggle="pill"
                                                                        data-bs-target="#v-pills-ideal" type="button"
                                                                        role="tab" aria-controls="v-pills-ideal"
                                                                        aria-selected="true">
                                                                    <img src="{{ asset('images/ideal.svg') }}" alt=""
                                                                         height="22" width="25" class="svg">
                                                                    Ideal
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
                                                                <button class="nav-link payment-type-tab" id="v-pills-cashondelivery-tab" data-type="2"
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
                                                                <div class="tab-pane fade show active" id="v-pills-ideal"
                                                                     role="tabpanel" aria-labelledby="v-pills-ideal-tab"
                                                                     tabindex="0"></div>
                                                                <div class="tab-pane fade"
                                                                     id="v-pills-creditanddebitcard" role="tabpanel"
                                                                     aria-labelledby="v-pills-creditanddebitcard-tab"
                                                                     tabindex="0">
                                                                    <h4 class="custom-card-title-1 form-group">Add new
                                                                        card </h4>
                                                                    <div class="payment-form-card">
                                                                        <input type="number" class="form-control"
                                                                               placeholder="card number">
                                                                        <div class="row g-0">
                                                                            <div
                                                                                class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                                                <input type="number"
                                                                                       class="form-control"
                                                                                       placeholder="Valid through (MM/YY)">
                                                                            </div>
                                                                            <div
                                                                                class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                                                <input type="number"
                                                                                       class="form-control form-control-br-left"
                                                                                       placeholder="CVV" min="3"
                                                                                       max="3">
                                                                            </div>
                                                                        </div>
                                                                        <input type="text" class="form-control border-0"
                                                                               placeholder="name on card">
                                                                    </div>
                                                                </div>
                                                                <div class="tab-pane fade" id="v-pills-cashondelivery"
                                                                     role="tabpanel"
                                                                     aria-labelledby="v-pills-cashondelivery-tab"
                                                                     tabindex="0"></div>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" value="3" id="payment_type" name="payment_type">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-check form-group custom-checkbox">
                                                <input class="form-check-input check-input-secondary" type="checkbox" name="receive_mail"
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
                                                                class="align-middle bg-transparent border-0">Pay €202.00 with Credit Card</button>
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
                        <div class="offcanvas-lg offcanvas-end h-100" tabindex="-1" id="bdSidebarCart" aria-labelledby="bdSidebarCartOffcanvasLabel">
                            <div class="offcanvas-header p-0" style="display: block;"></div>
                            <div class="offcanvas-body h-100">
                                <div class="navbar navbar-expand-lg pt-0 h-100">
                                    <div class="cart-sidebar-content position-relative h-100">
                                        <div class="navbar-collapse cartbox-collapse">
                                            <div class="cart-section cart-checkout-section">
                                                <h6 class="cart-title">Order Details</h6>
                                                @foreach($user->cart->dishDetails as $dishDetails)
                                                        <?php
                                                        $cartAmount += ($dishDetails->qty * $dishDetails->dish->price)
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
                                                                            <input type="text" class="form-control"
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
                                                                    <span class="bill-count">€{{ $cartAmount }}</span>
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
                                                                    <span class="bill-count">€0</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <?php
                                                                $couponDiscount = isset($user->cart->coupon) ? ($user->cart->coupon->percentage_off / 100) * $cartAmount : 0;
                                                                ?>
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
                                                                        class="bill-total-count">€{{ $cartAmount + ($serviceCharge - $couponDiscount) }}</span>
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
    <script type="text/javascript" async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCgn-yE-BywHdBacEmRH9IWEFbuaM4PWGw&loading=async"></script>
    <script type="text/javascript" src="{{ asset('js/user/check-out.js') }}"></script>
@endsection
