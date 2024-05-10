// creating io instance
var socket = io("https://gomeal-qa.inheritxdev.in/web-socket", {transports: ['websocket', 'polling', 'flashsocket']});

let senderId = null;
var sender = $('#auth-user-id').val();
let page = 1;
let fetchingOldMessages = false;
let userId = $('.auth-user-id').val();
let chatListpage = 1;
let socketId = null;
var sender_id = $('.sender_id').val();
var receiver_id = $('.receiver_id').val();

socket.on('socketConnectionSecured', (message) => {
    // console.log('socketId-----', message)
    socketId = message;
    $('#socket-id').val(message)
});

var userIdData = localStorage.getItem("user_id")
/*console.log("userIdData", socket.id)

console.log("userLogin", userLogin.id, "socketId",socketId)*/
socket.emit('updateSocketId', userLogin.id)

let lastReceivedMessageTimestamp = 0;
socket.on('getMessageAdmin', (data) => {
    console.log("getMessageAdmin")
    if (data.timestamp > lastReceivedMessageTimestamp) {
        lastReceivedMessageTimestamp = data.timestamp;
        var getAdminMessageData = "";
        getAdminMessageData = '<div class="chat-item chat-box-md d-flex align-items-end justify-content-start gap-3"  style="margin-left:inherit;flex-direction:row">\n' +
            '        <img src=' + data.userImage + ' alt="Profile-Img" class="img-fluid" width="56" height="56">\n' +
            '        <div class="chat-item-textgrp d-flex flex-column gap-2 gap-sm-3 user-chat user-chat-row">\n' +
            (data.message != null ? '<p class="leftChat" style="background-color:#DBDBDB;margin-left:inherit;">' + data.message + '</p>\n' : '') +
            (data.attachment ?
                '                <a href="' + data.attachment + '" target="_blank">\n' +
                '                       <img src="' + data.attachment + '" style="height: 100px;width: 100px;">\n' +
                '                </a>\n' : '') +
            '            <small>' + data.createdAt + '</small>\n' +
            '        </div>\n' +
            '    </div>';
        $('.chat-messages-user_' + sender).append(getAdminMessageData)
        getAdminMessageData = '';
       $('.chat-messages-users').html('')
        chatListpage = 1
        fetchChatUsers()
    }
})

socket.on('sendChatToUser', (message) => {
    $.ajax({
        type: "POST",
        url: baseURL + '/user/chat/store',
        data: message,
        success: function (data) {
            if (data.status == "200") {
                if (data.data.attachment) {
                    var html = '<div class="chat-item chat-box-md d-flex align-items-end justify-content-start gap-3 user_' + data.data.sender_id + '" style="margin-left:auto;flex-direction:row-reverse">\n' +
                        '        \n' +
                        '        <img src=' + data.data.userImage + ' alt="Profile-Img" class="img-fluid" width="56" height="56">\n' +
                        '        <div class="chat-item-textgrp d-flex flex-column gap-2 gap-sm-3 user-chat user-chat-row">\n' +
                        (data.data.message != null ? '<p style="background-color:var(--theme-cyan1);margin-left:auto;">' + data.data.message + '</p>\n' : '') +
                        (data.data.attachment ?
                            '                <a href="' + data.data.attachment + '" target="_blank">\n' +
                            '                       <img src="' + data.data.attachment + '" style="height: 100px;width: 100px;">\n' +
                            '                </a>\n' : '') +
                        '            <small>' + data.data.createdAt + '</small>\n' +
                        '        </div>\n' +
                        '    </div>'
                    $('.chat-messages-user_' + data.data.sender_id).append(html)
                    html = ''
                    $('.message-input').val('')
                }
                socket.emit('getMessage', data.data);
                // $('.chat-messages-user').animate({scrollTop: 0}, 500);
                var chatboxMain = $('.chat-messages-user_' + data.data.sender_id);
                var contentHeight = chatboxMain[0].scrollHeight;

                $('.chat-messages-user_' + data.data.sender_id).animate({scrollTop: chatboxMain.offset().top + contentHeight - 726}, 1000);
            }
        },
        error: function (data) {
            alert("Error")
        }
    });
});


