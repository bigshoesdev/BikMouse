var https = require('https');
var _ = require('underscore');
var app = require('express')();
var fs = require('fs');

var options = {
    key: fs.readFileSync('/etc/letsencrypt/live/radiocorn.co.kr/privkey.pem'),
    cert: fs.readFileSync('/etc/letsencrypt/live/radiocorn.co.kr/fullchain.pem')
};
var serverPort = 3000;
var server = https.createServer(options, app);
var io = require('socket.io')(server);

var roomList = {};

io.on('connection', function (socket) {
    socket.emit('connected_to_server', { success: true });

    socket.on('room_create', function (data) {
        console.log('room_create');
        socket.user = data.chatInfo.user;
        var room = data.chatInfo.broadcast.id;
        if (!roomList[room]) {
            roomList[room] = { created_by: { user: socket.user }, userList: [], start: true };
        }
        socket.join(room);
        socket.room = room;
        socket.isHost = true;
        socket.emit('room_message', { type: 'create', user: socket.user });
        // socket.broadcast.to(room).emit('room_message', { type: 'create', user: socket.user });
        socket.emit('room_number', { number: roomList[room].userList.length });
        // socket.broadcast.to(room).emit('room_number', { number: roomList[room].userList.length });
    });

    socket.on('room_end', function (data) {
        console.log('room_end');
        var room = socket.room;
        var roomItem = roomList[room];
        room.start = false;
        roomItem.userList = [];
        io.sockets.in(socket.room).emit('room_message', { type: 'end', user: socket.user });
        io.sockets.in(socket.room).emit('room_number', { number: roomItem.userList.length });
        io.sockets.in(socket.room).emit('room_message', { type: 'no_room' });
    });

    socket.on('room_join_user', function (data) {
        console.log('room_join_user');
        var room = data.chatInfo.broadcast.id;
        if (roomList[room]) {
            socket.join(room);
            socket.user = data.chatInfo.user;
            socket.room = room;
            var index = _.findIndex(roomList[room].userList, function (user) { return user.chatname == socket.user.chatname });
            if (index < 0) {
                roomList[room].userList.push(socket.user);
                io.sockets.in(socket.room).emit('room_message', { type: 'join_user', user: socket.user });
            }
            io.sockets.in(socket.room).emit('room_number', { number: roomList[room].userList.length });
        } else {
            io.sockets.in(socket.room).emit('room_message', { type: 'no_room' });
        }
    });

    socket.on('room_broadcast_message', function (data) {
        console.log('room_broadcast_message');
        var room = socket.room;
        if (roomList[room]) {
            io.sockets.in(socket.room).emit('room_message', { type: 'message', message: data.message, user: socket.user });
        }
    });

    socket.on('room_send_present', function (data) {
        console.log('room_send_present');
        var room = socket.room;
        if (roomList[room]) {
            io.sockets.in(socket.room).emit('room_message', { type: 'present', amount: data.amount, user: socket.user });
        }
    });

    socket.on('disconnect', function () {
        var room = socket.room;
        var user = socket.user;
        if (roomList[room]) {
            console.log("roomList" + JSON.stringify(roomList[room]));
            if (roomList[room].created_by.chatname == user.chatname) {
                // delete roomList[room];
                // io.sockets.in(socket.room).emit('room_message', { type: 'no_room' });
                // io.sockets.in(socket.room).emit('room_message', { type: 'end', user: socket.user });
                // io.sockets.in(socket.room).emit('room_number', { number: 0 });
                // for (var s in io.nsps["/"].adapter.rooms[room].sockets) {
                //     io.nsps['/'].connected[s].leave(socket.room)
                // }
            } else {
                var userList = roomList[room].userList;
                console.log("disjoin_user" + JSON.stringify(socket.user));
                console.log("disjoin_user" + JSON.stringify(userList));
                roomList[room].userList = _.filter(userList, function (user) { return user.chatname != socket.user.chatname });
                console.log("disjoin_user_length" + roomList[room].userList.length);
                io.sockets.in(socket.room).emit('room_number', { number: roomList[room].userList.length });
                io.sockets.in(socket.room).emit('room_message', { type: 'disjoin_user', user: socket.user });
                socket.leave(room);
            }
        }
    });
});

server.listen(serverPort, function () {
    console.log('server up and running at %s port', serverPort);
});