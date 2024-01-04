@extends('layouts.app')

@section('content')
    <div class="main">
        <div class="main-view">
            <div class="container-fluid bd-gutter bd-layout">
                @include('layouts.admin.side_nav_bar')

                <main class="bd-main order-1 w-100">
                    <div class="main-content">
                        <div class="section-page-title main-page-title row justify-content-between d-none d-sm-block">
                            <div class="col-xxl-6 col-xl-6 col-lg-5 col-md-6 col-sm-6 col-12">
                                <h1 class="page-title">Chat</h1>
                            </div>
                        </div>
                        <div class="d-flex ChatDiv-main">
                            <div class="ChatDiv">
                                <!-- <div class="active ChatDiv-type">
                                    <div class="ChatDiv-list">
                                        
                                    </div>
                                </div> -->
                                <div class="ChatDiv-type">
                                    <div class="ChatDiv-list">
                                        <div class="active ChatDiv-item d-flex align-items-center justify-content-start gap-3">
                                            <img src="images/user-profile.png" alt="Profile-Img" class="img-fluid" width="56" height="56">
                                            <div class="text-grp d-flex flex-column">
                                                <div class="title">Ruby Roben</div>
                                                <div class="text">10:00 am | 22, Aug2023</div>
                                            </div>
                                        </div>
                                        <div class="ChatDiv-item d-flex align-items-center justify-content-start gap-3">
                                            <img src="images/user-profile-2.png" alt="Profile-Img" class="img-fluid" width="56" height="56">
                                            <div class="text-grp d-flex flex-column">
                                                <div class="title">Mila Crystal</div>
                                                <div class="text">10:00 am | 22, Aug2023</div>
                                            </div>
                                        </div>
                                        <div class="ChatDiv-item d-flex align-items-center justify-content-start gap-3">
                                            <img src="images/user-profile-3.png" alt="Profile-Img" class="img-fluid" width="56" height="56">
                                            <div class="text-grp d-flex flex-column">
                                                <div class="title">John Hill</div>
                                                <div class="text">10:00 am | 22, Aug2023</div>
                                            </div>
                                        </div>
                                        <div class="ChatDiv-item d-flex align-items-center justify-content-start gap-3">
                                            <img src="images/user-profile-4.png" alt="Profile-Img" class="img-fluid" width="56" height="56">
                                            <div class="text-grp d-flex flex-column">
                                                <div class="title">Jonson singh</div>
                                                <div class="text">10:00 am | 22, Aug2023</div>
                                            </div>
                                        </div>
                                        <div class="ChatDiv-item d-flex align-items-center justify-content-start gap-3">
                                            <img src="images/user-profile-5.png" alt="Profile-Img" class="img-fluid" width="56" height="56">
                                            <div class="text-grp d-flex flex-column">
                                                <div class="title">Lorem Ipsum</div>
                                                <div class="text">10:00 am | 22, Aug2023</div>
                                            </div>
                                        </div>
                                        <div class="ChatDiv-item d-flex align-items-center justify-content-start gap-3">
                                            <img src="images/user-profile-6.png" alt="Profile-Img" class="img-fluid" width="56" height="56">
                                            <div class="text-grp d-flex flex-column">
                                                <div class="title">Lorem Ipsum</div>
                                                <div class="text">10:00 am | 22, Aug2023</div>
                                            </div>
                                        </div>
                                        <div class="ChatDiv-item d-flex align-items-center justify-content-start gap-3">
                                            <img src="images/user-profile-2.png" alt="Profile-Img" class="img-fluid" width="56" height="56">
                                            <div class="text-grp d-flex flex-column">
                                                <div class="title">Mila Crystal</div>
                                                <div class="text">10:00 am | 22, Aug2023</div>
                                            </div>
                                        </div>
                                        <div class="ChatDiv-item d-flex align-items-center justify-content-start gap-3">
                                            <img src="images/user-profile-3.png" alt="Profile-Img" class="img-fluid" width="56" height="56">
                                            <div class="text-grp d-flex flex-column">
                                                <div class="title">John Hill</div>
                                                <div class="text">10:00 am | 22, Aug2023</div>
                                            </div>
                                        </div>
                                        <div class="ChatDiv-item d-flex align-items-center justify-content-start gap-3">
                                            <img src="images/user-profile-4.png" alt="Profile-Img" class="img-fluid" width="56" height="56">
                                            <div class="text-grp d-flex flex-column">
                                                <div class="title">Jonson singh</div>
                                                <div class="text">10:00 am | 22, Aug2023</div>
                                            </div>
                                        </div>
                                        <div class="ChatDiv-item d-flex align-items-center justify-content-start gap-3">
                                            <img src="images/user-profile-5.png" alt="Profile-Img" class="img-fluid" width="56" height="56">
                                            <div class="text-grp d-flex flex-column">
                                                <div class="title">Lorem Ipsum</div>
                                                <div class="text">10:00 am | 22, Aug2023</div>
                                            </div>
                                        </div>
                                        <div class="ChatDiv-item d-flex align-items-center justify-content-start gap-3">
                                            <img src="images/user-profile-6.png" alt="Profile-Img" class="img-fluid" width="56" height="56">
                                            <div class="text-grp d-flex flex-column">
                                                <div class="title">Lorem Ipsum</div>
                                                <div class="text">10:00 am | 22, Aug2023</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div class="chatbox">
                                    <div class="chatbox-header d-flex gap-3">
                                        <button class="back-btn">
                                            <img src="images/cheveron-left.svg" class="img-fluid" alt="gomel"
                                                    width="10" height="16">
                                        </button>
                                        <div class="profile-item d-flex gap-2 gap-sm-4 align-items-center">
                                            <div class="profile-img">
                                                <img src="images/user-profile.png" class="img-fluid" alt="gomel"
                                                    width="60" height="60">
                                            </div>
                                            <div class="profile-textgrp">
                                                <div class="profile-title">Ruby Roben</div>
                                                <div class="profile-text d-flex align-items-center gap-1 gap-sm-2"><span class="activicon"></span> Online</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chatbox-main">
                                        <div class="chats-grp d-flex flex-column gap-5 overflow-auto">
                                            <div class="chat-item d-flex align-items-end justify-content-end gap-3 gap-sm-4">
                                                <div class="chat-item-img position-relative">
                                                    <img src="images/user-profile.png" class="img-fluid" alt="gomel"
                                                    width="60" height="60">
                                                    <span class="activicon"></span>
                                                </div>
                                                <div class="chat-item-textgrp d-flex flex-column gap-2 gap-sm-3">
                                                    <p>Hello...</p>
                                                    <p>Your order according to application yes?</p>
                                                    <small>12:45 PM</small>
                                                </div>
                                            </div>
                                            <div class="chat-item d-flex align-items-end justify-content-end gap-3 gap-sm-4">
                                                <div class="chat-item-img position-relative">
                                                    <img src="images/gomeal-chat-icon.svg" class="img-fluid" alt="user"
                                                    width="60" height="60">
                                                    <span class="activicon"></span>
                                                </div>
                                                <div class="chat-item-textgrp d-flex flex-column gap-2 gap-sm-3">
                                                    <p>Hello...</p>
                                                    <p>Yes, my order according to 
                                                        application. Thank you</p>
                                                    <small>12:45 PM</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chatbox-footer">
                                        <div
                                        class="form-group mb-0 position-relative d-flex gap-2 bg-gray align-items-center">
                                            <input type="text" class="form-control w-100 bg-transparent border-0 outline-0" placeholder="Write your message..." />
                                            <div class="d-flex gap-2 gap-sm-3">
                                                <button class="border-0 outline-0 bg-transparent svg-btn">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                                                        <path d="M14.326 34.2a6.25 6.25 0 0 1-4.412-10.663l10.6-10.612a3.755 3.755 0 1 1 5.312 5.312l-10.613 10.6a1.25 1.25 0 1 1-1.762-1.762l10.6-10.613a1.25 1.25 0 0 0-1.762-1.762L11.675 25.3a3.757 3.757 0 0 0 5.312 5.312L27.588 20a6.25 6.25 0 0 0-8.837-8.838l-6.188 6.25a1.25 1.25 0 1 1-1.762-1.775l6.187-6.25a8.75 8.75 0 0 1 12.375 12.375L18.752 32.375a6.252 6.252 0 0 1-4.425 1.825Z" fill="#929292"/>
                                                    </svg>
                                                </button>
                                                <button class="btn btn-xs-sm btn-custom-yellow">Send</button>
                                            </div>
                                        </div>
                                    </div>                     
                                </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <!-- start footer -->
    @include('layouts.admin.footer_design')
    <!-- end footer -->
    </div>
