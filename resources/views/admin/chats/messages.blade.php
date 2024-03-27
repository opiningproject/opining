
@foreach($messages as $message)
<div class="chat-item d-flex align-items-end justify-content-start gap-3" style="{{$message->appendStyle}}">
    <img src="images/user-profile.png" alt="Profile-Img" class="img-fluid" width="56" height="56">
    <div class="chat-item-textgrp d-flex flex-column gap-2 gap-sm-3">
        <p style={{$message->messageStyle}}>{{$message->message}}</p>
        <small>{{ $message->created_at->format('h:m a') }}</small>
    </div>
</div>
@endforeach



