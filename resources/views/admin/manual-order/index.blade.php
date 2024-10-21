@extends('layouts.app')
@section('page_title', 'Orders')
@section('order_count', getOpenOrders()) <!-- Dynamically set the count -->
@section('content')
    {{--@section('page_title')--}}
    {{--    <a href="{{ route('orders') }}">Orders</a> <span class="create-order-breadcrumb"> > </span> Create Order--}}
    {{--@endsection--}}
    <?php
    $zipcode = session('zipcode');
    $house_no = session('house_no');
    $street_name = session('street_name');
    $city = session('city');
    $min_order_price = session('min_order_price');
    $delivery_charge = session('delivery_charge');
    $cartValue = 0;
    $dishOptionCategoryTotalAmount = 0;
    ?>

    <div class="main-content">
        <div
            class="header-belt section-page-title d-flex align-items-center justify-content-between gap-2 order-page-bar">
            <div class="d-flex align-items-center btn-grp-gap-10 btn-grp-tab">
                <button type="button" name="clear" value="all" id="clear"
                        class="btn bg-white d-flex align-items-center gap-3 justify-content-center"
                        style="min-width: auto"><img src="{{ asset('images/admin-menu-icons/order-list.svg') }}"
                                                     class="svg"
                                                     height="20"
                                                     width="20"/> {{ trans('rest.manual_order.order_list') }}</button>

                <a href="{{ route('ordersMap') }}"
                   class="btn bg-white text-black d-flex align-items-center gap-3 justify-content-center"
                   style="min-width: auto">
                    <img src="{{ asset('images/admin-menu-icons/map.svg') }}" class="svg" height="20"
                         width="20"/> {{ trans('rest.manual_order.map') }}</a>

                <a href="{{ route('create-order') }}"
                   class="btn bg-white btn-site-theme text-black d-flex align-items-center gap-3 justify-content-center"
                   style="min-width: auto">
                    <img src="{{ asset('images/create-order.svg') }}" width="16" class="svg d-none"/>
                    <img src="{{ asset('images/create-order-white.svg') }}" width="16" class="svg"/>
                    {{ trans('rest.food_order.create_order') }}</a>

            </div>

            <div class="btns-group">
                <div class="search-box">
                    <div class="form-group mb-0">
                        <input type="text" placeholder="{{ trans('rest.manual_order.search') }}" class="form-control"/>
                        <span class="fa fa-search form-control-feedback"></span>
                    </div>
                </div>
                <button class="btn">{{ trans('rest.manual_order.add_custom_item') }}</button>
                <button class="btn btn-danger">{{ trans('rest.manual_order.clear_all') }}</button>
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
                                            <img src="{{ $dish->image }}" alt=""/>
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
                                            <a href="#"
                                               class="customizable">{{ trans('rest.manual_order.customizable') }}</a>
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
                                <span><img src="{{ asset('images/order-type-ml.svg') }}" alt=""/></span>
                                {{ trans('rest.manual_order.order_type') }}

                            </h3>

                            <div class="ml-content ml-content--tab">
                                <div class="radio-group">
                                    <label class="radio-option active">
                                        <input type="radio" name="order-type" value="2" checked>
                                        {{ trans('user.cart.take_away') }}
                                    </label>
                                    <label class="radio-option">
                                        <input type="radio" name="order-type" value="1">
                                    {{ trans('user.cart.delivery') }}
                                    </label>
                                    <label class="radio-option">
                                        <input type="radio" name="order-type" value="1">
                                       {{ trans('user.cart.cashdesk') }}
                                    </label>
                                </div>

                            </div>
                        </div>

                        <div class="manual-order-box">
                            <h3 class="title-icon">
                                <span><img src="{{ asset('images/user-ml.svg') }}" alt=""/></span>
                                {{ trans('rest.manual_order.customer_details') }}
                            </h3>

                            <div class="ml-content">
                                {{--                                <div class="radio-group mb-4">--}}
                                {{--                                    <label class="radio-option">--}}
                                {{--                                        <input type="radio" name="order-type-a" checked>--}}
                                {{--                                        <span>{{ trans('rest.manual_order.add_customer') }}</span>--}}
                                {{--                                    </label>--}}
                                {{--                                    <label class="radio-option">--}}
                                {{--                                        <input type="radio" name="order-type-a">--}}
                                {{--                                        <span>{{ trans('rest.manual_order.dont_Show') }}</span>--}}
                                {{--                                    </label>--}}
                                {{--                                </div>--}}

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
                                                        d="m12 0a12 12 0 1 0 12 12 12.013 12.013 0 0 0 -12-12zm0 22a10 10 0 1 1 10-10 10.011 10.011 0 0 1 -10 10zm5-10a1 1 0 0 1 -1 1h-3v3a1 1 0 0 1 -2 0v-3h-3a1 1 0 0 1 0-2h3v-3a1 1 0 0 1 2 0v3h3a1 1 0 0 1 1 1z"/>
                                                </svg>{{ trans('rest.manual_order.create_customer') }}</button>
                                            <ul>
                                                @foreach($users as $user)
                                                    <li id="user_id" value="{{ $user->id }}">{{$user->fullname}}</li>
                                                @endforeach
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
                                <span><img src="{{ asset('images/user-ml.svg') }}" alt=""/></span>
                                {{ trans('rest.manual_order.customer_details') }}
                            </h3>

                            <div class="ml-content">
                                <div class="content">
                                    <p>Serdar Orman</p>

                                    <p class="mb-0">Serdarorman74@Gmail.Com</p>
                                    <p>+31614522453</p>

                                    <h4><b>{{ trans('rest.manual_order.shipping_address') }}</b></h4>
                                    <p class="mb-1">Tochtstraat 40<br>3036 SK Rotterdam</p>

                                    <p><a href="#">View Map</a></p>

                                    <h4><b>{{ trans('rest.manual_order.billing_address') }}</b></h4>
                                    <p>Same As Shipping Adress</p>
                                </div>

                            </div>
                        </div>

                        <div class="manual-order-box">
                            <h3 class="title-icon">
                                <span><img src="{{ asset('images/order-ml.svg') }}"
                                           alt=""/></span> {{ trans('rest.manual_order.order') }}
                            </h3>

                            <div class="ml-content">

                                <div class="order-dt-row">
                                    @if (count($cart) > 0)
                                        @foreach ($cart as $key => $dish)
                                            <?php
                                            $dishOptionCategoryTotalAmount = getDishOptionCategoryTotalAmount($dish->orderDishOptionDetails->pluck('dish_option_id'));
                                            //                                                                        dump($dishOptionCategoryTotalAmount);
                                            $cartValue += $dish->qty * $dish->dish->price;
                                            $paidIngredient = $dish->orderDishPaidIngredients()->select(DB::raw('sum(quantity * price) as total'))->get()->sum('total');
                                            $cartValue += $dish->qty * $paidIngredient;
                                            $cartValue += $dish->qty * $dishOptionCategoryTotalAmount;
                                            $outOfStock = '';
                                            $outOfStockDisplay = 'd-none';
                                            //                                                                if ($dish->dish->qty == 0 || $dish->dish->out_of_stock == '1') {
                                            if ($dish->dish->out_of_stock == '1') {
                                                $outOfStock = 'nostock-card';
                                                $outOfStockDisplay = '';
                                            }
                                            ?>
                                            <div class="order-dt-col {{ $outOfStock }}">
                                                <div class="order-dt-box" id="cart-{{ $dish->id }}">
                                                    <div class="order-title">
                                                        <h2><a href="#">
                                                                <b id='quantity-{{ $dish->id }}' class='item-name pe-2 mb-0 item-order'>{{$dish->qty}}</b>
                                                                <span class='name item-name' onclick='customizeDish({{ $dish->dish->id }}, {{ $dish->id }});'>{{$dish->dish->name}}</span>
                                                            </a></h2>

                                                        @php
                                                            $totalAmount = getOrderDishIngredientsTotal(
                                                                $dish,
                                                            );
                                                        @endphp
                                                        <h3 class='price cart-item-price' id='cart-item-price{{$dish->id}}'>+€{{ number_format((float) ($dish->qty * $dish->dish->price) + $paidIngredient * $dish->qty + $dishOptionCategoryTotalAmount * $dish->qty, 2) }}</h3>
                                                    </div>
                                                    @php
                                                        $htmlString = getOrderDishIngredients1(
                                                            $dish,
                                                        );
                                                        $cleanedHtmlString = str_replace(
                                                            '"',
                                                            '',
                                                            $htmlString,
                                                        );
                                                    @endphp
                                                    <ul class="items-additional mb-2"
                                                        id="item-ing-desc{{ $dish->id }}">
                                                        {!! $cleanedHtmlString !!}
                                                    </ul>

                                                    <div class="order-footer">
                                                        <div class="note">
                                                            <a href="#">Add notes</a>
                                                        </div>

                                                        <div class="add-remove-item">
                                                            <div class="foodqty">
                                                            <span class="minus" onclick="updateDishQty('-',{{ $dish->dish->qty }},{{ $dish->id }})">
                                                                <i class="fas fa-minus align-middle"></i>
                                                            </span>
                                                                <input type="number"
                                                                       readonly
                                                                       class="count cart-amt"
                                                                       id="qty-{{ $dish->id }}"
                                                                       name="qty-{{ $dish->id }}"
                                                                       value="{{ $dish->qty }}"
                                                                       data-ing="{{ $paidIngredient }}"
                                                                       data-id="{{ $dish->id }}" />
                                                                <input type="hidden"
                                                                       id="dish-price-{{ $dish->id }}"
                                                                       value="{{ $dish->dish->price + $totalAmount + $dishOptionCategoryTotalAmount }}" />
                                                                <span class="plus"
                                                                      onclick="updateDishQty('+',{{ $dish->dish->qty }},{{ $dish->id }})">
                                                            <i class="fas fa-plus align-middle"></i>
                                                        </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>

                            </div>
                        </div>

                        <div class="manual-order-box">
                            <h3 class="title-icon">
                                <span><img src="{{ asset('images/wished-ml.svg') }}" alt=""/></span>
                                {{ trans('rest.manual_order.wished_time') }}
                            </h3>

                            <div class="ml-content">
                                <div class="radio-group">
                                    <label class="radio-option">
                                        <input type="radio" name="wished-type" checked>
                                        <span>{{ trans('rest.manual_order.asap') }}</span>
                                    </label>
                                    <label class="radio-option">
                                        <input type="radio" name="wished-type">
                                        <span>{{ trans('rest.manual_order.custom_time') }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="manual-order-box">
                            <h3 class="title-icon">
                                <span><img src="{{ asset('images/discount-ml.svg') }}" alt=""/></span>
                                {{ trans('rest.manual_order.add_discount') }}
                            </h3>

                            <div class="ml-content">
                                <div class="radio-group mb-4">
                                    <label class="radio-option">
                                        <input type="radio" name="discount-type" checked>
                                        <span>{{ trans('rest.manual_order.add_discount') }}</span>
                                    </label>
                                    <label class="radio-option">
                                        <input type="radio" name="discount-type">
                                        <span>{{ trans('rest.manual_order.no_discount') }}</span>
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
                                <span><img src="{{ asset('images/note-ml.svg') }}" alt=""/></span>
                                {{ trans('rest.manual_order.add_note') }}
                            </h3>

                            <div class="form-group mb-0">
                                <input type="text" class="form-control"/>
                            </div>
                        </div>

                        <div class="manual-order-box">
                            <div class="order-total">
                                <table class="table mb-0" border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                    <tr>
                                        {{--                                            <td class="text-muted-1 bill-count-name">{{ trans('rest.manual_order.item_total') }}</td>--}}
                                        {{--                                            <td class="min_order_price" style="display: none">0.00</td>--}}
                                        {{--                                            <td class="text-muted-1 minimum_amount" style="">(minimum €0.00)</td>--}}
                                        {{--                                            <td class="bill-count" id="total-cart-bill">€49,00</td>--}}
                                        {{--                                            <input type="hidden" id="total-cart-bill-amount" value="">--}}
                                        <td class="text-start">
                                            <span
                                                class="text-muted-1 bill-count-name">{{ trans('rest.manual_order.item_total') }}</span>

                                            <span class="min_order_price" style="display: none">
                                                    {{ number_format($min_order_price, 2) }}</span>
                                            <span class="text-muted-1 minimum_amount" style="">({{ trans('user.cart.minimum_amount') . '' . number_format($min_order_price, 2) }})
                                                </span>
                                        </td>
                                        <td class="text-end">
                                            <span class="bill-count" id="total-cart-bill">€{{ number_format($cartValue, 2) }}</span>
                                            <input type="hidden" id="total-cart-bill-amount" value="{{ $cartValue }}">
                                        </td>
                                    </tr>
                                    <tr>
                                    <!--                                            <td>{{ trans('rest.manual_order.service') }}</td>
                                            <td class="text-end">€1,99</td>-->
                                        <td class="text-start" {{ $serviceCharge > 0 ? '' : 'style=display:none' }}>
                                            <span class="text-muted-1 bill-count-name">Service charge</span>
                                        </td>
                                        <td class="text-end">
                                            <span class="bill-count">€{{ number_format($serviceCharge, 2) }}</span>
                                            <input type="hidden" id="service-charge" value="{{ $serviceCharge }}">
                                        </td>
                                    </tr>
                                    <tr id="delivery-charge-tab">
                                        <td class="text-start">
                                            <span class="text-muted-1 bill-count-name delivery_charge_name">Delivery Charge</span>
                                        </td>
                                        <td class="text-end">
                                            <span
                                                class="bill-count delivery_charge_amount">€{{ number_format($delivery_charge, 2) }}</span>
                                            <input type="hidden" id="delivery-charge"
                                                   value="{{ $delivery_charge }}">
                                        </td>
                                    </tr>
                                    <tr class="item-discount" id="item-discount"
                                        {{ !empty($couponCode) ? '' : 'style=display:none' }}>
                                        <td class="text-start">
                                                <span
                                                    class="text-custom-light-green bill-count-name">{{ trans('user.cart.discount') }}</span>
                                            <input type="hidden" id="coupon-discount"
                                                   value="{{ $couponDiscount }}">
                                        </td>
                                        <td class="text-end">
                                                <span class="text-custom-light-green bill-count"
                                                      id="coupon-discount-text">-€{{ number_format((float) ($cartValue * $couponDiscountPercent), 2) }}
                                                </span>
                                            <input type="hidden" id="coupon-discount-percent"
                                                   value="{{ $couponDiscountPercent }}">
                                        </td>
                                    </tr>
                                    </tbody>
                                    @php
                                        $amount = number_format(
                                            (float) ($cartValue + $serviceCharge - $cartValue * $couponDiscountPercent),
                                            2,
                                        );
                                        if ($zipcode) {
                                            $amount = number_format(
                                                (float) ($cartValue +
                                                    $serviceCharge +
                                                    $delivery_charge -
                                                    $cartValue * $couponDiscountPercent),
                                                2,
                                            );
                                        }
                                    @endphp
                                    <tfoot>
                                        <tr>
                                            <td>{{ trans('rest.manual_order.total') }}</td>
                                            <td class="text-end">€{{ $amount }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="manual-order-box">
                            <h3 class="title-icon">
                                <span><img src="{{ asset('images/payment-ml.svg') }}" alt=""/></span>
                                {{ trans('rest.manual_order.payment') }}
                            </h3>

                            <div class="ml-content">
                                <div class="radio-group">
                                    <label class="radio-option">
                                        <input type="radio" name="payment-type" value="cash" id="cash" checked>
                                        <span>{{ trans('rest.manual_order.cash') }}</span>
                                    </label>
                                    <label class="radio-option">
                                        <input type="radio" name="payment-type" id="mark_as_paid" value="mark_as_paid">
                                        <span>{{ trans('rest.manual_order.mark_as_paid') }}</span>
                                    </label>
                                </div>

                            </div>
                        </div>

                        <button type="submit"
                                class="btn btn-site-theme">{{ trans('rest.manual_order.proceed_order') }}
                        (<span class="bill-total-count"
                               id="gross-total-bill1">€{{ number_format((float) ($cartValue + $serviceCharge + $delivery_charge - $cartValue * $couponDiscountPercent), 2) }}</span>)
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.modals.customize-dish')
    @include('admin.manual-order.create-customer-popup')
@endsection
{{-- create-customer-popup --}}
@section('script')
    <script type="text/javascript" src="{{ asset('js/manual-order.js') }}"></script>
    <script>
        var app_name = '{!! env('APP_NAME') !!}'
    </script>
@endsection
