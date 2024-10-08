@extends('layouts.app')
@section('page_title', 'Create Order')
@section('content')

    <div class="main-content">
        <div class="header-belt">
            <h1 class="title mb-0">
            </h1>

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
                        <li><a href="javascript:void(0)">Burgers</a></li>
                        <li><a href="javascript:void(0)">Pizza</a></li>
                        <li><a href="javascript:void(0)">Pasta</a></li>
                        <li><a href="javascript:void(0)">Fries</a></li>
                        <li><a href="javascript:void(0)">Drinks</a></li>
                        <li><a href="javascript:void(0)">Sides</a></li>
                        <li><a href="javascript:void(0)">Milk</a></li>
                        <li><a href="javascript:void(0)">Coffees</a></li>
                        <li><a href="javascript:void(0)">Sushi</a></li>
                        <li><a href="javascript:void(0)">Salads</a></li>
                        <li><a href="javascript:void(0)">Supers</a></li>
                    </ul>

                    <h2 class="sub-title">Burgers</h2>

                    <div class="order-listing-row">
                        <div class="order-listing-col">
                            <div class="dish-box">
                                <label class="discount">15%</label>
                                <div class="image">
                                    <img src="{{ asset('images/floating-burger.png') }}" alt="" />
                                </div>

                                <div class="details">
                                    <h3>big mac with Cheese</h3>
                                    <a href="#" class="price-btn">+ €12,95</a>
                                    <a href="#" class="customizable">Customizable</a>
                                </div>
                            </div>
                        </div>

                        <div class="order-listing-col">
                            <div class="dish-box">
                                <label class="discount">15%</label>
                                <div class="image">
                                    <img src="{{ asset('images/floating-burger.png') }}" alt="" />
                                </div>

                                <div class="details">
                                    <h3>big mac with Cheese</h3>
                                    <a href="#" class="price-btn">+ €12,95</a>
                                    <a href="#" class="customizable">Customizable</a>
                                </div>
                            </div>
                        </div>

                        <div class="order-listing-col">
                            <div class="dish-box">
                                <label class="discount">15%</label>
                                <div class="image">
                                    <img src="{{ asset('images/floating-burger.png') }}" alt="" />
                                </div>

                                <div class="details">
                                    <h3>big mac with Cheese</h3>
                                    <a href="#" class="price-btn">+ €12,95</a>
                                    <a href="#" class="customizable">Customizable</a>
                                </div>
                            </div>
                        </div>

                        <div class="order-listing-col">
                            <div class="dish-box">
                                <label class="discount">15%</label>
                                <div class="image">
                                    <img src="{{ asset('images/floating-burger.png') }}" alt="" />
                                </div>

                                <div class="details">
                                    <h3>big mac with Cheese</h3>
                                    <a href="#" class="price-btn">+ €12,95</a>
                                    <a href="#" class="customizable">Customizable</a>
                                </div>
                            </div>
                        </div>

                        <div class="order-listing-col">
                            <div class="dish-box">
                                <label class="discount">15%</label>
                                <div class="image">
                                    <img src="{{ asset('images/floating-burger.png') }}" alt="" />
                                </div>

                                <div class="details">
                                    <h3>big mac with Cheese</h3>
                                    <a href="#" class="price-btn">+ €12,95</a>
                                    <a href="#" class="customizable">Customizable</a>
                                </div>
                            </div>
                        </div>

                        <div class="order-listing-col">
                            <div class="dish-box">
                                <label class="discount">15%</label>
                                <div class="image">
                                    <img src="{{ asset('images/floating-burger.png') }}" alt="" />
                                </div>

                                <div class="details">
                                    <h3>big mac with Cheese</h3>
                                    <a href="#" class="price-btn">+ €12,95</a>
                                    <a href="#" class="customizable">Customizable</a>
                                </div>
                            </div>
                        </div>

                        <div class="order-listing-col">
                            <div class="dish-box">
                                <label class="discount">15%</label>
                                <div class="image">
                                    <img src="{{ asset('images/floating-burger.png') }}" alt="" />
                                </div>

                                <div class="details">
                                    <h3>big mac with Cheese</h3>
                                    <a href="#" class="price-btn">+ €12,95</a>
                                    <a href="#" class="customizable">Customizable</a>
                                </div>
                            </div>
                        </div>

                        <div class="order-listing-col">
                            <div class="dish-box">
                                <label class="discount">15%</label>
                                <div class="image">
                                    <img src="{{ asset('images/floating-burger.png') }}" alt="" />
                                </div>

                                <div class="details">
                                    <h3>big mac with Cheese</h3>
                                    <a href="#" class="price-btn">+ €12,95</a>
                                    <a href="#" class="customizable">Customizable</a>
                                </div>
                            </div>
                        </div>

                        <div class="order-listing-col">
                            <div class="dish-box">
                                <label class="discount">15%</label>
                                <div class="image">
                                    <img src="{{ asset('images/floating-burger.png') }}" alt="" />
                                </div>

                                <div class="details">
                                    <h3>big mac with Cheese</h3>
                                    <a href="#" class="price-btn">+ €12,95</a>
                                    <a href="#" class="customizable">Customizable</a>
                                </div>
                            </div>
                        </div>

                        <div class="order-listing-col">
                            <div class="dish-box">
                                <label class="discount">15%</label>
                                <div class="image">
                                    <img src="{{ asset('images/floating-burger.png') }}" alt="" />
                                </div>

                                <div class="details">
                                    <h3>big mac with Cheese</h3>
                                    <a href="#" class="price-btn">+ €12,95</a>
                                    <a href="#" class="customizable">Customizable</a>
                                </div>
                            </div>
                        </div>

                        <div class="order-listing-col">
                            <div class="dish-box">
                                <label class="discount">15%</label>
                                <div class="image">
                                    <img src="{{ asset('images/floating-burger.png') }}" alt="" />
                                </div>

                                <div class="details">
                                    <h3>big mac with Cheese</h3>
                                    <a href="#" class="price-btn">+ €12,95</a>
                                    <a href="#" class="customizable">Customizable</a>
                                </div>
                            </div>
                        </div>

                        <div class="order-listing-col">
                            <div class="dish-box">
                                <label class="discount">15%</label>
                                <div class="image">
                                    <img src="{{ asset('images/floating-burger.png') }}" alt="" />
                                </div>

                                <div class="details">
                                    <h3>big mac with Cheese</h3>
                                    <a href="#" class="price-btn">+ €12,95</a>
                                    <a href="#" class="customizable">Customizable</a>
                                </div>
                            </div>
                        </div>

                        <div class="order-listing-col">
                            <div class="dish-box">
                                <label class="discount">15%</label>
                                <div class="image">
                                    <img src="{{ asset('images/floating-burger.png') }}" alt="" />
                                </div>

                                <div class="details">
                                    <h3>big mac with Cheese</h3>
                                    <a href="#" class="price-btn">+ €12,95</a>
                                    <a href="#" class="customizable">Customizable</a>
                                </div>
                            </div>
                        </div>

                        <div class="order-listing-col">
                            <div class="dish-box">
                                <label class="discount">15%</label>
                                <div class="image">
                                    <img src="{{ asset('images/floating-burger.png') }}" alt="" />
                                </div>

                                <div class="details">
                                    <h3>big mac with Cheese</h3>
                                    <a href="#" class="price-btn">+ €12,95</a>
                                    <a href="#" class="customizable">Customizable</a>
                                </div>
                            </div>
                        </div>

                        <div class="order-listing-col">
                            <div class="dish-box">
                                <label class="discount">15%</label>
                                <div class="image">
                                    <img src="{{ asset('images/floating-burger.png') }}" alt="" />
                                </div>

                                <div class="details">
                                    <h3>big mac with Cheese</h3>
                                    <a href="#" class="price-btn">+ €12,95</a>
                                    <a href="#" class="customizable">Customizable</a>
                                </div>
                            </div>
                        </div>

                        <div class="order-listing-col">
                            <div class="dish-box">
                                <label class="discount">15%</label>
                                <div class="image">
                                    <img src="{{ asset('images/floating-burger.png') }}" alt="" />
                                </div>

                                <div class="details">
                                    <h3>big mac with Cheese</h3>
                                    <a href="#" class="price-btn">+ €12,95</a>
                                    <a href="#" class="customizable">Customizable</a>
                                </div>
                            </div>
                        </div>
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
                                        <span>Payment</span>
                                    </label>
                                    <label class="radio-option">
                                        <input type="radio" name="order-type">
                                        <span>Delivery</span>
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
    @include('admin.manual-order.create-customer-popup')
@endsection
{{--create-customer-popup--}}
@section('script')
<script type="text/javascript" src="{{ asset('js/manual-order.js') }}"></script>
@endsection
