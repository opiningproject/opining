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
        console.log("messageData",messageData);
            var adminMessage = {
                sender_id: messageData.sender_id,
                receiver_id: messageData.receiver_id,
                message: messageData.message
                // attachment: messageData.fileAttachment
            }
            if (messageData.type == "user") {
                io.sockets.emit('sendChatToUser', adminMessage);
            }
            if (messageData.type == "admin") {
                io.sockets.emit('sendChatToClient', adminMessage);
            }
        // io.to(messageData.receiver_id).emit('sendChatToClient', adminMessage);
    });

    // Listen for disconnection
    socket.on('disconnect', async () => {
        console.log('A user disconnected');
        // Handle user disconnection (e.g., update database)
    });
});
