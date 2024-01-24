<div class="ordersdetails">
  <!-- with two button -->
  <div class="ordersdetails-header d-flex justify-content-between align-items-center">
    <div class="ordersdetails-title">Order Details</div>
    <div class="btn-grp d-flex flex-wrap">
      <button onclick="location.href='{{ route('user.order-location') }}'">
        <img src="{{ asset('images/trackorder-icon.svg') }}" class="img-fluid svg" alt="" width="35" height="32"> Track order </button>
      <button onclick="location.href='{{ route('user.chat') }}'">
        <img src="{{ asset('images/needhelp-icon.svg') }}" class="img-fluid svg" alt="" width="27" height="25">Need help </button>
    </div>
  </div>
  <div class="orderdetails-main">
    <div class="orderdetails-maintop d-flex justify-content-between gap-2 gap-sm-3 flex-wrap align-items-center">
      <div class="textgrp d-flex flex-column gap-1 gap-sm-3">
        <div class="title">Order #1</div>
        <div class="text">June 1, 2020, 08:22 AM</div>
      </div>
      <!-- order accepted btn -->
      <button class="border-none outline-none">
        <img src="{{ asset('images/order-accepted.svg') }}" class="img-fluid svg" alt="" width="20" height="20"> Order Accepted </button>
      <!-- order in kitchen btn -->

      <!-- 
      <button class="border-none outline-none">
        <img src="{{ asset('images/orderinkitchen-icon.svg') }}" class="img-fluid svg" alt="" width="26" height="20">Order in a kitchen
      </button> 
      -->
      <!-- ready to pickup -->
      <!-- 
      <button class="border-none outline-none">
        <img src="{{ asset('images/readytopickup-icon.svg') }}" class="img-fluid svg" alt="" width="16" height="20">Ready for pickup                       
      </button>  
      -->
      <!-- Out For Delivery  -->
      <!-- 
      <button class="border-none outline-none">
        <img src="{{ asset('images/outfordelivery-icon.svg') }}" class="img-fluid svg" alt="" width="31" height="20"> Out For Delivery
      </button> 
      -->
      <!-- delivered  -->
      <!-- 
      <button class="border-none outline-none">
        <img src="{{ asset('images/delivered-icon.svg') }}" class="img-fluid svg" alt="" width="31" height="20">Delivered
      </button> -->
      <!-- order delivered  -->
      <!-- 
      <button class="border-none outline-none">
        <img src="{{ asset('images/delivered-icon.svg') }}" class="img-fluid svg" alt="" width="21" height="20"> Order delivered
      </button> -->
    </div>
    <div class="orderdetails-address d-flex justify-content-between flex-wrap gap-3">
      <div class="textgrp">
        <div class="title">Order for</div>
        <div class="text"> Delivery </div>
      </div>
      <!-- Delivery Address -->
      <div class="textgrp">
        <div class="title">Delivery Address</div>
        <div class="text">
          <img src="{{ asset('images/location-yellowicon.svg') }}" class="img-fluid svg" alt="" width="12" height="16"> Tochtstraat 40,
        </div>
      </div>
      <!-- Restaurant Address -->
      <!-- 
      <div class="textgrp">
        <div class="title">Restaurant Address</div>
        <div class="text">
          <img src="{{ asset('images/house-icon.svg') }}" class="img-fluid svg" alt="" width="18" height="18">ABC 5562, New York
        </div>
      </div> 
      -->
      <div class="textgrp">
        <div class="title">Payment</div>
        <div class="text"> Ideal </div>
      </div>
      <div class="textgrp">
        <div class="title">Payment Status</div>
        <div class="text"> Completed </div>
      </div>
    </div>
    <div class="orderdetails-desclist">
      <div class="orderdetails-desc">
        <div class="orderdetails-desc-main">
          <div class="orderdetails-desc-count"> x1 </div>
          <div class="orderdetails-desc-card">
            <img src="images/burger-icon.png" class="img-fluid" alt="" width="85">
            <div class="text-grp">
              <div class="title">big mac with Cheese</div>
              <small>grilled </small>
              <div class="text"> - Ketchup, Crispy veg patty(2x), fresh onion, Cheese, Quarter Pound Bun <a href="">Read More</a>
              </div>
            </div>
          </div>
        </div>
        <div class="orderdetails-desc-note">
          <Label>Notes</Label>
          <input type="text" placeholder="Lorem Ipsum is simply dummy text of the printing and typesetting industry.">
        </div>
        <div class="orderdetails-desc-price"> +€20 </div>
      </div>
    </div>
    <div class="orderdetails-bill">
      <div class="title">Bill Details</div>
      <div class="list">
        <div class="list-item">
          <div class="text">Item Total</div>
          <div class="number">+€80</div>
        </div>
        <div class="list-item">
          <div class="text">Service</div>
          <div class="number">+€01</div>
        </div>
        <div class="list-item">
          <div class="text">Free Delivery (25 mins)</div>
          <div class="number">+€00</div>
        </div>
        <div class="list-item active">
          <div class="text">Item Discount</div>
          <div class="number">-€01</div>
        </div>
      </div>
    </div>
    <div class="orderdetails-total">
      <div class="list">
        <div class="list-item">
          <div class="text">Total</div>
          <div class="number">€12.59</div>
        </div>
      </div>
    </div>
  </div>
  <div class="orderdetails-footer">
    <div class="btn-grp d-flex flex-wrap">
      <a href="javascript:void(0);" class="customize-foodlink button active" data-bs-toggle="modal" data-bs-target="#refundModal">
        <img src="{{ asset('images/download-icon.svg') }}" class="img-fluid svg" alt="" width="14" height="14">
        <div class="text-truncate"> Download invoice </div>
      </a>
      <a href="javascript:void(0);" class="customize-foodlink button" data-bs-toggle="modal" data-bs-target="#refundModal">
        <img src="{{ asset('images/refund-icon.svg') }}" class="img-fluid svg" alt="" width="18" height="18">
        <div class="text-truncate"> Refund request submitted </div>
      </a>
    </div>
  </div>
</div>