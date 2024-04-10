@foreach($messages as $message)
    @if($message->receiver_id)
        @php
            $image = asset('images/user-profile-img.svg');
            if ($message->sender->id != 1 && $message->receiver->id) {
                $image = $message->sender->image ? $message->sender->image : $message->receiver->image;
            }
        @endphp
    @endif
    <div class="chat-item d-flex align-items-end justify-content-start gap-3" style="{{$message->appendStyle}}" >
        {{ $message->first_name }}
        <img src="{{ $image }}" alt="Profile-Img" class="img-fluid" width="56" height="56">
        <div class="chat-item-textgrp d-flex flex-column gap-2 gap-sm-3 user-chat">
            <p style={{$message->messageStyle}}>{{$message->message}}</p>
            <small>{{ $message->created_at->format('h:m a') }}</small>
        </div>
    </div>
@endforeach
{{--@foreach($messages as $message)
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
            <p style={{$message->messageStyle}}>{{$message->message}}</p>
            <small>{{ $message->created_at->format('h:m a') }}</small>
        </div>
    </div>
@endforeach--}}



