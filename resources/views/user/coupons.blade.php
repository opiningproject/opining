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
                   <div class="card-body p-0 {{ ($user->collected_points >= $coupon->points || $coupon->couponTransaction) ? '': 'locked-coupon' }} ">
                     <div class="inner-card">
                       <div class="inner-card-body">
                         <h3>{{ $coupon->percentage_off }}<sup>%</sup>
                           <sub>off</sub>
                         </h3>
                         <h6>On min. order value of €{{ $coupon->price }}</h6>
                         <div class="dotted-divider"></div>
                         <p class="valid-date mb-0">Valid till {{ $coupon->expiry_date }}</p>
                       </div>
                       <div class="promocode-box">
                         @if($coupon->couponTransaction)
                            <p class="mb-0 d-inline-block">Promo code</p>
                            <a href="javascript:void(0);" class="badge text-bg-white d-inline-block">{{ $coupon->promo_code }}</a>
                         @elseif($user->collected_points >= $coupon->points)
                           <p class="mb-0 d-inline-block">Promo code</p>
                           <a href="javascript:void(0);" class="badge text-bg-white d-inline-block" id="coupon-code-{{ $coupon->id }}" data-code="{{ $coupon->promo_code }}" onclick='showCouponPopup({{ $coupon->id }})'>
                           Get Code</a>
                         @else
                           <p class="mb-0 d-inline-block">Earn {{ $coupon->points }} points to unlock coupon</p>
                         @endif
                       </div>
                       <div class="circle1"></div>
                       <div class="circle2"></div>
                       <div class="checkcircle d-block">
                         <i class="fas fa-check text-light align-middle"></i>
                         <!-- <i class="fas fa-xmark text-light align-middle"></i> -->
                       </div>
                     </div>
                   </div>
                 </div>
                 @endforeach
                 <input type="hidden" id="coupon-code">
                 <input type="hidden" id="coupon-id">
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

@include('user.modals.coupon-confirmation')
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

  function showCouponPopup(id)
  {
    var code = $('#coupon-code-'+id).data('code');

    $('#couponConfirmationModal').modal('show')
    $('#coupon-code').val(code);
    $('#coupon-id').val(id);
    $('#coupon-code-name').text(code)
  }

  function couponCodeConfirmation()
  {
    var code = $('#coupon-code').val();
    var id = $('#coupon-id').val();

    $('#coupon-code-'+id).text(code)

    $.ajax({
        url: baseURL + '/user/coupons/confirm/'+id,
        type: 'GET',
        success: function (response) {
          $(".coupon-code-box").removeClass("d-none");
          $("#submit-btn").addClass("d-none");
          $("#coupon-code-text").addClass("d-none");
          //location.reload()
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
  }

  $('#couponConfirmationModal').on('hidden.bs.modal', function () {
    location.reload()
  })
</script>
@endsection

