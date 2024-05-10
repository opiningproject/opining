var express = require("express");
var app = express();
var mysql = require('mysql');

var connection = mysql.createConnection({
    host: "164.90.253.87",
    user: "go-meal",
    password: "GgiJ-9j$ceDn6oF",
    database: "go-meal"
});

connection.connect(function (err) {
    if (err) throw err;
    console.log("SQl Connected!");
});

// creating http instance
var http = require("http").createServer(app);

// creating socket io instance
var io = require('socket.io')(http, {
    cors: {
        origin: "*",
        methods: ['GET', 'POST'],
        credentials: true
    }
});

// start the server
http.listen(3000, function () {
    console.log("Server started");
});

io = io.of('/web-socket');

io.on("connection", function (socket) {
    console.log("User connected", socket.id);
    // io.sockets.emit('socketConnectionSecured', socket.id);
    socket.on('updateSocketId', (userId) => {
        // console.log("in", userId, "soketId", socket.id)
        connection.query("UPDATE users SET `socket_id` = " + "'" + socket.id + "'" + ", `is_online` = '1' WHERE `id` = " + userId)
    });

    socket.on('sendAdminChatToServer', (messageData) => {
        // console.log("messageData", messageData);
        var adminMessage = {
            sender_id: messageData.sender_id,
            receiver_id: messageData.receiver_id,
            message: messageData.message,
            socketId: messageData.receiver_socket,
            fileName: messageData.fileName,
        }

        if (messageData.type == "user") {
            io.to(socket.id).emit('sendChatToUser', adminMessage);
            socket.on('getMessage', (userMessageData) => {
                console.log("getMessageUser")
                // io.emit('getMessageUser', userMessageData);
                io.to(messageData.socketId).emit('getMessageUser', userMessageData);
            })
        }
        if (messageData.type == "admin") {
            io.emit('sendChatToClient', adminMessage);
            // socket.on('getMessage', (userMessageData) => {
            //     console.log("getMessageAdmin")
            //     io.emit('getMessageAdmin', userMessageData);
            // })
        }
        socket.on('getMessage', (userMessageData) => {
            if (messageData.type == "admin") {
                io.to(adminMessage.socketId).emit('getMessageAdmin', userMessageData);
                // io.emit('getMessageAdmin', userMessageData);
            }
        })
        // realtime message send
        /*socket.on('getMessage', (userMessageData) => {
            console.log("userMessageData", userMessageData)
            if (messageData.type == "user") {
                io.emit('getMessageUser', userMessageData);
            }
            if (messageData.type == "admin") {
                // io.to(adminMessage.socketId).emit('getMessageAdmin', userMessageData);
                io.emit('getMessageAdmin', userMessageData);
            }
        })*/
        // io.to(messageData.receiver_id).emit('sendChatToClient', adminMessage);
    });

    // Listen for disconnection
    socket.on("disconnect", () => {
        // console.log("disconnect")
        connection.query("UPDATE users SET `is_online` = '0' WHERE `socket_id` =" + "'" + socket.id + "'")
    });
});
