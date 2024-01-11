@extends('layouts.user-app') 
@section('content') 

<div class="main">
  <div class="main-view">
    <div class="container-fluid bd-gutter bd-layout">
      @include('layouts.user.side_nav_bar')
      <main class="bd-main order-1 h-92vh-mobile">
        <div class="main-content h-100">
          <div class="section-page-title main-page-title row justify-content-between d-none d-md-block">
            <div class="col-xxl-6 col-xl-6 col-lg-5 col-md-6 col-sm-6 col-12">
              <h1 class="page-title">Chat Support</h1>
            </div>
          </div>
          <div class="chatbox d-flex flex-column flex-fill h-100">
            <div class="chatbox-header d-flex flex-fill gap-3">
              <button class="back-btn">
                <img src="images/cheveron-left.svg" class="img-fluid" alt="gomel" width="10" height="16">
              </button>
              <div class="profile-item d-flex gap-2 gap-sm-4 align-items-center">
                <div class="profile-img">
                  <img src="images/gomeal-chat-icon.svg" class="img-fluid" alt="gomel" width="60" height="60">
                </div>
                <div class="profile-textgrp">
                  <div class="profile-title">Gomeal</div>
                  <div class="profile-text d-flex align-items-center gap-1 gap-sm-2">
                    <span class="activicon"></span> Online
                  </div>
                </div>
              </div>
            </div>
            <div class="chatbox-main flex-fill">
              <div class="flex-fill d-flex align-items-end w-100 h-100">
                <div class="chats-grp d-flex flex-column gap-5 w-100 overflow-auto">
                  <div class="chat-item d-flex align-items-end justify-content-end gap-3 gap-sm-4">
                    <div class="chat-item-img position-relative">
                      <img src="images/gomeal-chat-icon.svg" class="img-fluid" alt="gomel" width="60" height="60">
                      <span class="activicon"></span>
                    </div>
                    <div class="chat-item-textgrp d-flex flex-column gap-2 gap-sm-3">
                      <p>Hello... 1111</p>
                      <p>Your order according to application yes?Your order according to application yes?Your order according to application yes?Your order according to application yes?Your order according to application yes?Your order according to application yes?Your order according to application yes?Your order according to application yes?Your order according to application yes?Your order according to application yes?Your order according to application yes?Your order according to application yes?Your order according to application yes?Your order according to application yes?Your order according to application yes?</p>
                      <small>12:45 PM</small>
                    </div>
                  </div>
                  <div class="chat-item d-flex align-items-end justify-content-end gap-3 gap-sm-4">
                    <div class="chat-item-img position-relative">
                      <img src="images/user-profile.png" class="img-fluid" alt="user" width="60" height="60">
                      <span class="activicon"></span>
                    </div>
                    <div class="chat-item-textgrp d-flex flex-column gap-2 gap-sm-3">
                      <p>Hello...</p>
                      <p>Yes, my order according to application. Thank you</p>
                      <small>12:45 PM</small>
                    </div>
                  </div>
                  <div class="chat-item d-flex align-items-end justify-content-end gap-3 gap-sm-4">
                    <div class="chat-item-img position-relative">
                      <img src="images/user-profile.png" class="img-fluid" alt="user" width="60" height="60">
                      <span class="activicon"></span>
                    </div>
                    <div class="chat-item-textgrp d-flex flex-column gap-2 gap-sm-3">
                      <p>Hello...</p>
                      <p>Yes, my order according to application. Thank you</p>
                      <small>12:45 PM</small>
                    </div>
                  </div>
                  <div class="chat-item d-flex align-items-end justify-content-end gap-3 gap-sm-4">
                    <div class="chat-item-img position-relative">
                      <img src="images/user-profile.png" class="img-fluid" alt="user" width="60" height="60">
                      <span class="activicon"></span>
                    </div>
                    <div class="chat-item-textgrp d-flex flex-column gap-2 gap-sm-3">
                      <p>Hello...</p>
                      <p>Yes, my order according to application. Thank you</p>
                      <small>12:45 PM</small>
                    </div>
                  </div>
                  <div class="chat-item d-flex align-items-end justify-content-end gap-3 gap-sm-4">
                    <div class="chat-item-img position-relative">
                      <img src="images/user-profile.png" class="img-fluid" alt="user" width="60" height="60">
                      <span class="activicon"></span>
                    </div>
                    <div class="chat-item-textgrp d-flex flex-column gap-2 gap-sm-3">
                      <p>Hello...</p>
                      <p>Yes, my order according to application. Thank you</p>
                      <small>12:45 PM</small>
                    </div>
                  </div>
                  <div class="chat-item d-flex align-items-end justify-content-end gap-3 gap-sm-4">
                    <div class="chat-item-img position-relative">
                      <img src="images/user-profile.png" class="img-fluid" alt="user" width="60" height="60">
                      <span class="activicon"></span>
                    </div>
                    <div class="chat-item-textgrp d-flex flex-column gap-2 gap-sm-3">
                      <p>Hello...</p>
                      <p>Yes, my order according to application. Thank you</p>
                      <small>12:45 PM</small>
                    </div>
                  </div>
                  <div class="chat-item d-flex align-items-end justify-content-end gap-3 gap-sm-4">
                    <div class="chat-item-img position-relative">
                      <img src="images/user-profile.png" class="img-fluid" alt="user" width="60" height="60">
                      <span class="activicon"></span>
                    </div>
                    <div class="chat-item-textgrp d-flex flex-column gap-2 gap-sm-3">
                      <p>Hello...</p>
                      <p>Yes, my order according to application. Thank you</p>
                      <small>12:45 PM</small>
                    </div>
                  </div>
                  <div class="chat-item d-flex align-items-end justify-content-end gap-3 gap-sm-4">
                    <div class="chat-item-img position-relative">
                      <img src="images/user-profile.png" class="img-fluid" alt="user" width="60" height="60">
                      <span class="activicon"></span>
                    </div>
                    <div class="chat-item-textgrp d-flex flex-column gap-2 gap-sm-3">
                      <p>Hello...</p>
                      <p>Yes, my order according to application. Thank you</p>
                      <small>12:45 PM</small>
                    </div>
                  </div>
                  <div class="chat-item d-flex align-items-end justify-content-end gap-3 gap-sm-4">
                    <div class="chat-item-img position-relative">
                      <img src="images/user-profile.png" class="img-fluid" alt="user" width="60" height="60">
                      <span class="activicon"></span>
                    </div>
                    <div class="chat-item-textgrp d-flex flex-column gap-2 gap-sm-3">
                      <p>Hello...</p>
                      <p>Yes, my order according to application. Thank you</p>
                      <small>12:45 PM</small>
                    </div>
                  </div>
                  <div class="chat-item d-flex align-items-end justify-content-end gap-3 gap-sm-4">
                    <div class="chat-item-img position-relative">
                      <img src="images/user-profile.png" class="img-fluid" alt="user" width="60" height="60">
                      <span class="activicon"></span>
                    </div>
                    <div class="chat-item-textgrp d-flex flex-column gap-2 gap-sm-3">
                      <p>Hello...</p>
                      <p>Yes, my order according to application. Thank you</p>
                      <small>12:45 PM</small>
                    </div>
                  </div>
                  <div class="chat-item d-flex align-items-end justify-content-end gap-3 gap-sm-4">
                    <div class="chat-item-img position-relative">
                      <img src="images/user-profile.png" class="img-fluid" alt="user" width="60" height="60">
                      <span class="activicon"></span>
                    </div>
                    <div class="chat-item-textgrp d-flex flex-column gap-2 gap-sm-3">
                      <p>Hello...</p>
                      <p>Yes, my order according to application. Thank you</p>
                      <small>12:45 PM</small>
                    </div>
                  </div>
                  <div class="chat-item d-flex align-items-end justify-content-end gap-3 gap-sm-4">
                    <div class="chat-item-img position-relative">
                      <img src="images/user-profile.png" class="img-fluid" alt="user" width="60" height="60">
                      <span class="activicon"></span>
                    </div>
                    <div class="chat-item-textgrp d-flex flex-column gap-2 gap-sm-3">
                      <p>Hello...</p>
                      <p>Yes, my order according to application. Thank you</p>
                      <small>12:45 PM</small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="chatbox-footer d-flex flex-column align-items-center">
              <div class="form-group w-100 mb-0 position-relative d-flex gap-2 bg-gray align-items-center">
                <input type="text" class="form-control w-100 bg-transparent border-none outline-none" placeholder="Write your message..." />
                <div class="d-flex gap-2 gap-sm-3">
                  <button class="border-none outline-none bg-transparent svg-btn">
                    <img src="images/attach.svg">
                  </button>
                  <button class="btn btn-xs-sm btn-custom-yellow">Send</button>
                </div>
              </div>
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
@endsection