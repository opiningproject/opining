@extends('layouts.user-app')

@section('content')

 <div class="main">
   <div class="main-view">
     <div class="container-fluid bd-gutter bd-layout">
       @include('layouts.user.side_nav_bar')
        <main class="bd-main order-1">
          <div class="main-content d-flex flex-column ">
            <div class="section-page-title main-page-title row justify-content-between d-none d-sm-block">
              <div class="col-xxl-6 col-xl-6 col-lg-5 col-md-6 col-sm-6 col-12">
                <h1 class="page-title">Order location</h1>
              </div>
            </div>
            <div class="trackOrder">
              <div class="track-order-main flex-grow-1">
                <div class="iframe-box w-100 position-relative">
                  <img src="{{ asset('images/track-map.png') }}" alt="img" class="img-fluid w-100">
                  <div class="clock-icon">
                    <img src="{{ asset('images/track-clock-icon.svg') }}" alt="img" class="img-fluid svg" width="90">
                  </div>
                </div>
                <div class="row text-row">
                  <div class="col-lg-12 col-xl-6 mb-4">
                    <div class="text-box main-text-box">
                      <div class="title">We received your order</div>
                      <div class="text">You can see all details and updates of your order on the my orders page. Your are also able to have contact by this page.</div>
                    </div>
                  </div>
                  <div class="col-lg-6 col-xl-3 mb-4">
                    <div class="text-box">
                      <div class="title">Restaurants Address</div>
                      <div class="text">
                        <div class="img-grp">
                          <img src="{{ asset('images/yellow-icon-img.svg') }}" alt="" class="img-fluid icon svg" width="33">
                          <img src="{{ asset('images/user-img.png') }}" alt="" class="profile svg" width="20">
                        </div> Franklin Avenue Street, ABC 5562, New York
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 col-xl-3">
                    <div class="text-box">
                      <div class="title">Restaurants Address</div>
                      <div class="text">
                        <div class="img-grp">
                          <img src="{{ asset('images/yellow-icon-img.svg') }}" alt="" class="img-fluid icon svg" width="33">
                          <img src="{{ asset('images/user-profile.png') }}" alt="" class="profile" width="20">
                        </div> Tochtstraat 40, 3036 SK, Nieuwegein, Netherlands 3950009
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="btn-grp">
                <button class="btn btn-custom-yellow track-order-btn">My Order</button>
              </div>
            </div>
          </div>
        </main>
     </div>
  </div>
     
   <!-- start footer -->
   @include('layouts.user.footer_design')
   <!-- end footer -->
 </div>

@include('user.modals.refund')

@endsection

