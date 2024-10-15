@extends('layouts.app')
@section('page_title', 'Orders')
@section('order_count', getOpenOrders()) <!-- Dynamically set the count -->
@section('content')
{{--@section('page_title')--}}
{{--    <a href="{{ route('orders') }}">Orders</a> <span class="create-order-breadcrumb"> > </span> Create Order--}}
{{--@endsection--}}

    <div class="main-content">
        <div class="header-belt section-page-title d-flex align-items-center justify-content-between gap-2 order-page-bar">
            <div class="d-flex align-items-center btn-grp-gap-10 btn-grp-tab">
                <button type="button" name="clear" value="all" id="clear"
                    class="btn bg-white d-flex align-items-center gap-3 justify-content-center"
                    style="min-width: auto"><img src="{{ asset('images/admin-menu-icons/order-list.svg') }}" class="svg"
                        height="20" width="20" /> Order List</button>

                <a href="{{ route('ordersMap') }}"
                    class="btn bg-white text-black d-flex align-items-center gap-3 justify-content-center"
                    style="min-width: auto">
                    <img src="{{ asset('images/admin-menu-icons/map.svg') }}" class="svg" height="20"
                        width="20" /> Map</a>

                <a href="{{ route('create-order') }}"
                    class="btn bg-white btn-site-theme text-black d-flex align-items-center gap-3 justify-content-center"
                    style="min-width: auto">
                    <img src="{{ asset('images/create-order.png') }}" class="d-none"  />
                    <img src="{{ asset('images/create-order-white.png') }}" />
                    {{ trans('rest.food_order.create_order') }}</a>

            </div>

            <div class="btns-group">
                <div class="search-box">
                    <div class="form-group mb-0">
                        <input type="text" placeholder="Search" class="form-control" />
                        <span class="fa fa-search form-control-feedback"></span>
                    </div>
                </div>
                <button class="btn">Add Custom Item</button>
                <button class="btn btn-danger">Clear All</button>
            </div>
        </div>

        <div class="order-content-container">
            @include('layouts.admin.side_nav_bar')
            <div class="order-content-row">
                <div class="order-content-col">
                    <ul class="tab-listing">
                        @foreach ($categories as $key => $cat)
                            <?php
                            $selected = '';

                            if (!isset($_GET['all']) && $cat_id == '') {
                                if ($key == 0) {
                                    $selected = 'active';
                                }
                            } else {
                                if ($cat_id == $cat->id) {
                                    $selected = 'active';
                                }
                            }
                            ?>
                            <li class="category-{{ $cat->id }}">
                                <a class="category {{ $selected }}" onclick="getDishes({{ $cat->id }})"
                                    href="javascript:void(0)">{{ $cat->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                    <h2 class="sub-title">{{ $category->name }}</h2>

                    <div class="order-listing-row">
                        @if (count($dishes) > 0)
                            @foreach ($dishes as $dish)
                                <?php
                                $disableBtn = '';
                                $customizeBtn = false;

                                //                                        if ($dish->qty == 0 || $dish->out_of_stock == '1') {
                                if ($dish->out_of_stock == '1') {
                                    $disableBtn = 'disabled';
                                    $customizeBtn = true;
                                }

                                if (count($dish->ingredientsWithoutTrash) == 0) {
                                    $customizeBtn = true;
                                }

                                ?>
                                <div class="order-listing-col">
                                    <div class="dish-box">
                                        @if ($dish->percentage_off > 0)
                                            <label class="discount">{{ $dish->percentage_off }}%</label>
                                        @endif
                                        <div class="image">
                                            <img src="{{ $dish->image }}" alt="" />
                                        </div>

                                        <div class="details">
                                            <h3>{{ $dish->name }}</h3>
                                            <button type="button" class="btn price-btn"
                                                onclick="customizeDish({{ $dish->id }})" {{ $disableBtn }}
                                                id="dish-cart-lbl-{{ $dish->id }}">
                                                @if ($dish->out_of_stock == '1')
                                                    {{ trans('user.dashboard.out_of_stock') }}
                                                @else
                                                    <img src="{{ asset('images/plus-up.svg') }}" class="svg"
                                                        height="9" width="9">€{{ number_format($dish->price, 2) }}
                                                @endif
                                            </button>
                                            <a href="#" class="customizable">Customizable</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="order-content-col sidebar-col">
                    <div class="order-content-box">
                        <div class="manual-order-box">
                            <h3 class="title-icon">
                                <span><img src="{{ asset('images/order-type-ml.svg') }}" alt="" /></span> ORDER
                                TYPE
                            </h3>

                            <div class="ml-content">
                                <div class="radio-group">
                                    <label class="radio-option">
                                        <input type="radio" name="order-type" checked>
                                        <span>{{ trans('user.cart.take_away') }}</span>
                                    </label>
                                    <label class="radio-option">
                                        <input type="radio" name="order-type">
                                        <span>{{ trans('user.cart.delivery') }}</span>
                                    </label>
                                </div>

                            </div>
                        </div>

                        <div class="manual-order-box">
                            <h3 class="title-icon">
                                <span><img src="{{ asset('images/user-ml.svg') }}" alt="" /></span> CUSTOMER
                                DETAILS
                            </h3>


                            <div class="ml-content">
                                <div class="radio-group mb-4">
                                    <label class="radio-option">
                                        <input type="radio" name="order-type-a" checked>
                                        <span>add customer</span>
                                    </label>
                                    <label class="radio-option">
                                        <input type="radio" name="order-type-a">
                                        <span>Don’t Show</span>
                                    </label>
                                </div>

                                <div class="search-dropdown-option">
                                    <div class="search-box">
                                        <div class="form-group mb-0">
                                            <input type="text" placeholder="Search or create a customer"
                                                class="form-control" id="createCustomerInput">
                                            <span class="fa fa-search"></span>
                                        </div>

                                        <div class="customer-dropdown" id="createCustomerDropdown">
                                            <button class="add-btn add-customer" type="button">
                                                <svg id="Layer_1" height="20" viewBox="0 0 24 24" width="20"
                                                    data-name="Layer 1">
                                                    <path
                                                        d="m12 0a12 12 0 1 0 12 12 12.013 12.013 0 0 0 -12-12zm0 22a10 10 0 1 1 10-10 10.011 10.011 0 0 1 -10 10zm5-10a1 1 0 0 1 -1 1h-3v3a1 1 0 0 1 -2 0v-3h-3a1 1 0 0 1 0-2h3v-3a1 1 0 0 1 2 0v3h3a1 1 0 0 1 1 1z" />
                                                </svg>Create a new sustomer</button>
                                            <ul>
                                                <li>binaca_pollema@hotmail.com</li>
                                                <li>brandingdoc@gmail.com</li>
                                                <li>daniallearoma@hotmail.com</li>
                                                <li>binaca_pollema@hotmail.com</li>
                                                <li>brandingdoc@gmail.com</li>
                                                <li>daniallearoma@hotmail.com</li>
                                                <li>binaca_pollema@hotmail.com</li>
                                                <li>brandingdoc@gmail.com</li>
                                                <li>daniallearoma@hotmail.com</li>
                                                <li>binaca_pollema@hotmail.com</li>
                                                <li>brandingdoc@gmail.com</li>
                                                <li>daniallearoma@hotmail.com</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="manual-order-box">

                            <button type="" class="close-ico">
                                <svg width="12" height="14" viewBox="0 0 12 14" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <line x1="11.6637" y1="12.37" x2="0.663664" y2="2.36997" stroke="black">
                                    </line>
                                    <path d="M11 2L0.884616 12.4231" stroke="black"></path>
                                </svg>
                            </button>

                            <h3 class="title-icon">
                                <span><img src="{{ asset('images/user-ml.svg') }}" alt="" /></span> CUSTOMER
                                DETAILS
                            </h3>

                            <div class="ml-content">
                                <div class="content">
                                    <p>Serdar Orman</p>

                                    <p class="mb-0">Serdarorman74@Gmail.Com</p>
                                    <p>+31614522453</p>

                                    <h4><b>Shipping Address</b></h4>
                                    <p class="mb-1">Tochtstraat 40<br>3036 SK Rotterdam</p>

                                    <p><a href="#">View Map</a></p>

                                    <h4><b>Billing Address</b></h4>
                                    <p>Same As Shipping Adress</p>
                                </div>

                            </div>
                        </div>

                        <div class="manual-order-box">
                            <h3 class="title-icon">
                                <span><img src="{{ asset('images/order-ml.svg') }}" alt="" /></span> ORDER
                            </h3>

                            <div class="ml-content">

                                <div class="order-dt-row">
                                    <div class="order-dt-col">
                                        <div class="order-dt-box">
                                            <div class="order-title">
                                                <h2><a href="#"><b>1</b> <span class="name">big mac with
                                                            Cheese</span></a></h2>
                                                <h3 class="price">+€20</h3>
                                            </div>

                                            <ul>
                                                <li>+ Onion (€1,50)</li>
                                                <li>- Peppers (€2,00)</li>
                                            </ul>

                                            <div class="order-footer">
                                                <div class="note">
                                                    <a href="#">Add notes</a>
                                                </div>

                                                <div class="add-remove-item">
                                                    <div class="foodqty">
                                                        <span class="minus">
                                                            <i class="fas fa-minus align-middle"></i>
                                                        </span>

                                                        <input type="number" class="count" value="1" />

                                                        <span class="plus">
                                                            <i class="fas fa-plus align-middle"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="order-dt-col">

                                        <div class="order-dt-box">
                                            <div class="order-title">
                                                <h2><a href="#"><b>3</b> <span class="name">big mac with
                                                            Cheese</span></a></h2>
                                                <h3 class="price">+€20</h3>
                                            </div>

                                            <ul>
                                                <li>+ Onion (€1,50)</li>
                                                <li>- Peppers (€2,00)</li>
                                            </ul>

                                            <div class="order-footer">
                                                <div class="note">
                                                    <a href="#">Add notes</a>
                                                </div>

                                                <div class="add-remove-item">
                                                    <div class="foodqty">
                                                        <span class="minus">
                                                            <i class="fas fa-minus align-middle"></i>
                                                        </span>

                                                        <input type="number" class="count" value="3" />

                                                        <span class="plus">
                                                            <i class="fas fa-plus align-middle"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="order-dt-col">

                                        <div class="order-dt-box">
                                            <div class="order-title">
                                                <h2><a href="#"><b>1</b> <span class="name">big mac with
                                                            Cheese</span></a></h2>
                                                <h3 class="price">+€20</h3>
                                            </div>

                                            <ul>
                                                <li>+ Onion (€1,50)</li>
                                                <li>- Peppers (€2,00)</li>
                                            </ul>

                                            <div class="order-footer">
                                                <div class="note">
                                                    <a href="#">Please make the burger extra hot and
                                                        with less sauce</a>
                                                </div>

                                                <div class="add-remove-item">
                                                    <div class="foodqty">
                                                        <span class="minus">
                                                            <i class="fas fa-minus align-middle"></i>
                                                        </span>

                                                        <input type="number" class="count" value="1" />

                                                        <span class="plus">
                                                            <i class="fas fa-plus align-middle"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="manual-order-box">
                            <h3 class="title-icon">
                                <span><img src="{{ asset('images/wished-ml.svg') }}" alt="" /></span> WISHED TIME
                            </h3>

                            <div class="ml-content">
                                <div class="radio-group">
                                    <label class="radio-option">
                                        <input type="radio" name="wished-type" checked>
                                        <span>ASAP</span>
                                    </label>
                                    <label class="radio-option">
                                        <input type="radio" name="wished-type">
                                        <span>Custom Time</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="manual-order-box">
                            <h3 class="title-icon">
                                <span><img src="{{ asset('images/discount-ml.svg') }}" alt="" /></span> ADD
                                DISCOUNT
                            </h3>

                            <div class="ml-content">
                                <div class="radio-group mb-4">
                                    <label class="radio-option">
                                        <input type="radio" name="discount-type" checked>
                                        <span>Add Discount</span>
                                    </label>
                                    <label class="radio-option">
                                        <input type="radio" name="discount-type">
                                        <span>No Discount</span>
                                    </label>
                                </div>

                                <div class="input-container">
                                    <input type="text" value="10" class="percentage-input" readonly>
                                    <span class="percentage-symbol">%</span>
                                </div>

                            </div>
                        </div>

                        <div class="manual-order-box">
                            <h3 class="title-icon">
                                <span><img src="{{ asset('images/note-ml.svg') }}" alt="" /></span> ADD NOTE
                            </h3>

                            <div class="form-group mb-0">
                                <input type="text" class="form-control" />
                            </div>
                        </div>

                        <div class="manual-order-box">
                            <div class="order-total">
                                <table class="table mb-0" border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                        <tr>
                                            <td>Item Total (minimum €10,00)</td>
                                            <td class="text-end">€49,00</td>
                                        </tr>
                                        <tr>
                                            <td>Service</td>
                                            <td class="text-end">€1,99</td>
                                        </tr>
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <td>Total</td>
                                            <td class="text-end">€50,99</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="manual-order-box">
                            <h3 class="title-icon">
                                <span><img src="{{ asset('images/payment-ml.svg') }}" alt="" /></span> PAYMENT
                            </h3>

                            <div class="ml-content">
                                <div class="radio-group">
                                    <label class="radio-option">
                                        <input type="radio" name="payment-type" checked>
                                        <span>Cash</span>
                                    </label>
                                    <label class="radio-option">
                                        <input type="radio" name="payment-type">
                                        <span>Mark As Paid</span>
                                    </label>
                                </div>

                            </div>
                        </div>

                        <button type="submit" class="btn btn-site-theme">Proceed order</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('user.modals.customize-dish')
    @include('admin.manual-order.create-customer-popup')
@endsection
{{-- create-customer-popup --}}
@section('script')
    <script type="text/javascript" src="{{ asset('js/manual-order.js') }}"></script>
    <script>
        var app_name = '{!! env('APP_NAME') !!}'
    </script>
@endsection
