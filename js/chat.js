// creating io instance
var socket = io("http://localhost:3000/");

var receiver = "";
var sender = $('#auth-user-id').val();
socket.on('sendChatToClient', (message) => {
    alert('message',message);
});
console.log('socket',socket)
socket.on('socketConnectionSecured', (message) => {
    console.log('socketId', message)
    $('#socket-id').val(message)
});

socket.on('userStatus', (message) => {
    console.log()
})
let connectionData = {
    userId: senderId,
}
socket.emit('connectionEstablished, ')

$(function (){
    $('#send-btn').click(function (){
        var messageData = {
            'sender_id': 2,
            'receiver_id': 4,
            'receiver_socket': 'PfiZgCle4_nMzNgvAAAF',
            'message': 'test'
        }
        socket.emit('sendAdminChatToServer', messageData);
    })
})

let page = 1;
let activeDivId = null;
let senderId = null;
let receiverId = null;
let fetchingOldMessages = false;

function fetchMessages(senderId, receiverId) {

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

            $('#chat-messages').prepend(this.responseText)

            var chatboxMain = $('#chat-messages');
            var contentHeight = chatboxMain[0].scrollHeight;
            var containerHeight = chatboxMain.innerHeight();

            if (contentHeight > containerHeight  && page === 1) {
                // Scroll to the bottom of the content
                // $('#chat-messages').scroll();
                // $("#chat-messages").animate({
                // scrollTop: contentHeight
                // }, 2000);

                $('#chat-messages').animate({scrollTop: chatboxMain.offset().top + contentHeight - 726}, 1000);
              }
        }
    };

    const url = `chat/messages/${senderId}?receiver_id=${receiverId}&page=${page}`; // Base URL
    xhttp.open("GET", url, true);
    xhttp.send();
}

$('#chat-messages').on('scroll', function() {
    if($(this).scrollTop() === 0 && !fetchingOldMessages) {

        // User has scrolled to the top
        // Perform AJAX call here
        fetchingOldMessages = true
        page++
        fetchMessages(senderId, receiverId);

        $('#chat-messages').animate({scrollTop:0}, 500);

    }
});


$(document).on('click', '.ChatDiv-item', function () {

    $('#chat-messages').html('')

    senderId = $(this).data('id');

    let parentDiv = $(this).closest('#chat_item_'+senderId);
    let clickedDivId = parentDiv.attr('id');

    // Deactivate previously active div
    if (activeDivId !== null) {
        $('#' + activeDivId).removeClass('active');
    }

    // Activate the clicked div
    parentDiv.addClass('active');
    activeDivId = clickedDivId;

    receiverId = $('#receiver_id_'+senderId).val();
    let status = $('#user_status_'+senderId).val();
    let initialSenderName = status == '1' ? $(".profile-text").html('<span class="activicon"></span> Online') :  $(".profile-text").html('<span class="inactivicon"></span> Offline');


    var senderName = $(this).find('.title').text(); // Get the sender's name
    $('#chatbox-username').text(senderName); // Update displayed username

    page = 1;
    fetchMessages(senderId, receiverId);
});


$(document).on('keyup', '#search-chat', function () {
    let search = $(this).val();

    $.ajax({
        url: baseURL + '/chat/search-chat?q='+search,
        type: 'GET',
        success: function (response) {
            $('#ChatDiv').html(response)
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
})


let chatListpage = 1;
let fetchingOldUsers = false;

function fetchChatUsers() {

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

            $('#ChatDiv').append(this.responseText)

            // var listBoxMain = $('#ChatDiv');
            // var listBoxContentHeight = listBoxMain[0].scrollHeight;
            // var lostBoxContainerHeight = listBoxMain.innerHeight();
            // if (listBoxContentHeight > lostBoxContainerHeight  && chatListpage === 1) {
            //   }
        }
    };

    const url = `chat/users?&page=${chatListpage}`; // Base URL
    xhttp.open("GET", url, true);
    xhttp.send();
}



// $('#ChatDiv').on('scroll', function() {
//     if(Math.round($(this).scrollTop() + $(this).innerHeight(), 10) >= Math.round($(this)[0].scrollHeight, 10)) {
//         fetchChatUsers();
//     }
// })



fetchChatUsers();
