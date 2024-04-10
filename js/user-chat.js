// creating io instance
var socket = io("http://localhost:3000/");

let senderId = null;
var sender = $('#auth-user-id').val();
let page = 1;
let fetchingOldMessages = false;
let userId = $('#auth-user-id').val();
let chatListpage = 1;

socket.on('sendChatToUser', (message) => {
    message.file = $('.chat_attachment').prop('files')[0]
    console.log("message", message)
    $.ajax({
        type:"POST",
        url:baseURL+'/user/chat/store',
        data:message,
        success: function(data){
            if (data.status =="200") {
                var html = '<div class="chat-item d-flex align-items-end justify-content-start gap-3" style="margin-left:auto;flex-direction:row-reverse">\n' +
                    '        \n' +
                    '        <img src=' + data.data.userImage + ' alt="Profile-Img" class="img-fluid" width="56" height="56">\n' +
                    '        <div class="chat-item-textgrp d-flex flex-column gap-2 gap-sm-3 user-chat">\n' +
                    '            <p style="background-color:var(--theme-cyan1);margin-left:auto;">'+ data.data.message +'</p>\n' +
                    '            <small>'+ data.data.createdAt +'</small>\n' +
                    '        </div>\n' +
                    '    </div>'
                $('.chat-messages-user').append(html)
                $('.message-input').val('')
                $('.chat-messages-user').animate({scrollTop:0}, 500);
            }
        },
        error: function(data){
            alert("Error")
        }
    });
});

console.log('socket',socket)
socket.on('socketConnectionSecured', (message) => {
    console.log('socketId----', message)
    $('#socket-id').val(message)
});

let connectionData = {
    userId: senderId,
}
socket.emit('connectionEstablished, ')

$(function (){
    $('.send-btn-user').click(function (){
        var message = $('.message-input').val();
        var socketId = $('#socket-id').val();
        console.log("socketId",socketId)
        var receiver_id = $('.receiver_id').val();
        var sender_id = $('.sender_id').val();
        var attachment = $('.chat_attachment').prop('files')[0];
        console.log("attachment", attachment)
        console.log("receiver_id",receiver_id, "sender_id",sender_id)
        var messageData = {
            'sender_id': sender_id,
            'receiver_id': receiver_id,
            'receiver_socket': 'PfiZgCle4_nMzNgvAAAF',
            'message': message,
            // 'fileAttachment': attachment,
            'type':"user"
        }
        socket.emit('sendAdminChatToServer', messageData);
    })
})


$('.chat-messages-user').on('scroll', function() {
    if($(this).scrollTop() === 0 && !fetchingOldMessages) {
        // User has scrolled to the top
        // Perform AJAX call here
        fetchingOldMessages = true
        chatListpage++
        fetchChatUsers();
        $('.chat-messages-user').animate({scrollTop:0}, 500);

    }
});


function fetchChatUsers() {

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

            $('.chat-messages-user').append(this.responseText)
            var chatboxMain = $('.chat-messages-user');
            var contentHeight = chatboxMain[0].scrollHeight;
            var containerHeight = chatboxMain.innerHeight();

            if (contentHeight > containerHeight  && page === 1) {
                $('.chat-messages-user').animate({scrollTop: chatboxMain.offset().top + contentHeight - 726}, 1000);
            }

        }
    };

    const url = `chat/users?&page=${chatListpage}`; // Base URL
    xhttp.open("GET", url, true);
    xhttp.send();
}
fetchChatUsers();
