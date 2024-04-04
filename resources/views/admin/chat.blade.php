@extends('layouts.app')

@section('content')
    <div class="main">
        <div class="main-view">
            <div class="container-fluid bd-gutter bd-layout">
                @include('layouts.admin.side_nav_bar')
                <input type="hidden" id="socket-id" value="">
                <main class="bd-main order-1 w-100">
                    <div class="main-content">
                        <div class="section-page-title main-page-title row justify-content-between d-none d-sm-block">
                            <div class="col-xxl-6 col-xl-6 col-lg-5 col-md-6 col-sm-6 col-12">
                                <h1 class="page-title">Chat</h1>
                            </div>
                        </div>
                        <input type="hidden" value="{{ Auth::user()->id }}" id="auth-user-id">
                        <div class="d-flex ChatDiv-main">
                            <div class="ChatDiv" id="ChatDiv">

                                <div class="mb-2">
                                    <input type="search" name="q" id="search-chat" class="search-box form-control" value="" placeholder="Search..." />
                                </div>
                                {{-- <div class="ChatDiv-type">
                                    <div class="ChatDiv-list">
                                        <div
                                            class="active ChatDiv-item d-flex align-items-center justify-content-start gap-3">
                                            <img src="images/user-profile.png" alt="Profile-Img" class="img-fluid"
                                                 width="56" height="56">
                                            <div class="text-grp d-flex flex-column">
                                                <div class="title">Ruby Roben</div>
                                                <div class="text">10:00 am | 22, Aug2023</div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                {{-- <div class="row">
                                    <input type="search" name="q" id="search-chat" class="search-box" value="" placeholder="Search...">
                                </div> --}}


                                {{-- @foreach($chats as $chat)

                                    <div class="ChatDiv-type">
                                        <div class="ChatDiv-list">
                                            <input type="hidden" name="sender_id" value="{{ $chat->sender_id }}" id="sender_id_{{$chat->sender_id}}">
                                            <input type="hidden" name="receiver_id" value="{{ $chat->receiver_id }}" id="receiver_id_{{$chat->sender_id}}">
                                            <input type="hidden" name="user_status" value="{{ $chat->sender->is_online }}" id="user_status_{{$chat->sender_id}}">
                                            <div
                                                class="ChatDiv-item d-flex align-items-center justify-content-start gap-3" id="chat_item_{{ $chat->sender_id }}" data-id="{{ $chat->sender_id }}">
                                                <img src="images/user-profile.png" alt="Profile-Img" class="img-fluid"
                                                     width="56" height="56">
                                                <div class="text-grp d-flex flex-column sender_name">
                                                    <div class="title">{{ $chat->sender->first_name }}</div>
                                                    <div class="text">{{ $chat->created_at->format('h:i a | d, M Y') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach --}}
                                {{-- {{ $chats->links() }} --}}
                                {{-- {{ $chats->withQueryString()->links() }} --}}
                            </div>

                            {{-- <div class="chatbox">
                                <div class="chatbox-header d-flex gap-3">
                                    <div class="profile-item d-flex gap-2 gap-sm-4 align-items-center">
                                        <div class="profile-img">
                                            <img src="images/user-profile.png" class="img-fluid" alt="gomel"
                                                 width="60" height="60">
                                        </div>
                                        <div class="profile-textgrp">
                                            <div class="profile-title">Ruby Roben</div>
                                            <div class="profile-text d-flex align-items-center gap-1 gap-sm-2"><span
                                                    class="activicon"></span> Online
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="chatbox-main">
                                    <div class="chats-grp d-flex flex-column gap-5 overflow-auto">
                                        <div
                                            class="chat-item d-flex align-items-end justify-content-end gap-3 gap-sm-4">
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
                                    </div>
                                </div>
                                <div class="chatbox-footer">
                                    <div
                                        class="form-group mb-0 position-relative d-flex gap-2 bg-gray align-items-center">
                                        <input type="text" class="form-control w-100 bg-transparent border-0 outline-0"
                                               placeholder="Write your message..."/>
                                        <div class="d-flex gap-2 gap-sm-3">
                                            <button class="border-0 outline-0 bg-transparent svg-btn">
                                                <img src="{{ asset('images/attach.svg') }}" alt="" height="40"
                                                     width="40" class="svg">
                                            </button>
                                            <button class="btn btn-xs-sm btn-custom-yellow" id="send-btn">Send</button>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                            {{-- Dynamic Message Block --}}
                            <div class="chatbox">
                                <div class="chatbox-header d-flex gap-3">
                                    <div class="profile-item d-flex gap-2 gap-sm-4 align-items-center">
                                        <div class="profile-img">
                                            <img src="{{ asset('images/user-profile.png') }}" class="img-fluid" alt="gomel" width="60" height="60">
                                        </div>
                                        <div class="profile-textgrp">
                                            <div class="profile-title" id="chatbox-username"></div>
                                            <div class="profile-text d-flex align-items-center gap-1 gap-sm-2" id="chatbox-status"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="chatbox-main">
                                    <div class="chats-grp d-flex flex-column gap-5 overflow-auto" id="chat-messages">
                                        <!-- Messages will be displayed here -->
                                    </div>
                                </div>
                                <div class="chatbox-footer">
                                    <div class="form-group mb-0 position-relative d-flex gap-2 bg-gray align-items-center">
                                        <input type="text" id="message-input" class="form-control w-100 bg-transparent border-0 outline-0" placeholder="Write your message...">
                                        <div class="d-flex gap-2 gap-sm-3">
                                            <button class="border-0 outline-0 bg-transparent svg-btn">
                                                <img src="{{ asset('images/attach.svg') }}" alt="" height="40" width="40" class="svg">
                                            </button>
                                            <button class="btn btn-xs-sm btn-custom-yellow" id="send-btn">Send</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Dynamic Message Block --}}


                        </div>

                    </div>
                </main>
            </div>
        </div>
        <!-- start footer -->
        @include('layouts.admin.footer_design')
        <!-- end footer -->
    </div>
@endsection
@section('script')
    <script src="https://cdn.socket.io/4.7.5/socket.io.min.js"
            integrity="sha384-2huaZvOR9iDzHqslqwpR87isEmrfxqyWOF7hr7BY6KG0+hVKLoEXMPUJw3ynWuhO"
            crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ asset('js/chat.js') }}"></script>
@endsection
