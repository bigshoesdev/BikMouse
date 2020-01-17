$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var APP = APP || {};
    APP.rootpath = APP.rootpath || $('meta[name="root-path"]').attr('content');

    var socket = io('https://radiocorn.co.kr:3000');

    $("#chat-message-input").emojioneArea({
        events: {
            keyup: function (editor, event) {
                if (event.which == 13) {
                    this.trigger('change');
                    $("#chat-message-send-btn").trigger("click");
                }
            }
        }
    });

    socket.on('connected_to_server', function (data) {
        if (data.success) {
            console.log('connected to server');
            if(typeof(chatInfo) !== 'undefined') {
                socket.emit('room_join', {chatInfo: chatInfo});
            }
        }
    });

    socket.on('room_connected', function () {
        roomConnect = true;
    });

    socket.on('user_repeat', function () {
        alert('You are already in broadcasting or viewing the broadcast.');
        location.replace($('body').data('homeurl'));
    });

    socket.on('room_number', function (data) {
        $(".viewer_num").html(data.number);
    })

    socket.on('room_message', function (data) {
        $.loader.close();
        console.log(data.type);
        switch (data.type) {
            case 'start':
                addMessage('start', data.user);
                document.getElementById('BikMouseRecorder').doConnect();
                $("#broadcast_start_btn").hide();
                $("#broadcast_stop_btn").show();
                break;
            case 'end':
                addMessage('end', data.user);
                document.getElementById('BikMouseRecorder').disConnect();
                $("#broadcast_start_btn").show();
                $("#broadcast_stop_btn").hide();
                break;
            case 'block':
                addMessage('block', data.user);
                setTimeout(function () {
                    location.replace($("body").data('homeurl'));
                }, 1000);
                break;
            case 'message':
                addMessage('message', data.user, data.message);
                break;
        }
    })

    $("#broadcast_start_btn").click(function() {
        if(typeof(chatInfo) !== 'undefined') {
            $.loader.open();
            socket.emit('room_start');
        }
    });

    $('#broadcast_stop_btn').click(function() {
        $.loader.open();
        socket.emit('room_stop');
    });

    $("#chat-message-send-btn").click(function () {
        var message = $("#chat-message-input").val();
        var el = $("#chat-message-input").emojioneArea();
        el[0].emojioneArea.setText('');
        socket.emit('room_broadcast_message', {message: message});
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
                    '<span class="user_name">' + user.nick_name + '</span><i class="name_dot_chat">：</i>' +
                    '<span class="user_text_content">' + 'This broadcast has been started.' + '</span>' +
                    '</li>';
                container.append(html);
                $("#marquee-text").html('<b>' + user.nick_name + '</b>: This broadcast has been started.');
                break;
            case 'end':
                var html = '<li class="chat-message-item">' +
                    '<span class="user_grade"><p class="grade_num" style="background:#6bc9e3;">' + user.level + '</p></span>' +
                    '<span class="user_name">' + user.nick_name + '</span><i class="name_dot_chat">：</i>' +
                    '<span class="user_text_content">' + 'This broadcsat has been stopped' + '</span>' +
                    '</li>';
                container.append(html);
                $("#marquee-text").html('<b>' + user.nick_name + '</b>: This broadcast has been stopped.');
                break;
            case 'block':
                var html = '<li class="chat-message-item">' +
                    '<span class="user_grade"><p class="grade_num" style="background:#6bc9e3;">' + user.level + '</p></span>' +
                    '<span class="user_name">' + user.nick_name + '</span><i class="name_dot_chat">：</i>' +
                    '<span class="user_text_content">' + 'This broadcast has been blocked.' + '</span>' +
                    '</li>';
                container.append(html);
                $("#marquee-text").html('<p>This broadcast has been blocked.</p>');
                break;
            case 'message':
                var html = '<li class="chat-message-item">' +
                    '<span class="user_grade"><p class="grade_num" style="background:#6bc9e3;">' + user.level + '</p></span>' +
                    '<span class="user_name">' + user.nick_name + '</span><i class="name_dot_chat">：</i>' +
                    '<span class="user_text_content">' + message + '</span>' +
                    '</li>';
                container.append(html);
                $("#marquee-text").html('<b>' + user.nick_name + '</b>: ' + message);
                break;
        }
    }
});