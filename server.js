var express = require("express");
var app = express();

//creating an in

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

    io.to(socket.id).emit('socketConnectionSecured', socket.id)

    socket.on('sendChatToServer', (message) => {
        console.log(message);

        // io.sockets.emit('sendChatToClient', message);
        io.to(socket.id).emit('sendChatToClient', message);
    });
});
