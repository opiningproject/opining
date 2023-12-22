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
               <h1 class="page-title">My Coupons</h1>
             </div>
           </div>
           <!-- start coupons card section -->
           <section class="custom-section h-100">
             <div class="card custom-card">
               <div class="card-body coupon-card-grid">
                 @foreach($coupons as $key => $coupon)
                 <div class="card custom-card coupons-card p-0">
                   <div class="card-body p-0">
                     <div class="inner-card">
                       <div class="inner-card-body">
                         <h3>{{ $coupon->percentage_off }}<sup>%</sup>
                           <sub>off</sub>
                         </h3>
                         <h6>Off in your next food purchase</h6>
                         <div class="dotted-divider"></div>
                         <p class="valid-date mb-0">Valid Until {{ $coupon->expiry_date }}</p>
                       </div>
                       <div class="promocode-box">
                         <p class="mb-0 d-inline-block">Promo code</p>
                         <a href="javascript:void(0);" class="badge text-bg-white d-inline-block" id="coupon-code-{{ $coupon->id }}" data-code="{{ $coupon->promo_code }}" onclick='showCouponCode({{ $coupon->id }})'>Get Code</a>
                       </div>
                       <div class="circle1"></div>
                       <div class="circle2"></div>
                       <div class="checkcircle d-block">
                         <i class="fas fa-check text-light align-middle"></i>
                       </div>
                     </div>
                   </div>
                 </div>
                 @endforeach
                 <!-- <div class="card custom-card coupons-card p-0">
                   <div class="card-body p-0">
                     <div class="inner-card">
                       <div class="inner-card-body">
                         <h3>50 <sup>%</sup>
                           <sub>off</sub>
                         </h3>
                         <h6>Off in your next food purchase</h6>
                         <div class="dotted-divider"></div>
                         <p class="valid-date mb-0">Valid Until 31-12-2023</p>
                       </div>
                       <div class="promocode-box">
                         <p class="mb-0 d-inline-block">Promo code</p>
                         <span class="badge text-bg-lightyellow d-inline-block">GOMEAl50</span>
                       </div>
                       <div class="circle1"></div>
                       <div class="circle2"></div>
                       <div class="checkcircle">
                         <i class="fas fa-check text-light align-middle"></i>
                       </div>
                     </div>
                   </div>
                 </div> --> 
               </div>
             </div>
           </section>
           <!-- start coupons card section -->
         </div>
       </main>
     </div>
   </div>
   <!-- start footer -->
   @include('layouts.user.footer_design')
   <!-- end footer -->

 </div>
@endsection

@section('script')
<script type="text/javascript">

 $(".coupons-card").click(function () {
      $(".checkcircle").toggle();
  });
  $(".coupons-card").hover(function () {
      $(".checkcircle").css("display", "block");
  }, function () {
      $(".checkcircle").css("display", "none");
  });
  $(".coupons-card").click(function () {
      $(".checkcircle").toggle();
  });

  function showCouponCode(id,code) 
  {
    $('#coupon-code-'+id).text($('#coupon-code-'+id).data('code'))
  }

</script>
@endsection

