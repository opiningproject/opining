// creating io instance
var socket = io("https://gomeal-qa.inheritxdev.in/web-socket", {transports: ['websocket', 'polling', 'flashsocket']});

socket.on('sendChatToClient', (message) => {
    $.ajax({
        type: "POST",
        url: baseURL + '/chat/store',
        data: message,
        success: function (data) {
            if (data.status == "200") {
                if (data.data.attachment) {
                    var html = '<div class="chat-item d-flex align-items-end justify-content-start gap-3" style="margin-left:auto;flex-direction:row-reverse">\n' +
                        '        \n' +
                        '        <img src="' + data.data.userImage + '" alt="Profile-Img" class="img-fluid" width="56" height="56">\n' +
                        '        <div class="chat-item-textgrp d-flex flex-column gap-2 gap-sm-3 user-chat">\n' +
                        (data.data.message != null ? '<p class="rightChat" style="background-color:var(--theme-cyan1);margin-left:auto;">' + data.data.message + '</p>\n':'') +
                        (data.data.attachment ?
                            '                <a href="' + data.data.attachment + '" target="_blank">\n' +
                            '                       <img src="' + data.data.attachment + '" style="height: 100px;width: 100px;">\n' +
                            '                </a>\n' : '') +
                        '            <small style="text-align:right">' + data.data.createdAt + '</small>\n' +
                        '        </div>\n' +
                        '    </div>'
                    $('.chat-messages').append(html)
                    $('.message-input').val('')
                }
                socket.emit('sendMessageAdmin', data.data);
                // $('.chat-messages').animate({scrollTop:0}, 500);
                var chatBoxMain = $('.chat-messages');
                var contentHeight = chatBoxMain[0].scrollHeight;

                $('.chat-messages').animate({scrollTop: chatBoxMain.offset().top + contentHeight - 726}, 500);
            }
        },
        error: function (data) {
            alert("Error")
        }
    });
});

socket.on('socketConnectionSecured', (message) => {
    $('#socket-id').val(message)
});

// socket.emit('connectionEstablished')
$(function () {
    // checkNotifiedOrders()
    // $('#newOrderModal').modal('show')
})

function checkNotifiedOrders(){
    $.ajax({
        type: 'GET',
        url: baseURL + '/orders/not-notified-orders',
        success: function (data) {
            $('#order-modal-div').html(data)
            $('.order-notification-popup').modal('show')
        },
        error: function (data) {
            alert("Error")
        }
    });
}
