var express = require("express");
var app = express();
var mysql = require('mysql');

var connection = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: ""
});
connection.connect(function(err) {
    if (err) throw err;
    console.log("SQl Connected!");
});

// creating http instance
var http = require("http").createServer(app);

// creating socket io instance
const io = require('socket.io')(http, {
    cors: { origin: "*"}
});

// start the server
http.listen(3000, function () {
    console.log("Server started");
});

io.on("connection", function (socket) {
    console.log("User connected", socket.id);
    // connection.query()
    io.to(socket.id).emit('socketConnectionSecured', socket.id)

    socket.on('sendAdminChatToServer', (messageData) => {
        console.log(messageData);
            var adminMessage = {
                sender_id: messageData.sender_id,
                message: messageData.message
            }
        // io.sockets.emit('sendChatToClient', message);
        io.to(messageData.receiver_id).emit('sendChatToClient', adminMessage);
    });
});
