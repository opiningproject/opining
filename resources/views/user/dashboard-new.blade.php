@extends('layouts.user-app')
@section('content')
<div class="main home-page">
    <!-- Sidebar Overlay (for mobile) -->
    <div id="overlay" class="overlay"></div>

    <div class="headerTop">
        <header class="d-flex justify-content-between align-items-center">
            <button class="d-md-none navbar-toggler" id="openSidebar" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 21" fill="none" class="svg actual inlined-svg"
                    width="24" height="21" role="presentation" aria-hidden="true">
                    <line y1="1" x2="30" y2="1" stroke="black" stroke-width="2"></line>
                    <line y1="11" x2="30" y2="11" stroke="black" stroke-width="2"></line>
                    <line y1="20" x2="30" y2="20" stroke="black" stroke-width="2"></line>
                </svg>
            </button>

            <!-- Logo -->
            <a href="#" class="header-logo">
                <img src="{{ asset('images/h-logo.png') }}" alt="Salerno Pizzeria Logo" />
            </a>

            <!-- Navigation Links -->
            <nav id="navbar" class="d-none d-md-flex align-items-center">

                <a href="#" class="d-none" id="close-menu">
                    <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24"
                        width="20" height="20" fill="#ffffff">
                        <path
                            d="m15.854,8.854l-3.146,3.146,3.146,3.146c.195.195.195.512,0,.707-.098.098-.226.146-.354.146s-.256-.049-.354-.146l-3.146-3.146-3.146,3.146c-.098.098-.226.146-.354.146s-.256-.049-.354-.146c-.195-.195-.195-.512,0-.707l3.146-3.146-3.146-3.146c-.195-.195-.195-.512,0-.707s.512-.195.707,0l3.146,3.146,3.146-3.146c.195-.195.512-.195.707,0s.195.512,0,.707Zm8.146,3.146c0,6.617-5.383,12-12,12S0,18.617,0,12,5.383,0,12,0s12,5.383,12,12Zm-1,0c0-6.065-4.935-11-11-11S1,5.935,1,12s4.935,11,11,11,11-4.935,11-11Z" />
                    </svg>
                </a>

                <a href="#" class="nav-link text-dark px-1">Home</a>
                <a href="#" class="nav-link text-dark px-1 fw-bold">Order</a>
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle text-dark px-1" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Account
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="#">Logout</a></li>
                    </ul>
                </div>
            </nav>

            <!-- Buttons -->
            <div class="d-flex align-items-center btns-header">
                <a href="#" class="btn">Log In</a>
                <a href="#" class="btn btn-dark">Sign Up</a>
            </div>
        </header>
    </div>

    <!-- Main Content -->
    <div class="container mt-5">
        <div class="text-center">
            <img src="logo.png" alt="Salerno Pizzeria Logo" class="logo img-fluid">
            <h1>Welcome at <strong>Salerno Pizzeria</strong></h1>
            <p>zagmolenstraat 16</p>

            <div id="order" class="order-box my-4">
                <button class="btn btn-dark">Delivery</button>
                <button class="btn btn-light">Take Away</button>
            </div>

            <h2 id="how-it-works">This is how it works</h2>
            <p class="lead">Very Simple!</p>

            <div class="row text-center">
                <div class="col-md-4">
                    <div class="icon">📍</div>
                    <h4>Enter Location</h4>
                    <p>Enter your postal code to see if we deliver.</p>
                </div>
                <div class="col-md-4">
                    <div class="icon">🍕</div>
                    <h4>Choose your dishes</h4>
                    <p>Select from our menu for delivery or takeaway.</p>
                </div>
                <div class="col-md-4">
                    <div class="icon">🛵</div>
                    <h4>Pay and have food delivered</h4>
                    <p>Pay in cash or online for delivery or pick-up.</p>
                </div>
            </div>

            <h2 id="hours" class="mt-5">Opening Hours</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="p-4 bg-light rounded">
                        <h4>Delivery</h4>
                        <ul class="list-unstyled">
                            <li>Monday - Sunday: 19:00 - 02:00</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 bg-light rounded">
                        <h4>Takeaway</h4>
                        <ul class="list-unstyled">
                            <li>Monday - Sunday: 19:00 - 02:00</li>
                        </ul>
                    </div>
                </div>
            </div>

            <h2 id="contact" class="mt-5">Contact</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="p-4 bg-light rounded">
                        <h4>Salerno Pizzeria</h4>
                        <p>
                            Tochtstraat 40<br>
                            3008 SK Rotterdam<br>
                            +31 654 232 323<br>
                            info@salernopizzeria.nl
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 bg-light rounded">
                        <iframe src="https://www.google.com/maps/embed" width="100%" height="200" style="border:0;"
                            allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="footerBot">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <ul class="social">
                        <li><a href="#" target="_blank">
                                <img src="{{ asset('images/instagram-f.png') }}" alt="" />
                            </a></li>
                        <li><a href="#" target="_blank">
                                <img src="{{ asset('images/tiktok-f.png') }}" alt="" />
                            </a></li>
                        <li><a href="#" target="_blank">
                                <img src="{{ asset('images/facebook-f.png') }}" alt="" />
                            </a></li>
                    </ul>

                    <p><a href="#">Privacy & Terms</a></p>
                    <p class="mb-0">&copy; Copyright 2024 - Gomeal Pizzeria - <img
                            src="{{ asset('images/thunder-icon.png') }}" height="10" alt="" /> by <a href="#"
                            class="underline">Opining</a></p>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection

@section('script')
<script>
    var app_name = '{!! env('APP_NAME') !!}'
</script>
<script>
    $(document).ready(function () {
        $('#openSidebar').click(function () {
            $('#navbar').addClass('active');
            $(body).addClass('overflow-hidden');
        });

        $('#close-menu, #overlay').click(function () {
            $('#navbar').removeClass('active');
            $(body).removeClass('overflow-hidden');
        });
    });

</script>
{{--
<script type="text/javascript" src="{{ asset('js/user/dashboard.js') }}"></script>--}}
@endsection