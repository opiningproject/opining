
<div class="row">
    <input type="search" name="q" id="search-chat" class="search-box" value="{{$q}}" placeholder="Search...">
</div>

@foreach($chats as $chat)
<div class="ChatDiv-type">
    <div class="ChatDiv-list">
        <input type="hidden" name="sender_id" value="{{ $chat->sender_id }}" id="sender_id">
        <input type="hidden" name="receiver_id" value="{{ $chat->receiver_id }}" id="receiver_id">
        <div
            class="active ChatDiv-item d-flex align-items-center justify-content-start gap-3">
            <img src="images/user-profile.png" alt="Profile-Img" class="img-fluid"
                 width="56" height="56">
            <div class="text-grp d-flex flex-column sender_name" data-id="{{ $chat->sender_id }}">
                <div class="title">{{ $chat->sender->first_name }}</div>
                <div class="text">{{ $chat->created_at->format('h:i a | d, M Y') }}</div>
            </div>
        </div>
    </div>
</div>
@endforeach