$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.loader.open();

    var timerFlashID = setInterval(function () {
        if (isFlashLoaded && roomConnect) {
            $.loader.close();
            clearInterval(timerFlashID);
        }
    }, 500);

    var socket = io('https://radiocorn.co.kr:3000');

    socket.on('connected_to_server', function (data) {
        if (data.success) {
            console.log('connected to server');
            socket.emit('room_join', {chatInfo: chatInfo});
        }
    });

    socket.on('room_connected', function () {
        roomConnect = true;
        socket.emit('room_join_user');
    });

    socket.on('user_repeat', function () {
        alert('You are already in broadcasting or viewing the broadcast.');
        location.replace($('body').data('homeurl'));
    });

    socket.on('room_number', function (data) {
        console.log('room_number');
        $("#room-number").html(data.number);
    })

    socket.on('room_message', function (data) {
        console.log(data.type);
        switch (data.type) {
            case 'start':
                addMessage('start', data.user);
                socket.emit('room_join_user');
                document.getElementById('BikMousePlayer').playAgain();
                break;
            case 'end':
                addMessage('end', data.user);
                break;
            case 'block':
                addMessage('block', data.user);
                break;
            case 'message':
                addMessage('message', data.user, data.message);
                break;
        }
    })


    $("#delete-broadcast-btn").click(function () {
        socket.emit('broadcast_block');

        setTimeout(function () {
            location.replace($("#delete-broadcast-btn").data('deleteurl'));
        }, 2000);
    });


    function addMessage(type, user, message) {
        var container = $("#chat-message-container");
        var messageLength = $("#chat-message-container .chat-message-item").length;
        if (messageLength >= 10) {
            $("#chat-message-container .chat-message-item:first").remove();
        }
        switch (type) {
            case 'start':
                var html = '<li class="chat-message-item">' +
                    '<span class="user_grade"><p class="grade_num" style="background:#6bc9e3;">' + user.level + '</p></span>' +
                    '<span class="user_name">' + user.nick_name + '</span><span class="name_dot_chat">：</span>' +
                    '<span class="user_text_content">' + 'Broadcast is Created' + '</span>' +
                    '</li>';
                container.append(html);
                $("#marquee-text").html('<b>' + user.nick_name + '</b>: Broadcast is Created.');
                break;
            case 'end':
                var html = '<li class="chat-message-item">' +
                    '<span class="user_grade"><p class="grade_num" style="background:#6bc9e3;">' + user.level + '</p></span>' +
                    '<span class="user_name">' + user.nick_name + '</span><span class="name_dot_chat">：</span>' +
                    '<span class="user_text_content">' + 'Broadcast is Ended' + '</span>' +
                    '</li>';
                container.append(html);
                $("#marquee-text").html('<b>' + user.nick_name + '</b>: Broadcast is Ended.');
                break;
            case 'block':
                var html = '<li class="chat-message-item">' +
                    '<span class="user_grade"><p class="grade_num" style="background:#6bc9e3;">' + user.level + '</p></span>' +
                    '<span class="user_name">' + user.nick_name + '</span><span class="name_dot_chat">：</span>' +
                    '<span class="user_text_content">' + 'Broadcast is blocked' + '</span>' +
                    '</li>';
                container.append(html);
                $("#marquee-text").html('<p>Broadcast is blocked.</p>');
                break;
            case 'message':
                var html = '<li class="chat-message-item">' +
                    '<span class="user_grade"><p class="grade_num" style="background:#6bc9e3;">' + user.level + '</p></span>' +
                    '<span class="user_name">' + user.nick_name + '</span><span class="name_dot_chat">：</span>' +
                    '<span class="user_text_content">' + message + '</span>' +
                    '</li>';
                container.append(html);
                $("#marquee-text").html('<b>' + user.nick_name + '</b>: ' + message);
                break;
        }
    }
})