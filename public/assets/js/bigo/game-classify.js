$(function () {
    var APP = APP || {};
    APP.rootpath = APP.rootpath || $('meta[name="root-path"]').attr('content');

    var vue_app_game_list = new Vue({
        el: '#vue_app_game_list',
        data: {
            itempath: $('body').data('broadcastviewurl'),
            classify: $(".page_wrap").data('classifyid'),
            rootpath: APP.rootpath,
            todos: [],
            offset: 0,
            limit: 20,
            nodata: false
        }
    });

    $.getJSON($('body').data('gamelisturl'), {
        'classify': vue_app_game_list.classify,
        'offset': vue_app_game_list.offset,
        'limit': vue_app_game_list.limit
    }, function (json) {
        vue_app_game_list.todos = json;
    });

    APP.adjustGameListSize = function () {
        var respondStyle = $('<style id="respondStyle"></style>');
        $('head').append(respondStyle);
        var marginWrap = $('#game_margin_wrap_e');
        var marginWrapWidth = 0;
        var room_item_w = 0;
        var classify_item_w = 0;
        return function () {
            if ($('body').height() < $(window).height()) {
                APP.adjustGameListSizeId = setTimeout(APP.adjustGameListSize, 150);
                return;
            }
            marginWrapWidth = marginWrap.width() + 25;
            room_item_w = marginWrapWidth / Math.round(marginWrapWidth / 280);
            classify_item_w = marginWrapWidth / Math.round(marginWrapWidth / 200);
            var str = '';
            str += '.bigo_room_list .room_cover{width:' + Math.floor(room_item_w - 25) + 'px !important;}';
            str += '.show_live_ul_box .room_cover{height:' + (room_item_w - 25) + 'px !important;}';
            str += '.game_live_ul_box .room_cover{height:' + (room_item_w - 25) * (9 / 16) + 'px !important;}';
            str += '.classify_content li{width:' + Math.floor(classify_item_w - 25) + 'px !important;height:' + (Math.floor(classify_item_w - 25) * 242 / 174 + 40) + 'px !important;}';
            str += '.classify_line_one{height:' + ((classify_item_w - 25) * 242 / 174 + 40) + 'px !important;}';
            respondStyle.html(str);
        }
    }();
    setTimeout(APP.adjustGameListSize, 200);
    APP.adjustGameListSizeId = 0;

    $(window).on('resize', function (event) {
        event.preventDefault();
        clearTimeout(APP.adjustGameListSizeId);
        APP.adjustGameListSizeId = setTimeout(APP.adjustGameListSize, 100);
    });

    APP.bodyHeight = $('body').height();
    APP.windowHeight = $(window).height();
    APP.windowScroll = 1;
    APP.loadAjaxScrollTimeOut = '';
    var loadAjaxScroll = function () {
        if (APP.windowScroll) {
            if ($(window).scrollTop() + APP.windowHeight > APP.bodyHeight - 100) {
                APP.windowScroll = 0;
                vue_app_game_list.offset = vue_app_game_list.offset + vue_app_game_list.limit;
                if (!vue_app_game_list.nodata) {
                    $.getJSON($('body').data('gamelisturl'), {
                        'classify': vue_app_game_list.classify,
                        'offset': vue_app_game_list.offset,
                        'limit': vue_app_game_list.limit
                    }, function (res) {
                        if (res.length == 0) {
                            vue_app_game_list.nodata = true;
                        }
                        vue_app_game_list.todos = vue_app_game_list.todos.concat(res);
                        APP.bodyHeight = APP.bodyHeight + 300;
                        setTimeout(function () {
                            APP.bodyHeight = $('body').height();
                            APP.windowScroll = 1;
                            APP.checkAutoLoadAjax();
                        }, 300);
                    });
                }
            }
        } else {
            return false;
        }
    };
    APP.checkAutoLoadAjax = function () {
        if ($(window).scrollTop() + APP.windowHeight > APP.bodyHeight - 100) {
            loadAjaxScroll();
        }
    };
    $(window).on('scroll', function (event) {
        if (APP.windowScroll) {
            clearTimeout(APP.loadAjaxScrollTimeOut);
            APP.loadAjaxScrollTimeOut = setTimeout(loadAjaxScroll, 200);
        }
    });
});
