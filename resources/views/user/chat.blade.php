@extends('layouts.user-app')

@section('content')
    <div class="main">
        <div class="main-view">
            <div class="container-fluid bd-gutter bd-layout">
                @include('layouts.user.side_nav_bar')
                <input type="hidden" id="socket-id" value="">
                <input type="hidden" value="{{ Auth::user()->id }}" id="auth-user-id" class="auth-user-id">
                <input type="hidden" name="sender_id" class="sender_id" value="{{ Auth::user()->id }}"
                       id="sender_id_{{ Auth::user()->id }}">
                <input type="hidden" name="receiver_id" class="receiver_id" value="1" id="receiver_id_1">
                <main class="bd-main order-1 w-100">
                    <div class="main-content">
                        <div class="section-page-title main-page-title row justify-content-between d-none d-sm-block">
                            <div class="col-xxl-6 col-xl-6 col-lg-5 col-md-6 col-sm-6 col-12">
                                <h1 class="page-title">Chat</h1>
                            </div>
                        </div>
                        <input type="hidden" value="{{ Auth::user()->id }}" id="auth-user-id">
                        <div class="d-flex ChatDiv-main">
                            {{-- Dynamic Message Block --}}
                            <div class="chatbox d-flex flex-column flex-fill h-100">
                                <div class="chatbox-header d-flex gap-3">
                                    <div class="profile-item d-flex gap-2 gap-sm-4 align-items-center">
                                        <div class="profile-img">
                                            <img
                                                src="{{ \Auth()->user()->image ? \Auth()->user()->image : asset('images/user-profile-img.svg') }}"
                                                class="img-fluid" alt="gomel" width="60" height="60">
                                        </div>
                                        <div class="profile-textgrp">
                                            <div class="profile-title">{{ ucwords(\Auth()->user()->first_name) }}</div>
                                            <div class="profile-text d-flex align-items-center gap-1 gap-sm-2">
                                                @if(\Auth()->user()->is_online == 1)
                                                    <span class="activicon"></span> Online
                                                @else
                                                    <span class="inactivicon"></span> Offline
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="chatbox-main">
                                    <div
                                        class="chats-grp d-flex flex-column gap-5 overflow-auto chat-messages-user_{{ \Auth::user()->id }}"
                                        id="chat-messages-user">
                                        <!-- Messages will be displayed here -->
                                    </div>
                                </div>
                                <div class="chatbox-footer">
                                    <div
                                        class="form-group mb-0 position-relative d-flex gap-2 bg-gray align-items-center">
                                        <input type="text" id="message-input"
                                               class="form-control w-100 bg-transparent border-0 outline-0 message-input"
                                               placeholder="Write your message...">
                                        <div class="d-flex gap-2 gap-sm-3">
                                            <label for="chat_attachment" class="custom-file-upload">
                                                <img src={{ asset('images/attach.svg') }}/>
                                                <input id="chat_attachment" type="file" name="chat_attachment"
                                                       class="chat_attachment" style="display: none"/>
                                            </label>
                                            <button
                                                class="btn btn-xs-sm btn-custom-yellow send-user-btn send-btn-user_{{ \Auth::user()->id }}" disabled>
                                                Send
                                            </button>
                                        </div>
                                    </div>
                                    <br>
                                    <div id="image-holder" class="image-holder"> </div>
                                </div>
                            </div>
                            {{-- Dynamic Message Block --}}
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
@section('script')
    <script>
        const userLogin = {
            id: {{ auth()->user()->id }},
            socketId: $('#socket-id').val()
        }
    </script>
    <script src="https://cdn.socket.io/4.7.5/socket.io.min.js"
            integrity="sha384-2huaZvOR9iDzHqslqwpR87isEmrfxqyWOF7hr7BY6KG0+hVKLoEXMPUJw3ynWuhO"
            crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ asset('js/user-chat.js') }}"></script>
@endsection
