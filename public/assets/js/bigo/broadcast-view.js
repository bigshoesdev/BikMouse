$(function () {
    var APP = APP || {};
    APP.rootpath = APP.rootpath || $('meta[name="root-path"]').attr('content');

    $.loader.open();

    var timerFlashID = setInterval(function () {
        if (isFlashLoaded && roomConnect) {
            $.loader.close();
            clearInterval(timerFlashID);
        }
    }, 500);

    var vue_app_loading_recom = new Vue({
        el: "#bigo_recom_box_e",
        data: {
            itempath: $('body').data('broadcastviewurl'),
            rootpath: APP.rootpath,
            todos: [],
            offset: 0,
            classify: 0,
            country: 0,
            limit: 5
        },
    });

    var addRecommendData = function () {
        var type = $('#room_video_e').data('type');
        var recommendUrl = '';
        if (type == 'live')
            recommendUrl = $('body').data('livelisturl');
        else
            recommendUrl = $('body').data('gamelisturl');

        $.getJSON(recommendUrl, {
            offset: vue_app_loading_recom.offset,
            classify: vue_app_loading_recom.classify,
            country: vue_app_loading_recom.country,
            limit: vue_app_loading_recom.limit
        }, function (json) {
            vue_app_loading_recom.todos = json;
        });
    };
    addRecommendData();
    $("#refresh_btn_e").on("click", function () {
        addRecommendData()
    });

    $("#chat_login_tips_e").on("click", function () {
        $("#login_btn_e").click()
    });

    $("#volume_horn_e").on("click", function (event) {
        var that = $(this);
        var volume = 0;
        var volumeProgressTag = $("#volume_progress_e");
        if (that.hasClass("statu_volume_off")) {
            volume = volumeProgressTag.width() / 100;
            volumeProgressTag.attr("volume", volume > 1 ? 1 : volume);
            VideoController.setVolumeAndProgress(0)
        } else {
            volume = +volumeProgressTag.attr("volume");
            VideoController.setVolumeAndProgress(volume)
        }
    });

    $("#volume_control_e").on("mousedown", ".volume_right_dot", function (event) {
        event.preventDefault();
        var x = event.pageX, that = $(this), par = that.parent(), parW = par.width(), maxW = par.parent().width();
        $(document).on("mousemove", function (event) {
            var mx = event.pageX;
            var nowX = parW + mx - x;
            if (nowX < 0 || nowX > maxW) {
                nowX = nowX < 0 ? 0 : maxW
            }
            VideoController.setVolumeAndProgress(nowX / maxW)
        });
        $(document).on("mouseup", function (event) {
            $(document).off("mousemove");
            $(document).off("mouseup")
        })
    });

    var VideoController = {
        volumeHornTag: $("#volume_horn_e"),
        volumeProgressTag: $("#volume_progress_e"),
        maxProgressWidth: $("#volume_max_e").width(),
        setVolumeAndProgress: function (val) {
            if (val === 0) {
                this.volumeHornTag.removeClass("statu_volume_off").addClass("statu_volume_on")
            } else if (val < 10) {
                this.volumeHornTag.removeClass("statu_volume_on").addClass("statu_volume_off")
            }
            this.volumeProgressTag.width(val * this.maxProgressWidth);
            document.getElementById('BikMousePlayer').setVolume(val);
            console.log(val);
        }
    }

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
        $(".viewer_num").html(data.number);
    });

    socket.on('room_message', function (data) {
        console.log(data.type);
        switch (data.type) {
            case 'start':
                addMessage('start', data.user);
                setTimeout(function () {
                    document.getElementById('BikMousePlayer').playAgain();
                }, 5000);
                socket.emit('room_join_user');
                break;
            case 'end':
                addMessage('end', data.user);
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
                    '<span class="user_text_content">' + 'This broadcast has been stopped.'+ '</span>' +
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