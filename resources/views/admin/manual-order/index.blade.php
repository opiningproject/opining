@extends('layouts.app')
@section('page_title', 'Create Order')
@section('content')

    <div class="main-content">
        <div class="header-belt">
            <h1 class="title mb-0">
                <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M0.292893 7.29289C-0.0976311 7.68342 -0.0976311 8.31658 0.292893 8.70711L6.65685 15.0711C7.04738 15.4616 7.68054 15.4616 8.07107 15.0711C8.46159 14.6805 8.46159 14.0474 8.07107 13.6569L2.41421 8L8.07107 2.34315C8.46159 1.95262 8.46159 1.31946 8.07107 0.928932C7.68054 0.538408 7.04738 0.538408 6.65685 0.928932L0.292893 7.29289ZM17 7L1 7V9L17 9V7Z"
                        fill="black" />
                </svg>
                Create manual order
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
                    Sidebar Content goes here
                </div>
            </div>
        </div>
    </div>
@endsection
