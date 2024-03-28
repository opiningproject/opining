@foreach($chats as $chat)
@if($chat->id !== auth()->id())

<div class="ChatDiv-type">
    <div class="ChatDiv-list" id="{{$chat->chats->id}}">
        <input type="hidden" name="sender_id" class="sender_id" value="{{ $chat->chats->sender_id }}" id="sender_id_{{$chat->chats->sender_id}}">
        <input type="hidden" name="receiver_id" class="receiver_id" value="{{ $chat->chats->receiver_id }}" id="receiver_id_{{$chat->chats->sender_id}}">
        <input type="hidden" name="user_status" class="user_status" value="{{ $chat->chats->is_online }}" id="user_status_{{$chat->chats->receiver_id}}">
        <input type="hidden" name="chat_id" class="chat_id" value="{{ $chat->chats->id }}" id="chat_{{$chat->chats->id}}">
        <div
            class="ChatDiv-item d-flex align-items-center justify-content-start gap-3" id="chat_item_{{ $chat->chats->receiver_id }}" data-id="{{ $chat->chats->receiver_id }}" data-test="{{$chat->chats->id}}">
            <img src="images/user-profile.png" alt="Profile-Img" class="img-fluid"
                 width="56" height="56">
            <div class="text-grp d-flex flex-column sender_name">
                <div class="title">{{ $chat->first_name }}</div>
                <div class="text">{{ $chat->chats->created_at->format('h:i a | d, M Y') }}</div>
            </div>
        </div>
    </div>
</div>
@endif
@endforeach