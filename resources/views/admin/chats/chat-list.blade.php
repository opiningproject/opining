@foreach($chats as $chat)
<div class="ChatDiv-type">
    <div class="ChatDiv-list">
        <input type="hidden" name="sender_id" value="{{ $chat->sender_id }}" id="sender_id_{{$chat->sender_id}}">
        <input type="hidden" name="receiver_id" value="{{ $chat->receiver_id }}" id="receiver_id_{{$chat->sender_id}}">
        <input type="hidden" name="user_status" value="{{ $chat->sender->is_online }}" id="user_status_{{$chat->sender_id}}">
        <div
            class="ChatDiv-item d-flex align-items-center justify-content-start gap-3" id="chat_item_{{ $chat->receiver_id }}" data-id="{{ $chat->receiver_id }}">
            <img src="images/user-profile.png" alt="Profile-Img" class="img-fluid"
                 width="56" height="56">
            <div class="text-grp d-flex flex-column sender_name">
                <div class="title">{{ $chat->receiver->first_name }}</div>
                <div class="text">{{ $chat->created_at->format('h:i a | d, M Y') }}</div>
            </div>
        </div>
    </div>
</div>
@endforeach