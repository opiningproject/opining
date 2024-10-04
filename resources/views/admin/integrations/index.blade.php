@extends('layouts.app')
@section('page_title', 'Integrations')
@section('content')

    <div class="main-content">
        <div class="header-belt justify-content-start">
            <div class="btns-group position-relative">
                <div class="search-box left-icon" style="min-width: 420px">
                    <div class="form-group mb-0">
                        <input type="text" placeholder="Search Integration" class="form-control" />
                        <span class="fa fa-search form-control-feedback"></span>
                    </div>
                </div>
            </div>
        </div>


        <div class="position-relative">
            @include('layouts.admin.side_nav_bar')

            <div class="integration-container">
                <div class="integration-row">
                    <div class="integration-col">
                        <div class="integration-card">
                            <div class="card-head">
                                <div class="card-logo">
                                    <img src="{{ asset('images/takeaway.png') }}" alt="" />
                                </div>

                                <label class="radio-label-t">
                                    <input type="radio" name="option" id="radio1" checked />
                                    <span class="radio-label">
                                        <span></span> Connected
                                    </span>
                                </label>
                            </div>

                            <h3 class="int-name"><a href="#">TakeAway.com</a></h3>

                            <div class="content">
                                <p>Display your online orders of takeaway.com on opining</p>
                            </div>

                            <div class="ftr-btns row g-2">
                                <div class="col-sm-6">
                                    <button type="submit">Configure</button>
                                </div>
                                <div class="col-sm-6">
                                    <button type="submit">Manage</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="integration-col">
                        <div class="integration-card">
                            <div class="card-head">
                                <div class="card-logo">
                                    <img src="{{ asset('images/ubereats.png') }}" alt="" />
                                </div>

                                <label class="radio-label-t">
                                    <input type="radio" name="option" id="radio1" checked />
                                    <span class="radio-label">
                                        <span></span> Connected
                                    </span>
                                </label>
                            </div>

                            <h3 class="int-name"><a href="#">UberEats</a></h3>

                            <div class="content">
                                <p>Display your online orders of UberEats on opining</p>
                            </div>

                            <div class="ftr-btns row g-2">
                                <div class="col-sm-6">
                                    <button type="submit">Configure</button>
                                </div>
                                <div class="col-sm-6">
                                    <button type="submit">Manage</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="integration-col">
                        <div class="integration-card">
                            <div class="card-head">
                                <div class="card-logo">
                                    <img src="{{ asset('images/deliveroo.png') }}" alt="" />
                                </div>

                                <label class="radio-label-t">
                                    <input type="radio" name="option" id="radio1" checked />
                                    <span class="radio-label">
                                        <span></span> Connected
                                    </span>
                                </label>
                            </div>

                            <h3 class="int-name"><a href="#">Deliveroo</a></h3>

                            <div class="content">
                                <p>Display your online orders of Deliveroo on opining</p>
                            </div>

                            <div class="ftr-btns row g-2">
                                <div class="col-sm-6">
                                    <button type="submit">Configure</button>
                                </div>
                                <div class="col-sm-6">
                                    <button type="submit">Manage</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
