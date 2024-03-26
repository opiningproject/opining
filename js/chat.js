// creating io instance
var socket = io("http://localhost:3000/");

var receiver = "";
var sender = "";
socket.on('sendChatToClient', (message) => {
    alert('message',message);
});

socket.on('socketConnectionSecured', (message) => {
    console.log('socketId', message)
    $('#socket-id').val(message)
});

$(function (){
    $('#send-btn').click(function (){
        socket.emit('sendChatToServer', 'test');
    })
})


function fetchMessages(senderId, receiverId) {
    $.get(`chat/messages/${senderId}`, { receiver_id: receiverId }, function(response) {
        $('#chat-messages').html(response)
    });
}


$(document).on('click', '.sender_name', function () {
    var senderId = $(this).data('id');
    var receiverId = $('#receiver_id_'+senderId).val(); 
    let status = $('#user_status_'+senderId).val(); 
    let initialSenderName = status == '1' ? $(".profile-text").html('<span class="activicon"></span> Online') :  $(".profile-text").html('<span class="inactivicon"></span> Offline');


    var senderName = $(this).find('.title').text(); // Get the sender's name
    $('#chatbox-username').text(senderName); // Update displayed username
 
    fetchMessages(senderId, receiverId);
});

function formatDate(date, format) {
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var seconds = date.getSeconds();
    var ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // Handle midnight
    minutes = minutes < 10 ? '0' + minutes : minutes;
    seconds = seconds < 10 ? '0' + seconds : seconds;
    var formattedTime = format.replace('h', hours).replace('mm', minutes).replace('ss', seconds).replace('A', ampm);
    return formattedTime;
}


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