let connectionData = {
    userId: senderId,
}
// socket.emit('connectionEstablished, ')
$(function () {
    $('.send-user-btn').click(function () {
        var message = $('.message-input').val();
        var socketId = $('#socket-id').val();
        receiver_id = $('.receiver_id').val();
        var attachment = $('.chat_attachment').prop('files')[0];
        var form_data = new FormData();
        form_data.append("file", attachment);
        if (attachment) {
            $.ajax({
                type: "POST",
                processData: false,
                contentType: false,
                url: baseURL + '/user/chat/store/attachment',
                data: form_data,
                success: function (data) {
                    if (data.status == "200") {
                        // addCategoryReadURL(this);
                    }
                },
                error: function (data) {
                    alert("Error")
                }
            });
        }
        var fileName = attachment ? attachment.name : null;

            var messageData = {
                'sender_id': sender_id,
                'receiver_id': receiver_id,
                'receiver_socket': socketId,
                'message': message,
                'fileAttachment': attachment,
                "fileName": fileName,
                'type': "user"
            }
        if (fileName == null ) {
            var appendMessageHtml = '<div class="chat-item chat-box-md d-flex align-items-end justify-content-start gap-3 user_' + messageData.sender_id + '" style="margin-left:auto;flex-direction:row-reverse">\n' +
                '        \n' +
                '        <img src="' + userData.image + '" alt="Profile-Img" class="img-fluid" width="56" height="56">\n' +
                '        <div class="chat-item-textgrp d-flex flex-column gap-2 gap-sm-3 user-chat user-chat-row">\n' +
                (messageData.message ? '<p class="rightChat" style="background-color:var(--theme-cyan1);margin-left:auto;">' + messageData.message + '</p>\n':'') +
                (messageData.fileName ?
                    '                <a href="' + messageData.fileName + '" target="_blank">\n' +
                    '                       <img src="' + messageData.fileName + '" style="height: 100px;width: 100px;">\n' +
                    '                </a>\n' : '') +
                '            <small>' + new Date().toLocaleString('en-GB', { hour: 'numeric', minute: 'numeric', hour12: true, timeZone: 'Europe/London' }) + '</small>\n' +
                '        </div>\n' +
                '    </div>'
            $('.chat-messages-user_' + sender_id).append(appendMessageHtml)
            appendMessageHtml = ''
            $('.message-input').val('')
        }
        socket.emit('sendAdminChatToServer', messageData);
        $(".send-user-btn").prop('disabled', true);
        $(".image-holder").hide();
        $(".chat_attachment").val('');
        $('.attachImage').remove();
        $('.remove-image').remove();
    })
})
$(document).keypress(function () {
    if (event.which == 13) {
        $('.send-btn-user_' + sender_id).click();
    };
});

$('.chat-messages-user_' + sender_id).on('scroll', function () {
    var chatboxMain = $('.chat-messages-user_' + sender_id);
    var contentHeight = chatboxMain[0].scrollHeight;
    var containerHeight = chatboxMain.innerHeight();
    if (contentHeight > containerHeight && chatListpage === 1) {
        fetchingOldMessages = true
        chatListpage++
        fetchChatUsers();
        $('.chat-messages-user_' + sender_id).animate({scrollTop: 0}, 500);
    }

    /*if ($(this).scrollTop() === 0 && !fetchingOldMessages) {
        // User has scrolled to the top
        // Perform AJAX call here
        fetchingOldMessages = true
        chatListpage++
        fetchChatUsers();
        $('.chat-messages-user_' + sender_id).animate({scrollTop: 0}, 500);

    }*/
});


function fetchChatUsers() {

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            $('.chat-messages-user_' + sender_id).append(this.responseText)
            var chatboxMain = $('.chat-messages-user_' + sender_id);
            var contentHeight = chatboxMain[0].scrollHeight;
            var containerHeight = chatboxMain.innerHeight();

            if (contentHeight > containerHeight && page === 1) {
                $('.chat-messages-user_' + sender_id).stop().animate({ scrollTop: $(".chat-messages-users")[0].scrollHeight}, 1000);
            }

        }
    };

    const url = `chat/users?&page=${chatListpage}`; // Base URL
    xhttp.open("GET", url, true);
    xhttp.send();
}

fetchChatUsers();


// new js

// on keyup show hide send button
$(document).on('keyup', '.message-input', function () {
    $(".send-user-btn").removeAttr('disabled');
    if ($(".message-input").val() == '') {
        $(".send-user-btn").prop('disabled', true);
    }
})
// on change show image.
$(document).on('change', '.chat_attachment', function () {
    $(".image-holder").show();
    var ext = $('.chat_attachment').val().split('.').pop().toLowerCase();
    if ($.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
        alert('invalid extension!');
        $(".chat_attachment").val('');
        $(".image-holder").val('');
        $(".send-user-btn").prop('disabled', true);
        return false;
    }
    readURL(this);
    $(".send-user-btn").removeAttr('disabled');
})
// click on cross icon remove image.
$(document).on('click', '.remove-image', function () {
    $('.attachImage').closest('img').remove();
    $('.remove-image').closest('i').remove();
    $(".chat_attachment").val('');
})

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('.image-holder').append('<img class="attachImage" src="' + e.target.result + '" style="height: 100px; width: 100px;border-radius: 20%;"/> <i class="fa-solid fa-xmark remove-image"></i>');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

/*document.addEventListener('DOMContentLoaded', function () {
    Echo.private('brodcast-message')
        .listen('.getChatMessage', (data) => {
            if (sender_id == data.chat.receiver_id && receiver_id == data.chat.sender_id) {
                var htmlData = '<div class="chat-item d-flex align-items-end justify-content-start gap-3 user_"  style="margin-left:inherit;flex-direction:row">\n' +
                    '        \n' +
                    '        <img src=' + data.userImage + ' alt="Profile-Img" class="img-fluid" width="56" height="56">\n' +
                    '        <div class="chat-item-textgrp d-flex flex-column gap-2 gap-sm-3 user-chat">\n' +
                    '            <p style="background-color:var(--theme-chat-box);margin-left:inherit;">' + data.chat.message + '</p>\n' +
                    (data.chat.attachment ?
                        '                <a href="' + data.chat.attachment + '" target="_blank">\n' +
                        '                       <img src="' + data.chat.attachment + '" style="height: 100px;width: 100px;">\n' +
                        '                </a>\n' : '') +
                    '            <small>' + data.createdAt + '</small>\n' +
                    '        </div>\n' +
                    '    </div>';
                $('#chat-messages-user').append(htmlData);
            }
        })
})*/
