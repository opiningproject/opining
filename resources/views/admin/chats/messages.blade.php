@php
    $previousKey = null;
@endphp
@foreach($messages as $key => $msg)
    <p class="message-date text-center">
        <span class="date_hidden {date_new_{$key}}" style="display: none"> {{$key}} </span>
        @if($previousKey != $key)
            <span class="d-inline-block date_show" id="date_show"> {{$key}} </span>
            <span class="page_count" style="display: none"> {{ $pageCount }} </span>
        @endif
    </p>
    @php $previousKey = $key @endphp
    @foreach($msg as $message)
        @if($message->receiver_id)
            @php
                $image = asset('images/user-profile-img.svg');
                if ($message->sender->id != 1 && $message->receiver->id) {
                    $image = $message->sender->image ? $message->sender->image : $message->receiver->image;
                }
            @endphp
        @endif
        <div class="chat-item d-flex align-items-end justify-content-start gap-3" style="{{$message->appendStyle}}">
            <img src="{{$image}}" alt="Profile-Img" class="img-fluid" width="56" height="56">
            <div class="chat-item-textgrp d-flex flex-column gap-2 gap-sm-3">
                @if($message->message!= null)
                    <p class="{{$message->messageClass}}" style={{$message->messageStyle}}>{{$message->message}}</p>
                @endif
                @if($message->attachment)
                    <a href="{{ $message->attachment }}" target="_blank">
                        <img src="{{$message->attachment}}" style="height: 100px;width: 100px;">
                    </a>
                @endif
                <small
                    style="text-align: {{$message->messageClass == "rightChat" ? 'right' : 'left' }};">{{ date('h:i A', strtotime($message->created_at)) }}</small>
            </div>
        </div>
    @endforeach
@endforeach



