var https = require('https');
var _ = require('underscore');
var app = require('express')();
var fs = require('fs');
var db = require('./db');

var options = {
    //key: fs.readFileSync('/etc/letsencrypt/live/radiocorn.co.kr/privkey.pem'),
    //cert: fs.readFileSync('/etc/letsencrypt/live/radiocorn.co.kr/fullchain.pem')
    key: fs.readFileSync('./file.key'),
    cert: fs.readFileSync('./file.crt')
};
var serverPort = 3000;
var server = https.createServer(options, app);
var io = require('socket.io')(server);

var roomList = {};

var log4js = require('log4js');
log4js.configure({
    appenders: { log: { type: 'file', filename: 'log' } },
    categories: { default: { appenders: ['log'], level: 'error' } }
});

var logger = log4js.getLogger('log');

function isUserExist(user) {
    for (var r in roomList) {
        var room = roomList[r];
        if (room.created_by.id == user.id) {
            return true;
        }

        var userList = room.userList;
        for (var u in userList) {
            if (userList[u].id == user.id) {
                return true;
            }
        }
    }

    return false;
}

io.on('connection', function (socket) {
    socket.emit('connected_to_server', { success: true });

    socket.on('room_join', function (data) {
        console.log('room_join');
        var user = data.chatInfo.user;
        var room = data.chatInfo.broadcast.id;

        var result = isUserExist(user);

        if (!result) {
            socket.room = room;
            socket.user = user;
            socket.join(socket.room);
            console.log('room_connected');
            socket.emit('room_connected');
        } else {
            console.log('user_repeat');
            socket.emit('user_repeat');
        }
    })

    socket.on('room_start', function () {
        console.log('room_start');
        var room = socket.room;
        roomList[room] = { created_by: socket.user, userList: [] };
        socket.isHost = true;
        io.sockets.in(room).emit('room_message', { type: 'start', user: socket.user });
        io.sockets.in(room).emit('room_number', { number: roomList[room].userList.length });
    });

    socket.on('room_stop', function () {
        if (socket.user && socket.room) {
            if (socket.isHost) {
                console.log('room_stop');
                var room = socket.room;
                var roomItem = roomList[room];
                if (roomItem) {
                    db.Broadcast.update({
                        is_start: 0,
                        user_num: 0
                    }, { where: { bid: room } }).then(() => {
                        var roomItem = roomList[room];
                        io.sockets.in(room).emit('room_message', { type: 'end', user: roomItem.created_by });
                        io.sockets.in(room).emit('room_number', { number: 0 });
                        delete roomList[room];
                    })
                }
            }
        }
    })

    socket.on('start_broadcast', function (data) {
        console.log('start_broadcast');
        var room = data.bid;
        var roomItem = roomList[room];
        if (roomItem) {
            db.Broadcast.update({
                is_start: 1,
                user_num: 0
            }, { where: { bid: room } }).then((broadcast) => {
            })
        }
    })

    socket.on('broadcast_block', function () {
        var room = socket.room;
        if (roomList[room]) {
            var roomItem = roomList[room];
            db.Broadcast.update({
                is_start: 0,
                user_num: 0
            }, { where: { bid: room } }).then(() => {
                delete roomList[room];
                io.sockets.in(socket.room).emit('room_message', { type: 'block', user: socket.user });
                io.sockets.in(socket.room).emit('room_number', { number: 0 });
            })
        }
    });

    socket.on('room_join_user', function () {
        console.log('room_join_user');
        var room = socket.room;
        if (roomList[room]) {
            roomList[room].userList.push(socket.user);
            db.Broadcast.update({
                user_num: roomList[room].userList.length
            }, { where: { bid: room } }).then(() => {
                io.sockets.in(socket.room).emit('room_message', { type: 'join_user', user: socket.user });
                io.sockets.in(room).emit('room_number', { number: roomList[room].userList.length });
            });
            db.User.findOne({ where: { id: parseInt(socket.user.id) } }).then(user => {
                user.update({
                    view_num: user.view_num + 1
                }).then(() => {
                })
            })
        }
    })

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

    socket.on('stop_broadcast', function (data) {
        console.log("stop.broadcast");
        var room = data.bid;
        var roomItem = roomList[room];
        if (roomItem) {
            var roomItem = roomList[room];
            delete roomList[room];
            db.Broadcast.update({
                is_start: 0,
                user_num: 0
            }, { where: { bid: room } }).then(() => {
                io.sockets.in(room).emit('room_message', { type: 'end', user: roomItem.created_by });
                io.sockets.in(room).emit('room_number', { number: 0 });
            })
        }
    })

    socket.on('disconnect', function () {
        if (socket.user && socket.room) {
            if (socket.isHost) {
                console.log('host disconnect');
                var room = socket.room;
                var roomItem = roomList[room];
                if (roomItem) {
                    var roomItem = roomList[room];
                    delete roomList[room];
                    db.Broadcast.update({
                        is_start: 0,
                        user_num: 0
                    }, { where: { bid: room } }).then(() => {
                        io.sockets.in(room).emit('room_message', { type: 'end', user: roomItem.created_by });
                        io.sockets.in(room).emit('room_number', { number: 0 });
                    })
                }
            } else {
                console.log('client disconnect');
                var user = socket.user;
                var room = socket.room;
                if (!socket.isHost) {
                    if (roomList[room]) {
                        var userList = roomList[room].userList;
                        if (userList) {
                            roomList[room].userList = _.filter(userList, function (user) { return user.id != socket.user.id });
                            db.Broadcast.update({
                                user_num: roomList[room].userList.length
                            }, { where: { bid: room } }).then(() => {
                                socket.leave(room);
                                io.sockets.in(socket.room).emit('room_number', { number: roomList[room].userList.length });
                            })
                        }
                    }
                }
            }
        }
    });
});

server.listen(serverPort, function () {
    console.log('server up and running at %s port', serverPort);
});