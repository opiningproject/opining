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

