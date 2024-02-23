@extends('layouts.user-app')

@section('content')
    <div class="main">
        <div class="main-view">
            <div class="container-fluid bd-gutter bd-layout">
                @include('layouts.user.side_nav_bar')
                <main class="bd-main order-1">
                    <div class="main-content">
                        <div class="section-page-title main-page-title mb-0">
                            <div class="col-xxl-6 col-xl-6 col-lg-5 col-md-6 col-sm-6 col-12">
                                <h1 class="page-title">Favorite</h1>
                            </div>
                        </div>
                        <!-- start category list section -->
                        <section class="custom-section category-list-section">
                            <div class="favorite-item-grid">
                                @if(!empty($dishes))
                                    @foreach($dishes as $key => $dish)
                                            <?php
                                            $disableBtn = '';
                                            $customizeBtn = false;
                                            if ($dish->dish->qty == 0 || $dish->dish->out_of_stock == '1') {
                                                $disableBtn = 'disabled';
                                                $customizeBtn = true;
                                            } else if ($dish->dish->cart) {
                                                $disableBtn = 'disabled';
                                            }
                                            ?>
                                        <div class="card food-detail-card" id="dish-box-{{ $dish->dish->id }}">
                                            <a href="#" class="mb-0 food-favorite-icon"
                                               onclick="unFavorite({{ $dish->dish->id }})">
                                                <img src="{{ asset('images/favorite-after-icon.svg') }}" alt=""
                                                     class="svg" height="20" width="22">

                                            </a>
                                            <div class="food-image">
                                                <img src="{{ $dish->dish->image }}" class="img-fluid" width="100"
                                                     height="100"/>
                                            </div>
                                            <h4 class="food-name-text">{{ $dish->dish->name_en }}</h4>
                                            <p class="food-price">€ {{ $dish->dish->price }}</p>

                                            <button type="button" class="btn btn-xs-sm btn-custom-yellow"
                                                    onclick="addToCart({{ $dish->dish->id }})"
                                                    id="dish-cart-lbl-{{ $dish->dish->id }}" {{ $disableBtn }}>
                                                @if($dish->dish->qty == 0 || $dish->dish->out_of_stock == '1')
                                                    Out of stock
                                                @else
                                                    @if($dish->dish->cart)
                                                        Added to cart
                                                    @else
                                                        Add
                                                        <img src="{{ asset('images/plus.svg') }}" alt="" class="svg"
                                                             height="9" width="9">

                                                    @endif
                                                @endif
                                            </button>

                                            @if(!$customizeBtn)
                                            <a href="javascript:void(0);" class="customize-foodlink"
                                               onclick="customizeDish({{ $dish->dish_id }});">Customisable</a>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </section>
                        <!-- end category list section -->
                    </div>
                </main>
            </div>
        </div>
        <!-- start footer -->
        @include('layouts.user.footer_design')
        <!-- end footer -->
    </div>

    @include('user.modals.change-password')
    @include('user.modals.customize-dish')

@endsection

@section('')

